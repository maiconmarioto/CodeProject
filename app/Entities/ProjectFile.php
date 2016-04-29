<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;

class ProjectFile extends Model {

    protected $fillable = [
        'project_id',
        'name',
        'description',
        'extension',
    ];

    public function project()
    {
        return $this->belongsTo(\CodeProject\Entities\Project::class);
    }
}