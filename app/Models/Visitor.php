<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visitor extends Model
{
    use HasFactory;

    use SoftDeletes;
    public $timestamps = true;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        "first_name",
        "last_name",
        "affiliation",
        "address",
        "email",
        "contact",
        "profile_image",
        "user_id",
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function logs(){

        return $this->hasMany(VisitorLog::class)
        ->when(auth()->user()->dept_id !== 0, fn($q) => $q->where('dept_id', auth()->user()->dept_id))->with(['department'])->orderByDesc('visited_at');
    }
    protected static function boot(){
        parent::boot();


        static::created(function ($visitor) {

            GeneralLog::log("Created", "visitors", $visitor->id, "Visitor {$visitor->last_name}, {$visitor->first_name} is successfully added.");
        });
        static::updated(function ($visitor) {
                
            $changes = $visitor->getChanges();
            $original = $visitor->getOriginal();
            $mergedData = [
                'Changes' => $changes,
                'Original' => $original
            ];
            GeneralLog::log("Updated", "visitors", $visitor->id, "Visitor {$visitor->last_name}, {$visitor->first_name} is successfully updated.", $mergedData);
        });
        static::deleted(function ($visitor) {


            GeneralLog::log("Deleted", "visitors", $visitor->id, "Visitor {$visitor->last_name}, {$visitor->first_name} is successfully deleted.");
        });
    }
}
