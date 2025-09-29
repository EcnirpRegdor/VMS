<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visitor;
use App\Repositories\DepartmentRepositoryInterface;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
class VisitorController extends Controller
{   
    protected $departmentRepository;
    protected $paginationRows;
    
    public function __construct(DepartmentRepositoryInterface $departmentRepository, Request $request)
    {
        $this->departmentRepository = $departmentRepository;
        $this->paginationRows = request()->cookie('pagination', 30);
    }
    public function searchFilter(Request $request){
    
        $departmentId = $request->input('getDID') ?? $request->cookie('getDID') ?? $_COOKIE['getDID'] ?? null;
        $departments = $this->departmentRepository->showDepartments();
        $visitor = Visitor::query();

        if(!empty($request->search)){
            $searchfields = ['ID', 'first_name', 'last_name', 'email', 'contact', 'created_at', 'affiliation'];
            $visitor->where(function($query) use($request, $searchfields){
                $searchWildCard = '%' . $request->search . '%';
                foreach ($searchfields as $field){
                    $query->orWhere($field,'LIKE', $searchWildCard);
                }
            });
        }

        $searchParams = [
            'getDID' => $departmentId,
            'search' => $request->search,
            'sort' => $request->sort,
            'by' => $request->by,
        ];
        
        $visitor = $visitor->with('logs.user:id,name');

        if($request->sort && $request->by){
            $visitor->orderBy($request->by, $request->sort);
        }else{
            $visitor->latest();
        }

        if($departmentId && auth()->user()->dept_id == 0 || $departmentId && auth()->user()->dept_id == $departmentId){
            $visitor->whereHas('logs', function ($query) use ($departmentId) {
                $query->where('dept_id', $departmentId);
            });
        }

        $visitor = $visitor->paginate($this->paginationRows)->appends($searchParams);

        return view('visitors', [
            'visitors'=> $visitor,
            'departments' => $departments,
        ]);
    }
    public function searchFilterVisitors(Request $request)
    {
        
        $departmentId = $request->input('getDID') ?? $request->cookie('getDID') ?? $_COOKIE['getDID'] ?? null;
        $departments = $this->departmentRepository->showDepartments();
        $visitor = Visitor::query();
        
        $searchParams = [
        'firstNameSearch' => $request->input('firstNameSearch'),
        'lastNameSearch' => $request->input('lastNameSearch'),
        'emailSearch' => $request->input('emailSearch'),
        'contactSearch' => $request->input('contactSearch'),
        'idSearch' => $request->input('idSearch'),
        'DateSearch' => $request->input('DateSearch'),
        'getDID' => $departmentId,
        
        'weekSearch' => $request->input('weekSearch'),
        'monthSearch' => $request->input('monthSearch'),
        'yearSearch' => $request->input('yearSearch'),
        'sort' => $request->input('sort'),
        'by' => $request->input('by'),
        ];

        if ($searchParams['firstNameSearch']) {
            $visitor->where('first_name', 'LIKE', '%' . $searchParams['firstNameSearch'] . '%');
        }
        if ($searchParams['lastNameSearch']) {
            $visitor->where('last_name', 'LIKE', '%' . $searchParams['lastNameSearch'] . '%');
        }
        if ($searchParams['emailSearch']) {
            $visitor->where('email', 'LIKE', '%' . $searchParams['emailSearch'] . '%');
        }
        if ($searchParams['contactSearch']) {
            $visitor->where('contact', 'LIKE', '%' . $searchParams['contactSearch'] . '%');
        }
        if ($searchParams['idSearch']) {
            $visitor->where('id', 'LIKE', '%' . $searchParams['idSearch'] . '%');
        }
        if ($searchParams['DateSearch']) {
            $visitor->wheredate('created_at', '=' ,$searchParams['DateSearch']);
        }
        if ($searchParams['weekSearch']) {
            
            $date = \Carbon\CarbonImmutable::parse($searchParams['weekSearch']);
    
            $startOfWeek = $date->startOfWeek();
            $endOfWeek = $date->endOfWeek();
        
            $visitor->whereBetween('created_at', [$startOfWeek, $endOfWeek]);

        }
        if ($searchParams['yearSearch']) {
            
            $visitor->whereYear('created_at', '=', $searchParams['yearSearch']);
        }
        if ($searchParams['monthSearch']) {
            $date = \Carbon\Carbon::parse($searchParams['monthSearch'])->month;
            $dateYear = \Carbon\Carbon::parse($searchParams['yearSearch'])->year;

            $visitor->whereYear('created_at', '=', $dateYear)
            ->whereMonth('created_at', '=', $date);
        }

        $visitor = $visitor->with('logs.user:id,name');
    
        if($searchParams['sort'] && $searchParams['sort'] === 'desc'){
           $visitor->orderBy($searchParams['by'], 'DESC');
        }elseif($searchParams['sort'] && $searchParams['sort'] === 'asc'){
            $visitor->orderBy($searchParams['by'], 'ASC');
        }
        else
        {
            $visitor->latest(); 
        }

        
        if($departmentId && auth()->user()->dept_id == 0 || $departmentId && auth()->user()->dept_id == $departmentId){
            $visitor->whereHas('logs', function ($query) use ($departmentId) {
                $query->where('dept_id', $departmentId);
            });
        }

        $visitor = $visitor->paginate($this->paginationRows);

        return view('visitors', [
            'departments' => $departments,
            'visitors' => $visitor->appends($searchParams),
        ]);
    }

