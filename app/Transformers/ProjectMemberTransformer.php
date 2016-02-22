<?php
/**
 * Created by PhpStorm.
 * User: maicon
 * Date: 21/02/16
 * Time: 18:58
 */

namespace CodeProject\Transformers;

use CodeProject\Entities\User;
use League\Fractal\TransformerAbstract;

class ProjectMemberTransformer extends TransformerAbstract
{
    public function transform(User $member)
    {
        return [
            'member_id' => $member->id,
            'name' => $member->name,
        ];
    }
}