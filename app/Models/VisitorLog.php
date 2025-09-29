<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitorLog extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $table = 'visitor_logs';
    public $timestamps = true;
    protected $fillable = [
        "visited_at",
        "visitor_id",
        "user_id",
        "purpose",
        "dept_id",
    ];

    public function visitor(){
        return $this->belongsTo(Visitor::class, "visitor_id");
    }

    public function user(){
        return $this->belongsTo(User::class,"user_id");
    }

    public function department(){
        return $this->belongsTo(Department::class,"dept_id");
    }

    protected static function boot(){
        parent::boot();
        static::created(function ($visitorlog) {
            GeneralLog::log("Created", "visitor_logs", $visitorlog->id, "{$visitorlog->visitor->last_name}, {$visitorlog->visitor->first_name}'s visit is logged.");
        });
        static::deleted(function ($visitorlog) {
            GeneralLog::log("Deleted", "visitor_logs", $visitorlog->id, "{$visitorlog->visitor->last_name}, {$visitorlog->visitor->first_name}'s visit is deleted.");
        });
        static::updated(function ($visitorlog) {
            $changes = $visitorlog->getChanges();
            $original = $visitorlog->getOriginal();
            $mergedData = [
                'Changes' => $changes,
                'Original' => $original
            ];            

            GeneralLog::log("Updated", "visitor_logs", $visitorlog->id, "{$visitorlog->visitor->last_name}, {$visitorlog->visitor->first_name}'s visit is updated.", $mergedData);
        });
    }
}
