<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    
    protected $dates = ['deleted_at'];
    
    public $timestamps = true;
    protected $fillable = [
        'name',
        'email',
        'password',
        'dept_id',
        'role',
        'provider',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function department(){

        return $this->belongsTo(Department::class,'dept_id')->withDefault([
            "dept_name" => "No Department",
        ]);
    }

    public function visitor(){
        return $this->hasMany(Visitor::class);
    }

    protected static function boot(){
        parent::boot();


        static::created(function ($user) {

            GeneralLog::log("Created", "users", $user->id, "User: {$user->name} is successfully added.");
        });
        static::updated(function ($user) {
                
            $changes = $user->getChanges();
            $original = $user->getOriginal();
            $mergedData = [
                'Changes' => $changes,
                'Original' => $original
            ];
            GeneralLog::log("Updated", "users", $user->id, "User: {$user->name} is successfully updated.", $mergedData);
        });
        static::deleted(function ($user) {

            GeneralLog::log("Deleted", "users", $user->id, "User: {$user->name} is successfully deleted.");
        });
    }
}
