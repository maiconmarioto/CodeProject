<?php
/**
 * Created by PhpStorm.
 * User: maicon
 * Date: 07/02/16
 * Time: 19:10
 */

namespace CodeProject\Validator;

use Prettus\Validator\LaravelValidator;

class ClientValidator extends LaravelValidator
{
    protected $rules =
    [
        'name' => 'required|max:255',
        'responsible' => 'required|max:255',
        'email' => 'required|email',
        'phone' => 'required',
        'address' => 'required'
    ];
}