<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {
    protected $fillable = [
        'owner_id',
        'client_id',
        'name',
        'description',
        'progress',
        'status',
        'due_date',
    ];


    public function owner()
    {
        return $this->belongsTo(\CodeProject\Entities\User::class, 'owner_id');
    }
    public function client()
    {
        return $this->belongsTo(\CodeProject\Entities\Client::class);
    }
    public function notes()
    {
        return $this->hasMany(\CodeProject\Entities\ProjectNote::class);
    }
    public function tasks()
    {
        return $this->hasMany(\CodeProject\Entities\ProjectTask::class);
    }
    public function members()
    {
        return $this->belongsToMany(\CodeProject\Entities\User::class, 'project_members');
    }
    public function files()
    {
        return $this->hasMany(\CodeProject\Entities\ProjectFile::class);
    }
}