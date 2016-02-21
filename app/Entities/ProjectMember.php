<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;

class ProjectMember extends Model
{
    protected $fillable = [
        'project_id',
        'member_id',
    ];


    public function projects()
    {
        return $this->belongsToMany(Project::class,'project_members', 'member_id', 'project_id');
    }

}
