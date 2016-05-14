<?php

namespace CodeProject\Service;

use CodeProject\Repositories\ProjectMemberRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validator\ProjectMemberValidator;
use CodeProject\Validator\ProjectValidator;

class ProjectService  {
    /**
     * @var ProjectMemberValidator
     */
    private $memberValidator;
    /**
     * @var ProjectMemberRepository
     */
    private $memberRepository;
    /**
     * @param ProjectRepository        $repository
     * @param ProjectValidator         $validator
     * @param ProjectMemberRepository $memberRepository
     * @param ProjectMemberValidator  $memberValidator
     */
    public function __construct(ProjectRepository $repository, ProjectValidator $validator, ProjectMemberRepository $memberRepository, ProjectMemberValidator $memberValidator)
    {
        $this->repository        = $repository;
        $this->validator         = $validator;
        $this->Repository        = $memberRepository;
        $this->memberValidator   = $memberValidator;
    }
    public function addMember($id, $userId)
    {
        try
        {
            $data = ['project_id' => $id, 'user_id' => $userId];
            $this->memberValidator->with($data)->passesOrFail();
            return $this->memberRepository->create($data);
        }
        catch (ValidatorException $e)
        {
            return [
                'error'   => true,
                'message' => $e->getMessageBag()
            ];
        }
    }
    public function removeMember($memberId)
    {
        try
        {
            $this->memberRepository->delete($memberId);
        }
        catch (ValidatorException $e)
        {
            return [
                'error'   => true,
                'message' => $e->getMessageBag()
            ];
        }
    }
}