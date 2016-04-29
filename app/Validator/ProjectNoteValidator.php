<?php
/**
 * Created by PhpStorm.
 * User: maicon
 * Date: 09/02/16
 * Time: 00:17
 */

namespace CodeProject\Validator;


use Prettus\Validator\LaravelValidator;

class ProjectNoteValidator extends LaravelValidator
{
    protected $rules = [
        'project_id' => 'integer|required',
        'title' => 'required',
        'note' => 'required',

    ];
}