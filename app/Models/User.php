<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_name','first_name','last_name','department_id', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //
    public function UserRole(){
        return $this->belongsTo(Role::class);
    }

    public function tasks()
    {
        return $this->hasMany('App\Models\Task', 'assigned_user');
    }

    public function scopeAdmins($query){
        return $query->where('role_id','=',1);
    }

    public function scopeStaffs($query){
        return $query->where('role_id','=',3);
    }

    public function scopeProjectManagers($query){
        return $query->where('role_id','=',2);
    }

    public function scopeIsAdmin($query){
        return $query->where('role_id','=','1');
    }

    public function scopeProjectManager($query){
        return $query->where('role_id','=','2');
    }
}
