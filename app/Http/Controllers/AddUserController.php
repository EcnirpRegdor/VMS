<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\QueryException;
use Exception;
use Illuminate\Http\Request;

use App\Repositories\DepartmentRepositoryInterface;

class AddUserController extends Controller
{

    protected $departmentRepository;
    protected $paginationRows;

    public function __construct(DepartmentRepositoryInterface $departmentRepository, Request $request){
        $this->departmentRepository = $departmentRepository;
        $this->paginationRows = request()->cookie('pagination', 30);
    }
    public function addUser(Request $request){

        try{

        if(auth()->user()->dept_id == 0){
        $validate = $request->validate([
            'name' => 'required|string',
            'password' => 'required|string|min:8',
            'dept_id' => 'required',
            'email' => 'required|email|unique:users,email',
            'role' => 'required|in:moderator,admin,user',
        ]);

            
            $user = new User();
            $user->name = $validate['name'];
            $user->dept_id = $validate['dept_id'];
            $user->role = $validate['role'];
            $user->email = $validate['email'];
        }else{
            $validate = $request->validate([
                'name' => 'required|string',
                'password' => 'required|string|min:8',
                'email' => 'required',
                'role' => 'required|in:moderator,admin,user',
            ]);
            
            $user = new User();
            $user->name = $validate['name'];
            $user->role = $validate['role'];
            $user->email = $validate['email'];
            $user->dept_id = auth()->user()->dept_id;
        }

        $hashedPassword = \Hash::make($validate['password']);
        
        $user->password = $hashedPassword;

            try{
            $user->save();
            return redirect('add-user')->with('success', 'Successfully added user');
            }catch(QueryException $e){
                if ($e->getCode() == 23000) {
                    return redirect()->back()->withErrors(['email' => 'The email has already been taken.']);
                }
            }
        }
        catch(ValidationException $e){
            \Log::error('Validation failed: ', $e->errors());

            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function viewUser(Request $request){
        if($id = auth()->user()->dept_id !== 0){
            $users = User::where('dept_id', '=', $id)->select("id", "name", "email", "dept_id", "role", "created_at", "updated_at")->latest()->paginate($this->paginationRows);
        }
        else{
            $users = User::query();
        }

        if(isset($request->by) && isset($request->sort)){
            $searchParams = [
                'sort' => $request->sort,
                'by' => $request->by,
            ];

            $users->orderBy($searchParams['by'], $searchParams['sort']);
        }else{
            $users->latest();
        }

        $users = $users->paginate($this->paginationRows);

        $departments = $this->departmentRepository->showDepartments();
        return view('add-users', compact('users', 'departments'));
    }

    public function editUser(Request $request){
        try{
            $getId = $request->id;
            $getUser = User::findOrFail($getId);
            if(auth()->user()->id == $request->id){
                $editUser = $request->validate([
                    "id" => "required",
                    'name' => 'required|string',
                    'email' => 'nullable|unique:users,email,' . $request->id,
                    'password' => 'nullable|string|min:8',
                ]);

                if(empty($editUser['password'])){
                    $editUser['password'] = $getUser->password;
                }else{
                    $editUser['password'] = \Hash::make($editUser['password']);
                }

                if($editUser['email'] != auth()->user()->email && auth()->user()->provider == "azure"){
                    return redirect()->back()->with('fail', 'You cannot edit your email under connection with azure');
                }

                $getUser->update($editUser);
                return redirect()->back()->with('success', 'Successfully edited profile');
            }
            elseif(auth()->user()->dept_id == 0 && auth()->user()->role == "admin"){
                $editUser = $request->validate([
                    "id" => "required",
                    'name' => 'required|string',
                    'email' => 'required|unique:users,email,' . $request->id,
                    'password' => 'nullable|string|min:8',
                    'dept_id' => 'required',
                    'role' => 'required|in:moderator,admin,user',
                ]);

                if(empty($editUser['password'])){
                    $editUser['password'] = $getUser->password;
                }else{
                    $editUser['password'] = \Hash::make($editUser['password']);
                }

                if($getUser->provider == "azure" && $getUser->email !== $editUser['email']){
                    return redirect()->back()->with('fail', 'Cannot edit email under connection with azure');
                }

                $getUser->update($editUser);
                return redirect('add-user')->with('success', 'Successfully edited user');
            }elseif(auth()->user()->dept_id == $getUser->dept_id && auth()->user()->role == "admin"){

                if(isset($request->dept_id)){
                    return redirect()->back()->with('fail', 'You do not have permission to edit department ids');
                }

                $editUser = $request->validate([
                    "id" => "required",
                    'name' => 'required|string',
                    'email' => 'required',
                    'password' => 'nullable|string|min:8',
                    'role' => 'required|in:moderator,admin,user',
                ]);

                if(empty($editUser['password'])){
                    $editUser['password'] = $getUser->password;
                }else{
                    $editUser['password'] = \Hash::make($editUser['password']);
                }

                $getUser->update($editUser);
                return redirect('add-user')->with('success', 'Successfully edited user');
            }
            else{
                return redirect()->back()->with('fail', 'You do not have permission to edit this user');
            }
        }
        catch(ValidationException $e){
            \Log::error('Validation failed: ', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    public function deleteUser(Request $request){
        try{
            $requestUser = $request->validate([
                'id' => 'required|int',
            ]);

            $deleteUser = User::findOrFail($requestUser['id']);
            if(auth()->user()->dept_id == $deleteUser->dept_id && auth()->user()->role == "admin"){
                $deleteUser->delete();
                return redirect('add-user')->with('success', 'Successfully deleted user');
            }elseif(auth()->user()->dept_id == 0 && auth()->user()->role == "admin"){
                $deleteUser->delete();
                return redirect('add-user')->with('success', 'Successfully deleted user');
            }
        }
        catch(ValidationException $e){
            \Log::error('Validation failed: ', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }

    
    public function searchUser(Request $request){


        if($id = auth()->user()->dept_id !== 0){
            $users = User::where('dept_id', '=', $id);
        }else{
            $users = User::query();
        }

        $users->select('users.id', 'provider','name', 'email', 'dept_id', 'role', 'created_at', 'updated_at');
        
        $departments = $this->departmentRepository->showDepartments();

        if(!empty($request->search)){
            $searchfields = ['users.id', 'name', 'email', 'role', 'users.created_at', 'users.updated_at'];
            $users->where(function($query) use($request, $searchfields){
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
            $users->orderBy($request->by, $request->sort);

        }else{
            $users->latest('users.created_at');
        }

        $users = $users->paginate($this->paginationRows);

        if($check){
            $users->appends($searchParams);
        }
        
        return view('add-users', [
            'users'=> $users,
            'departments'=> $departments,
        ]);
    }

    public function spSearchUser(Request $request){
        if($id = auth()->user()->dept_id !== 0){
            $users = User::where('dept_id', '=', $id);
        }else{
            $users = User::query();
        }

        $departments = $this->departmentRepository->showDepartments();
            
        $searchParams = [
        'nameSearch' => $request->input('nameSearch'),
        'emailSearch' => $request->input('emailSearch'),
        'idSearch' => $request->input('idSearch'),
        'DateSearch' => $request->input('DateSearch'),
        'roleSearch' => $request->input('roleSearch'),
        'deptSearch' => $request->input('deptSearch'),

        'weekSearch' => $request->input('weekSearch'),
        'monthSearch' => $request->input('monthSearch'),
        'yearSearch' => $request->input('yearSearch'),
        'sort' => $request->input('sort'),
        'by' => $request->input('by'),
        ];

        $users->select('users.id', 'name', 'email', 'role', 'dept_id', 'provider','created_at', 'updated_at');

        if ($searchParams['nameSearch']) {
            $users->where('users.name', 'LIKE', '%' . $searchParams['nameSearch'] . '%');
        }
        if ($searchParams['roleSearch']) {
            $users->where('users.role', 'LIKE', '%' . $searchParams['roleSearch'] . '%');
        }
        if ($searchParams['emailSearch']) {
            $users->where('users.email', 'LIKE', '%' . $searchParams['emailSearch'] . '%');
        }
        if ($searchParams['deptSearch']) {
            $users->where('users.dept_id', 'LIKE', '%' . $searchParams['deptSearch'] . '%');
        }
        if ($searchParams['idSearch']) {
            $users->where('users.id', 'LIKE', '%' . $searchParams['idSearch'] . '%');
        }
        if ($searchParams['DateSearch']) {
            $users->whereDate('users.created_at', '=', $searchParams['DateSearch']);
        }
        if ($searchParams['weekSearch']) {
            $date = \Carbon\CarbonImmutable::parse($searchParams['weekSearch']);
    
            $startOfWeek = $date->startOfWeek();
            $endOfWeek = $date->endOfWeek();
        
            $users->whereBetween('users.created_at', [$startOfWeek, $endOfWeek]);

        }
        if ($searchParams['yearSearch']) {
            $date = \Carbon\Carbon::parse($searchParams['yearSearch'])->year;

            $users->whereYear('users.created_at', '=', $date);
        }
        if ($searchParams['monthSearch']) {
            $date = \Carbon\Carbon::parse($searchParams['monthSearch'])->month;
            $dateYear = \Carbon\Carbon::parse($searchParams['yearSearch'])->year;

            $users->whereYear('users.created_at', '=', $dateYear)
            ->whereMonth('users.created_at', '=', $date);
        }

        $check = $request->filled('sort') && $request->filled('by');

        if($check){
            $users->orderBy($request->by, $request->sort);

        }else{
            $users->latest('users.created_at');
        }

        $users = $users->paginate($this->paginationRows);

        $users->appends($searchParams);
    
        return view('add-users', [
            'users' => $users,
            'departments' => $departments,
        ]);
    }
}
