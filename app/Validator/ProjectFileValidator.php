<?php

namespace CodeProject\Validator;

use Prettus\Validator\LaravelValidator;

class ProjectFileValidator extends LaravelValidator {

    protected $rules = [
        'name' => 'required|max:255',
        'file' => 'required|mimes:jpeg,jpg,gif,bmp,png|max:1024'//1MB
    ];
}