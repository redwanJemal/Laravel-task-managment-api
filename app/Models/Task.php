<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'datetime',
        'started_date' => 'datetime',
        'end_date' => 'datetime',
        'completed_date' => 'datetime',
    ];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','description','created_by','assigned_user','status', 'start_date', 'started_date', 'end_date','completed_date',
    ];

}
