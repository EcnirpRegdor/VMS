<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VisitorLog;
use App\Exports\VLogExport;
use Maatwebsite\Excel\Facades\Excel;

use App\Repositories\VisitorRepositoryInterface;
use App\Repositories\DepartmentRepositoryInterface;
use Illuminate\Validation\ValidationException;


class LogsController extends Controller
{
    protected $visitorRepository;
    protected $departmentRepository;
    protected $paginationRows;
    public function __construct(VisitorRepositoryInterface $visitorRepository, DepartmentRepositoryInterface $departmentRepository, Request $request)
    {
        $this->visitorRepository = $visitorRepository;
        $this->departmentRepository = $departmentRepository;
        $this->paginationRows = $request->cookie('pagination', 30);
    }

    public function editLog(Request $request){
        try{

        if(auth()->user()->dept_id !== 0){
            $validated = $request->validate([
                "visited_at" => "required",
                "purpose" => "required|string",
                "id" => "required"
            ]);
        }
        else{
            $validated = $request->validate([
                "visited_at" => "required",
                "purpose" => "required|string",
                "dept_id"=> "required|integer",
                "id" => "required"
            ]); 
        }

        $validated['purpose'] = strip_tags($validated['purpose']);
        $getId = $validated['id'];

        $logs = VisitorLog::findOrFail($getId);
        if(auth()->user()->id == $logs->user_id || auth()->user()->role == "admin" || auth()->user()->role == "moderator"){
           $logs->update($validated);
            return redirect()->back()->with("success","Successfully Edited Log");
        }else{
            return redirect()->back()->with("fail","You do not have permissions to edit this log");
        }

        } catch (ValidationException $e) {
            \Log::error('Validation failed: ', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function viewLogs(Request $request){
        if($id = auth()->user()->dept_id !== 0){
            $logs = VisitorLog::where('dept_id', '=', $id);

        }
        else{
            $logs = VisitorLog::query();
        }

        $logs->join('visitors', 'visitor_logs.visitor_id', '=', 'visitors.id')->select('visitor_logs.*', 'visitors.id as visitorsid', 
        'visitors.first_name', 'visitors.last_name' , 'visitors.email');
        
        $check = $request->filled('sort') && $request->filled('by');

        if($check){
            $logs->orderBy($request->by, $request->sort);

            $searchParams = [
                'sort' => $request->sort,
                'by' => $request->by,
            ];
        }else{
            $logs->latest();
        }

        $logs = $logs->paginate($this->paginationRows);

        if($check){
            $logs->appends($searchParams);
        }

        $visitors = $this->visitorRepository->showVisitors();
        $departments = $this->departmentRepository->showDepartments();
        return view('logs', compact('logs', 'visitors', 'departments'));
    }

    public function viewLogsAdmin($getDeptId, Request $request){ 
        if(auth()->user()->dept_id !== 0){
            return redirect()->back()->with('fail', 'You do not have permission to view this page');
        }
        elseif($getDeptId == 0){
            $logs = VisitorLog::query();
        }
        else{
            $logs = VisitorLog::where('dept_id', '=', $getDeptId);
        }

        
        $check = $request->filled('sort') && $request->filled('by');

        if($check){
            $logs->orderBy($request->by, $request->sort);

            $searchParams = [
                'sort' => $request->sort,
                'by' => $request->by,
            ];
        }else{
            $logs->latest();
        }

        $logs = $logs->paginate($this->paginationRows);

        if($check){
            $logs->appends($searchParams);
        }

        $visitors = $this->visitorRepository->showVisitors();
        $departments = $this->departmentRepository->showDepartments();
        return view('logs', compact('logs', 'visitors', 'departments', 'getDeptId'));
    }

    public function searchFilterLogs(Request $request){

        if($id = auth()->user()->dept_id !== 0){
            $logs = VisitorLog::where('dept_id', '=', $id);
        }else{
            $logs = VisitorLog::query();
        }
        
        $visitor = $this->visitorRepository->showVisitors();
        
        $departments = $this->departmentRepository->showDepartments();

        $logs->join('visitors', 'visitor_logs.visitor_id', '=', 'visitors.id')->select('visitor_logs.*', 'visitors.id as visitorsid', 
        'visitors.last_name');

        if(!empty($request->search)){
            $searchfields = ['visitor_logs.id', 'visitor_id', 'visitor_logs.created_at', 'visited_at', 'visitors.first_name', 'visitors.last_name', 'visitors.email'];
            $logs->where(function($query) use($request, $searchfields){
                $searchWildCard = '%' . $request->search . '%';
                foreach ($searchfields as $field){
                    $query->orWhere($field,'LIKE', $searchWildCard);
                }
            });
            
        }

        $searchParams = [
            'search' => $request->search,
            'sort' => $request->sort,
            'by' => $request->by,
        ];

        $check = $request->filled('sort') && $request->filled('by');

        if($check){
            $logs->orderBy($request->by, $request->sort);

        }else{
            $logs->latest('visitor_logs.created_at');
        }

        $logs = $logs->paginate($this->paginationRows);

        if($check){
            $logs->appends($searchParams);
        }
        
        return view('logs', [
            'logs'=> $logs,
            'visitors'=> $visitor,
            'departments'=> $departments,
        ]);
    }

    public function searchFilterLogsAdmin(Request $request, $id){
        if(auth()->user()->dept_id !== 0){
            return redirect()->back()->with('fail', 'You do not have permission to view this page');
        }else{
            $logs = VisitorLog::where('dept_id', '=', $id);
        }

        $visitor = $this->visitorRepository->showVisitors();
        
        $departments = $this->departmentRepository->showDepartments();

        $logs->join('visitors', 'visitor_logs.visitor_id', '=', 'visitors.id')->select('visitor_logs.*', 'visitors.id as visitorsid', 
        'visitors.first_name', 'visitors.last_name');

        if(!empty($request->search)){
            $searchfields = ['visitor_logs.id', 'visitor_id', 'visitor_logs.created_at', 'visited_at', 'visitors.first_name', 'visitors.last_name'];
            $logs->where(function($query) use($request, $searchfields){
                $searchWildCard = '%' . $request->search . '%';
                foreach ($searchfields as $field){
                    $query->orWhere($field,'LIKE', $searchWildCard);
                }
            });
        }

        $searchParams = [
            'search' => $request->search,
            'sort' => $request->sort,
            'by' => $request->by,
        ];

        $check = $request->filled('sort') && $request->filled('by');

        if($check){
            $logs->orderBy($request->by, $request->sort);

        }else{
            $logs->latest('visitor_logs.created_at');
        }

        $logs = $logs->paginate($this->paginationRows);

        if($check){
            $logs->appends($searchParams);
        }
 
        return view('logs', [
            'logs'=> $logs,
            'visitors'=> $visitor,
            'departments'=> $departments,
            'getDeptId' => $id
        ]);
    }

    public function spsearchFilterLogsAdmin(Request $request, $id){
        if(auth()->user()->dept_id !== 0){
            return redirect()->back()->with('fail', 'You do not have permission to view this page');
        }else{
            $logs = VisitorLog::where('dept_id', '=', $id);
        }

        
        
        $visitor = $this->visitorRepository->showVisitors();
        
        $departments = $this->departmentRepository->showDepartments();
    
        $searchParams = [
            'firstNameSearch' => $request->input('firstNameSearch'),
            'lastNameSearch' => $request->input('lastNameSearch'),
            'emailSearch' => $request->input('emailSearch'),
            'contactSearch' => $request->input('contactSearch'),
            'idSearch' => $request->input('idSearch'),
            'DateSearch' => $request->input('DateSearch'),
    
            'weekSearch' => $request->input('weekSearch'),
            'monthSearch' => $request->input('monthSearch'),
            'yearSearch' => $request->input('yearSearch'),
            'sort' => $request->input('sort'),
            'by' => $request->input('by'),

            ];
    
        $logs->join('visitors', 'visitor_logs.visitor_id', '=', 'visitors.id')->select('visitor_logs.*', 'visitors.id as visitorsid', 
        'visitors.first_name', 'visitors.last_name', 'visitors.email', 'visitors.contact');
    
        if ($searchParams['firstNameSearch']) {
            $logs->where('visitors.first_name', 'LIKE', '%' . $searchParams['firstNameSearch'] . '%');
        }
        if ($searchParams['lastNameSearch']) {
            $logs->where('visitors.last_name', 'LIKE', '%' . $searchParams['lastNameSearch'] . '%');
        }
        if ($searchParams['emailSearch']) {
            $logs->where('visitors.email', 'LIKE', '%' . $searchParams['emailSearch'] . '%');
        }
        if ($searchParams['contactSearch']) {
            $logs->where('visitors.contact', 'LIKE', '%' . $searchParams['contactSearch'] . '%');
        }
        if ($searchParams['idSearch']) {
            $logs->where('visitors.id', 'LIKE', '%' . $searchParams['idSearch'] . '%');
        }
        if ($searchParams['DateSearch']) {
            $logs->whereDate('visited_at', '=', $searchParams['DateSearch']);
        }
        if ($searchParams['weekSearch']) {
            $date = \Carbon\CarbonImmutable::parse($searchParams['weekSearch']);
    
            $startOfWeek = $date->startOfWeek();
            $endOfWeek = $date->endOfWeek();
        
            $logs->whereBetween('visited_at', [$startOfWeek, $endOfWeek]);

        }
        if ($searchParams['yearSearch']) {

            $logs->whereYear('visited_at', '=', $searchParams['yearSearch']);
        }
        if ($searchParams['monthSearch']) {
            $date = \Carbon\Carbon::parse($searchParams['monthSearch'])->month;
            $dateYear = \Carbon\Carbon::parse($searchParams['yearSearch'])->year;

            $logs->whereYear('visited_at', '=', $dateYear)
            ->whereMonth('visited_at', '=', $date);
        }
    
        $logs->select('visitor_logs.*');
    
        $check = $request->filled('sort') && $request->filled('by');

        if($check){
            $logs->orderBy($request->by, $request->sort);

        }else{
            $logs->latest('visitor_logs.created_at');
        }

        $logs = $logs->paginate($this->paginationRows);
    
        return view('logs', [
            'visitors' => $visitor,
            'logs' => $logs->appends($searchParams),
            'departments' => $departments,
            'getDeptId' => $id,
        ]);
    }

    public function spsearchFilterLogs(Request $request)
    {
        if($id = auth()->user()->dept_id !== 0){
            $logs = VisitorLog::where('dept_id', '=', $id);
        }else{
            $logs = VisitorLog::query();
        }
        
        $visitor = $this->visitorRepository->showVisitors();
        
        $departments = $this->departmentRepository->showDepartments();
        
        $searchParams = [
        'firstNameSearch' => $request->input('firstNameSearch'),
        'lastNameSearch' => $request->input('lastNameSearch'),
        'emailSearch' => $request->input('emailSearch'),
        'contactSearch' => $request->input('contactSearch'),
        'idSearch' => $request->input('idSearch'),
        'DateSearch' => $request->input('DateSearch'),

        'weekSearch' => $request->input('weekSearch'),
        'monthSearch' => $request->input('monthSearch'),
        'yearSearch' => $request->input('yearSearch'),
        'sort' => $request->input('sort'),
        'by' => $request->input('by'),
        ];
    
        $logs->join('visitors', 'visitor_logs.visitor_id', '=', 'visitors.id')->select('visitor_logs.*', 'visitors.id as visitorsid', 
        'visitors.first_name', 'visitors.last_name', 'visitors.email', 'visitors.contact');
    
        
        if ($searchParams['firstNameSearch']) {
            $logs->where('visitors.first_name', 'LIKE', '%' . $searchParams['firstNameSearch'] . '%');
        }
        if ($searchParams['lastNameSearch']) {
            $logs->where('visitors.last_name', 'LIKE', '%' . $searchParams['lastNameSearch'] . '%');
        }
        if ($searchParams['emailSearch']) {
            $logs->where('visitors.email', 'LIKE', '%' . $searchParams['emailSearch'] . '%');
        }
        if ($searchParams['contactSearch']) {
            $logs->where('visitors.contact', 'LIKE', '%' . $searchParams['contactSearch'] . '%');
        }
        if ($searchParams['idSearch']) {
            $logs->where('visitors.id', 'LIKE', '%' . $searchParams['idSearch'] . '%');
        }
        if ($searchParams['DateSearch']) {
            $logs->whereDate('visited_at', '=', $searchParams['DateSearch']);
        }
        if ($searchParams['weekSearch']) {
            $date = \Carbon\CarbonImmutable::parse($searchParams['weekSearch']);
    
            $startOfWeek = $date->startOfWeek();
            $endOfWeek = $date->endOfWeek();
        
            $logs->whereBetween('visited_at', [$startOfWeek, $endOfWeek]);

        }
        if ($searchParams['yearSearch']) {
            $logs->whereYear('visited_at', '=', $searchParams['yearSearch']);
        }
        if ($searchParams['monthSearch']) {
            $date = \Carbon\Carbon::parse($searchParams['monthSearch'])->month;
            $dateYear = \Carbon\Carbon::parse($searchParams['yearSearch'])->year;

            $logs->whereYear('visited_at', '=', $dateYear)
            ->whereMonth('visited_at', '=', $date);
        }

        $logs->select('visitor_logs.*');

        $check = $request->filled('sort') && $request->filled('by');

        if($check){
            $logs->orderBy($request->by, $request->sort);

        }else{
            $logs->latest('visitor_logs.created_at');
        }

        $logs = $logs->paginate($this->paginationRows);

        $logs->appends($searchParams);
    
        return view('logs', [
            'visitors' => $visitor,
            'logs' => $logs,
            'departments' => $departments,
        ]);
    }

    public function createLog(Request $request){
        try{

        if(auth()->user()->dept_id !== 0){
            $visitorlog = $request->validate([
                    "visited_at" => "required",
                    "purpose" => "required|string",
                    "visitor_id" => "required"
            ]);
            $visitorlog['dept_id'] = auth()->user()->dept_id;
        }
        else{
        $visitorlog = $this->validate($request, [
            'visitor_id'=> 'required',
            'visited_at'=> 'required|date',
            'dept_id'=> 'required',
            'purpose'=> 'required',
        ]);
        }
        $visitorlog['user_id'] = auth()->user()->id;

        VisitorLog::create($visitorlog);
        return redirect("logs")->with('success','Successfully Added Log');
        } catch (ValidationException $e) {
            \Log::error('Validation failed: ', $e->errors());

            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function downloadExcel(Request $request){
        try{
        $visitorlog = $this->validate($request, [
            'id' => 'required',
            'getDeptAdmin' => 'nullable',
        ]);         

        $idAccess = $visitorlog['id'];

        if ($idAccess != 0) {
            
            $departments = $this->departmentRepository->showDepartments()->where('id', $idAccess)->first();
            $getDeptName = $departments->dept_name;
            
            return Excel::download(new VLogExport, $getDeptName . '_Logs.xlsx');
        }else{
            if(isset($visitorlog['getDeptAdmin'])){

                $departments = $this->departmentRepository->showDepartments()->where('id', $visitorlog['getDeptAdmin'])->first();
                $getDeptName = $departments->dept_name;
                
                \Log::info('DownloadExcel: Ran first if' .  'Dept Id: ' . $visitorlog['getDeptAdmin']);
                return Excel::download(new VLogExport($visitorlog['getDeptAdmin']), $getDeptName . '_Logs.xlsx');
            }else{
                
            \Log::info('DownloadExcel: Ran else' . 'Dept Id: ' . 'N/A');
            return Excel::download(new VLogExport, 'Visitor_Logs.xlsx');
            }
        }
        } catch (ValidationException $e) {
            \Log::error('Validation failed: ', $e->errors());

            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function deleteLog(Request $request){
        try{
        $visitorlog = $request->validate( [
            'id'=> 'required|int',  
        ]);

        $getId = $visitorlog['id'];
        
        $deleteLog = VisitorLog::findOrFail($getId);
        if(auth()->user()->id == $deleteLog->user_id || auth()->user()->role == "admin" || auth()->user()->role == "moderator"){
        
            $deleteLog->delete();
            return redirect()->back()->with('success','Successfully Deleted Log');
        }else{
            return redirect()->back()->with('fail','You do not have permission to delete this log');
        }

        } catch (ValidationException $e) {
            \Log::error('Validation failed: ', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }
}
