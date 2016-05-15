<?php
namespace CodeProject\Validators;

use Prettus\Validator\LaravelValidator;

class ProjectFileValidator extends LaravelValidator
{
    protected $rules = [
        'file' => 'required|mimes:jpeg,jpg,png,gif,pdf,zip,doc,docx,rar',
        'name' => 'required|max:255',
        'description' => 'required|max:255',
        'project_id' => 'required|integer',
    ];

}