<?php
/**
 * Created by PhpStorm.
 * User: maicon
 * Date: 21/02/16
 * Time: 19:06
 */

namespace CodeProject\Presenters;

use CodeProject\Transformers\ClientTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class ClientPresenter extends FractalPresenter
{
    public function getTransformer()
    {
        return new ClientTransformer();
    }
}