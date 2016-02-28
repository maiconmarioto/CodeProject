<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectMember;
use League\Fractal\TransformerAbstract;

class ProjectMemberTransformer extends TransformerAbstract
{

    public function transform(ProjectMember $member)
    {
        return [
            'id'    => $member->id,
            'member' => $member->member_id,
            'project' => $member->project_id
        ];
    }

}