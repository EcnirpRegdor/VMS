<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Jenssegers\Agent\Agent;

class GeneralLog extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $fillable = [
        "action",
        "user_id",
        "row_id",
        "table_name",
        "description",
        "changes",
        "ip_address",
        "device_name",
        "device_model",
        "device_type",
        "device_platform",
    ];

    public static function log($action, $table, $rowId, $description, $changes = null){

        $agent = new Agent();
        
        $device = $agent->device();
        $deviceplatform = $agent->platform();

        $userAgent = request()->server('HTTP_USER_AGENT');
        $devicemodel = self::getDeviceModel($userAgent);
        $devicetype = $agent->isMobile() ? 'Mobile' : ($agent->isTablet() ? 'Tablet' : ($agent->isDesktop() ? 'Desktop' : 'Unknown'));

        if(isset(auth()->user()->id)){
            self::create([
                "action"=> $action,
                "table_name"=> $table,
                "row_id"=> $rowId,
                "description"=> $description,
                "changes"=> $changes ? json_encode($changes) : null,
                "user_id" => auth()->user()->id,
                "ip_address" => request()->ip(),
                "device_name" => $device,
                "device_platform" => $deviceplatform,
                "device_model" => $devicemodel,
                "device_type" => $devicetype,
            ]);

        }else{
        self::create([
            "action"=> $action,
            "table_name"=> $table,
            "row_id"=> $rowId,
            "description"=> $description,
            "changes"=> $changes ? $changes : null,
            "user_id" => null,
            "ip_address" => request()->ip(),
            "device_name" => $device,
            "device_platform" => $deviceplatform,
            "device_model" => $devicemodel,
            "device_type" => $devicetype,
            
        ]);
        }
    }

    public function user(){
        return $this->belongsTo(User::class, "user_id");
    }

    private static function getDeviceModel($userAgent)
    {
        if (preg_match('/iPhone OS (\d+_\d+)/', $userAgent, $matches)) {
            return 'iPhone ' . str_replace('_', '.', $matches[1]);
        } elseif (preg_match('/Android\s([0-9\.]+).*?;\s([^\s;]+)/', $userAgent, $matches)) {
            return 'Android ' . $matches[1] . ' ' . $matches[2];
        } elseif (preg_match('/Windows NT (\d+\.\d+)/', $userAgent, $matches)) {
            return 'Windows ' . $matches[1];
        } elseif (preg_match('/Mac OS X (\d+_\d+)/', $userAgent, $matches)) {
            return 'Mac OS X ' . str_replace('_', '.', $matches[1]);
        }

        return 'Unknown Device';
    }

}
