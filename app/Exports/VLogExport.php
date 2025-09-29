<?php

namespace App\Exports;

use App\Models\VisitorLog;
use Maatwebsite\Excel\Concerns\FromCollection;

use Maatwebsite\Excel\Concerns\WithHeadings;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class VLogExport implements FromCollection, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $deptId;

    public function __construct($deptId = null){
        $this->deptId = $deptId;
    }

    public function collection()
    {
        $deptGetAdmin = $this->deptId;

        //\Log::info('Dept Id: '. $deptGetAdmin);

        if($deptGetAdmin !== null || $deptGetAdmin != null){
            
            //\Log::info('Ran first if');
            return VisitorLog::join('visitors', 'visitor_logs.visitor_id', '=', 'visitors.id')
            ->join('departments','visitor_logs.dept_id','=','departments.id')
            ->join('users','visitor_logs.user_id','=','users.id')
            ->select('visitor_logs.id', 'visitors.last_name as Last Name', 'visitors.first_name as First Name', 'visitors.email as Email', 'visitor_logs.visited_at', 'visitor_logs.purpose', 'departments.dept_name as Department Name', 'visitor_logs.created_at', 'visitor_logs.updated_at', 'users.name')
            ->where('visitor_logs.dept_id', '=', $deptGetAdmin)
            ->get();


        }
        elseif($getid = auth()->user()->dept_id !== 0){
            
            //\Log::info('Ran second if');
            return VisitorLog::join('visitors', 'visitor_logs.visitor_id', '=', 'visitors.id')
            ->join('departments','visitor_logs.dept_id','=','departments.id')
            ->join('users','visitor_logs.user_id','=','users.id')
            ->select('visitor_logs.id', 'visitors.last_name as Last Name', 'visitors.first_name as First Name', 'visitors.email as Email', 'visitor_logs.visited_at', 'visitor_logs.purpose', 'departments.dept_name as Department Name', 'visitor_logs.created_at', 'visitor_logs.updated_at', 'users.name')
            ->where('visitor_logs.dept_id', '=', $getid)
            ->get();
        }
        else{
            
            //\Log::info('Ran else');
        return VisitorLog::join('visitors', 'visitor_logs.visitor_id', '=', 'visitors.id')
            ->join('departments','visitor_logs.dept_id','=','departments.id')
            ->join('users','visitor_logs.user_id','=','users.id')
            ->select('visitor_logs.id', 'visitors.last_name as Last Name', 'visitors.first_name as First Name', 'visitors.email as Email', 'visitor_logs.visited_at', 'visitor_logs.purpose', 'departments.dept_name as Department Name', 'visitor_logs.created_at', 'visitor_logs.updated_at', 'users.name')
            ->get();
        }
    }

    public function headings(): array

    {

        return [

            'Log ID',

            'Last Name',

            'First Name',

            'Email',

            'Date of Visit',

            'Purpose',

            'Department Name',

            'Created At',

            'Updated At',

            'Added By',
        ];

    }

    public function registerEvents(): array // Add this method
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getStyle('A1:J100')->getAlignment()->setWrapText(true); // Adjust range as needed

                $event->sheet->getColumnDimension('A')->setWidth(10); // Log ID
                $event->sheet->getColumnDimension('B')->setWidth(20); // Last Name
                $event->sheet->getColumnDimension('C')->setWidth(20); // First Name
                $event->sheet->getColumnDimension('D')->setWidth(30); // Email
                $event->sheet->getColumnDimension('E')->setWidth(20); // Date of Visit
                $event->sheet->getColumnDimension('F')->setWidth(30); // Purpose
                $event->sheet->getColumnDimension('G')->setWidth(30); // Department Name
                $event->sheet->getColumnDimension('H')->setWidth(20); // Created At
                $event->sheet->getColumnDimension('I')->setWidth(20); // Updated At
                $event->sheet->getColumnDimension('J')->setWidth(20); // Added By
            },
        ];
    }
}
