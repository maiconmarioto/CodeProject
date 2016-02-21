<?php
/**
 * Created by PhpStorm.
 * User: maicon
 * Date: 07/02/16
 * Time: 21:02
 */

namespace CodeProject\Service;


use CodeProject\Repositories\ProjectMemberRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validator\ClientValidator;
use CodeProject\Validator\ProjectValidator;
use CodeProject\Validator\ProjectMemberValidator;
use Illuminate\Contracts\Validation\ValidationException;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class ProjectService
 * @package CodeProject\Services
 */
class ProjectService
{


    /**
     * @var ProjectRepository
     */
    private $projectRepository;
    /**
     * @var ProjectValidator
     */
    private $projectValidator;
    /**
     * @var ProjectMemberRepository
     */
    private $memberRepository;
    /**
     * @var ProjectMemberValidator
     */
    private $projectMemberValidator;

    public function __construct(ProjectRepository $projectRepository, ProjectValidator $projectValidator, ProjectMemberRepository $memberRepository, ProjectMemberValidator $projectMemberValidator)
    {
        $this->projectRepository = $projectRepository;
        $this->projectValidator = $projectValidator;
        $this->memberRepository = $memberRepository;
        $this->projectMemberValidator = $projectMemberValidator;
    }

    public function getRepository()
    {
        return $this->repository;
    }

    /**
     * @param array $data
     * @return array|mixed
     */
    public function create(array $data)
    {
        try {
            $this->$projectValidator->with($data)->passesOrFail();
            return $this->projectRepository->create($data);
        } catch (ValidatorException $e) {
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }


    /**
     * @param array $data
     * @param $id
     * @return array|mixed
     */
    public function update(array $data, $id)
    {
        try {
            $this->projectValidator->with($data)->passesOrFail();
            return $this->projectRepository->update($data, $id);
        } catch (ValidatorException $e){
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }

    public function add($projectId,$memberId)
    {
        $project = $this->repository->find($projectId);
        return $project->members()->attach($memberId);
    }



}