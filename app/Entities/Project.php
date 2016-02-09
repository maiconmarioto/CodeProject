<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'owner_id',
        'client_id',
        'description',
        'progress',
        'status',
        'due_date',
    ];

}
