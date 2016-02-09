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

    public function client() {
        return $this->hasMany('\CodeProject\Entities\Client', 'id', 'client_id');
    }

    public function owner() {
        return $this->hasOne('\CodeProject\Entities\User', 'id', 'owner_id');
    }
}
