<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\VisitorLog;

use App\Repositories\VisitorRepositoryInterface;
use App\Repositories\DepartmentRepositoryInterface;

class DashboardController extends Controller
{
    protected $visitorRepository;
    protected $departmentRepository;

    public function __construct(VisitorRepositoryInterface $visitorRepository, DepartmentRepositoryInterface $departmentRepository)
    {
        $this->visitorRepository = $visitorRepository;
        $this->departmentRepository = $departmentRepository;
    }

    public function getVisitsData($deptId = null, Request $request){
        $user = auth()->user();
        $period = $request->input('period', 'daily');
        
        $query = VisitorLog::query();

        if($user->dept_id != 0){
            $query->where('dept_id', '=', $user->dept_id);
        }
        elseif($deptId !== null && $deptId !== '0'){
            $query->where('dept_id', $deptId);
        }

        if ($period === 'daily') {
            $query->selectRaw('DATE(visited_at) as date, COUNT(*) as total')
                  ->groupBy(DB::raw('DATE(visited_at)'))
                  ->orderBy('date');
                  
            $data = $query->get()->map(function ($row) {
                return [
                    'x' => strtotime($row->date) * 1000,
                    'y' => $row->total
                ];
            });
        } elseif ($period === 'monthly') {
            $query->selectRaw('DATE_FORMAT(visited_at, "%Y-%m") as date, COUNT(*) as total')
                  ->groupBy(DB::raw('DATE_FORMAT(visited_at, "%Y-%m")'))
                  ->orderBy('date');
                  
            $data = $query->get()->map(function ($row) {
                return [
                    'x' => strtotime($row->date) * 1000,
                    'y' => $row->total
                ];
            });
        } elseif ($period === 'yearly') {
            $query->selectRaw('YEAR(visited_at) as date, COUNT(*) as total')
                  ->groupBy(DB::raw('YEAR(visited_at)'))
                  ->orderBy('date');
                  
            $data = $query->get()->map(function ($row) {
                return [
                    'x' => strtotime($row->date . '-01-01') * 1001 ?? 'Unknown Year',
                    'y' => $row->total ?? 0,
                ];
            });
        }

        \Log::info($user->dept_id .' '. $deptId .' '. $query->toSql());

    return response()->json($data);

    }

    public function viewDashboard(){
        $visitors = $this->visitorRepository->showVisitors();
        $departments = $this->departmentRepository->showDepartments();
        
        if(auth()->user()->dept_id != 0){
            $logsQuery = VisitorLog::where("dept_id",'=', auth()->user()->dept_id)->latest();
        }else{
            $logsQuery = VisitorLog::latest();
        }

        $logs = $logsQuery->get();

        return view("/dashboard", compact("visitors","departments","logs"));
    }

    public function sViewDashboard($id){
        
        $visitors = $this->visitorRepository->showVisitors();
        $departments = $this->departmentRepository->showDepartments();
        
        if(auth()->user()->dept_id != 0){
            return redirect()->back()->with('fail', 'You do not have permission to view this page.');
        }elseif($id == 0){
            $logsData = VisitorLog::query();
        }else
        {
            $logsData = VisitorLog::where('dept_id', '=', $id);
        }

        $logs = $logsData->latest()->get();

        return view("/dashboard", compact("visitors","departments","logs"));
    }
}
