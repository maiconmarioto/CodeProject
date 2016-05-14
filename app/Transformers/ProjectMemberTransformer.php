<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\User;
use League\Fractal\TransformerAbstract;

class ProjectMemberTransformer extends TransformerAbstract
{

    /**
     * @param ProjectMember $member
     * @return array
     */
    public function transform(User $member)
    {
        return [
            'member_id' => $member->id,
        ];
    }

}