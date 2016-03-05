<?php
/**
 * Created by PhpStorm.
 * User: maicon
 * Date: 14/02/16
 * Time: 15:25
 */

namespace CodeProject\OAuth;

use Illuminate\Support\Facades\Auth;

class Verifier
{
    public function verify($username, $password)
    {
        $credentials = [
            'email'    => $username,
            'password' => $password,
        ];

        if (Auth::once($credentials)) {
            return Auth::user()->id;
        }

        return false;
    }
}