    public function createVisitor(Request $request){

        $departmentId = $request->cookie('getDID') ?? $_COOKIE['getDID'] ?? null;
        try{
        $visitor = $request->validate([
            "first_name" =>  "required",
            "last_name"=> "required",
            "email" => "required|email|unique:visitors,email",
            "contact" => "required",
            "affiliation"=> "nullable|string",
            "address"=> "required",
        ]);

        if($request->hasFile('image')){
            $request->validate([
                'image'=> 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $path = $request->file('image')->store('uploads','public');
            
            $visitor["profile_image"] = $path;
        }

        $visitor["user_id"] = auth()->user()->id;

        Visitor::create($visitor);
        \Log::info('Visitor creation request received', ['data' => $request->all()]);
        
        return redirect('/visitors')->appends(['getDID' => $departmentId])->with("success","Visitor: " . $visitor['first_name'] . " Successfully added");
        } catch (ValidationException $e) {
            \Log::error('Validation failed: ', $e->errors());

            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function editVisitor(Request $request){
        try{
        $visitor = $request->validate([
            "first_name"=> "required",
            "last_name"=> "required",
            "email" => [
                'required',
                'email',
                Rule::unique('visitors')->ignore($request->id),
             ],
            "address"=> "required",
            "contact"=> "required",
            "affiliation"=> "nullable|string",
            "id" => "required|exists:visitors,id",
        ]);

        $getId = $visitor['id'];
        unset($visitor['id']);

        if($request->hasFile('image')){
            $request->validate([
                'image'=> 'image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            $path = $request->file('image')->store('uploads','public');
            $visitor["profile_image"] = $path;
        }

        
        if($visitorTable = Visitor::findOrFail($getId)){

            if(auth()->user()->id == $visitorTable->user_id || auth()->user()->role == "admin"){
                $visitorTable->update($visitor);
                return redirect()->back()->with("success","Visitor: " . $visitor['first_name'] . " successfully edited");
            }
            elseif(auth()->user()->role == "moderator"){

                    $visitorTable->update($visitor);

            }else{
                return redirect()->back()->with("fail", "You do not have permission to edit this");
            }
            

        }else{
        return redirect()->back()->with("fail", "Error occured when updating visitor");
        }

        } catch (ValidationException $e) {
            \Log::error('Validation failed: ', $e->errors());

            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function viewVisitor(Request $request){
        $departmentId = $request->input('getDID') ?? $_COOKIE['getDID'] ?? null;
        $departments = $this->departmentRepository->showDepartments();
        $visitors = Visitor::with('logs.user:id,name');

        if($request->sort && $request->by){
            $visitors->orderBy($request->by, $request->sort);
      
            $searchParams = [
                'getDID' => $request->getDID,
                'sort' => $request->sort,
                'by' => $request->by,
            ];
        }else{
            
            $visitors->latest();
        }

        
        if($departmentId && auth()->user()->dept_id == 0 || $departmentId && auth()->user()->dept_id == $departmentId){
            $visitors->whereHas('logs', function ($query) use ($departmentId) {
                $query->where('dept_id', $departmentId);
            });
        }

        
        $visitors = $visitors->paginate($this->paginationRows);        

        if($request->sort && $request->by){
            $visitors->appends($searchParams);
        }

        return view('visitors', compact('visitors', 'departments'));
    }


}
