<?php
/**
 * Created by PhpStorm.
 * User: maicon
 * Date: 09/02/16
 * Time: 00:17
 */

namespace CodeProject\Validator;


use Prettus\Validator\LaravelValidator;

class ProjectTaskValidator extends LaravelValidator
{
    protected $rules = [
        'project_id' => 'integer|required',
        'name' => 'required',
        'start_date' => 'required',
        'due_date' => '',
        'status' => 'required',
    ];
}