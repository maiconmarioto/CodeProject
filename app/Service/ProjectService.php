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
use CodeProject\Validator\ProjectMemberValidator;
use CodeProject\Validator\ProjectValidator;
use Illuminate\Contracts\Validation\ValidationException;
use Prettus\Validator\Exceptions\ValidatorException;

use File;
use Illuminate\Support\Facades\Storage;

/**
 * Class ProjectService
 * @package CodeProject\Services
 */
class ProjectService
{


    /**
     * @var ProjectRepository
     */
    private $repository;
    /**
     * @var ProjectValidator
     */
    private $validator;
    /**
     * @var ProjectMemberRepository
     */
    private $repositoryMember;
    /**
     * @var ProjectMemberValidator
     */
    private $memberValidator;

    /**
     * ProjectService constructor.
     * @param ProjectRepository $repository
     * @param ProjectValidator $validator
     * @param ProjectMemberRepository $repositoryMember
     * @param ProjectMemberValidator $memberValidator
     */
    public function __construct(ProjectRepository $repository,
                                ProjectValidator $validator,
                                ProjectMemberRepository $repositoryMember,
                                ProjectMemberValidator $memberValidator)
    {

        $this->repository = $repository;
        $this->validator = $validator;
        $this->repositoryMember = $repositoryMember;
        $this->memberValidator = $memberValidator;
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
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
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
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        } catch (ValidatorException $e){
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }

    public function addMember(array $data)
    {
        try{
            $this->memberValidator->with($data)->passesOrFail();
            return $this->repositoryMember->create($data);
        } catch (ValidatorException $e){
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }
    public function removeMember($projectId, $memberId)
    {
        try{
            $member = $this->repositoryMember->findWhere(['project_id' => $projectId, 'user_id' => $memberId])->first();
            return $member->delete();
        }catch (Exception $e){
            return ['error' => $e->errorInfo];
        }
    }
    public function membersShow($projectId, $memberId)
    {
        try{
            return \CodeProject\Entities\ProjectMembers::all();
        }catch (Exception $e){
            return ['error' => $e->errorInfo];
        }
    }
    public function isMember($projectId)
    {
        $member = $project = $this->repository->skipPresenter()->find($projectId);
        return response()->json(['data' => $member->members]);
    }

    public function createFile(array $data)
    {
        //name
        //description
        //extension
        Storage::put($data['name'].".".$data['extension'], File::get($data['file']));
    }


}