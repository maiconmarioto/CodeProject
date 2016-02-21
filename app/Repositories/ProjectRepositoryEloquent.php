<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use CodeProject\Entities\Project;

class ProjectRepositoryEloquent extends BaseRepository implements ProjectRepository
{
    /**
     * @return mixed
     */
    public function model()
    {
        return Project::class;
    }

    public function boot()
    {
    //    $this->pushCriteria( app(RequestCriteria::class));
    }

    public function isOwner($projectId, $userId)
    {
        if(count($this->findWhere(['id' => $projectId, 'owner_id' => $userId]))){
            return true;
        }
        return false;
    }

    public function hasMember($projectId, $memberId)
    {
        $project = $this->find($projectId);
        foreach($project->members as $member) {
            if ($member->id == $memberId) {
                return true;
            }
        }
            return false;
    }



}