<?php
/**
 * Created by PhpStorm.
 * User: maicon
 * Date: 08/02/16
 * Time: 00:44
 */

namespace CodeProject\Validator;


use Prettus\Validator\LaravelValidator;

class ProjectValidator extends LaravelValidator
{
    protected $rules = [
        'owner_id' => 'integer|required',
        'client_id' => 'integer|required',
        'name' => 'required|max:255',
        'description' => 'required|max:255',
        'progress' => 'required|max:255',
        'status' => 'required|max:255',
        'due_date' => 'required'
    ];
}