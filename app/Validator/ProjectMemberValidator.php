<?php

namespace CodeProject\Validator;

use Prettus\Validator\LaravelValidator;

class ProjectMemberValidator extends LaravelValidator
{
    protected $rules = [
        'project_id' => 'required|integer',
        'member_id' => 'required|integer',
    ];
}