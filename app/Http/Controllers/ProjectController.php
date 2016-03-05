<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Http\Requests;
use CodeProject\Presenters\ProjectMemberPresenter;
use CodeProject\Repositories\ProjectMemberRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Service\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller {
    /**
     * @var ProjectRepository
     */
    protected $repository;
    /**
     * @var ProjectService
     */
    protected $service;
    /**
     * @var ProjectMembersRepository
     */
    private $membersRepository;

    /**
     * @param ProjectRepository $repository
     * @param ProjectService $service
     * @param ProjectMemberRepository $membersRepository
     */
    public function __construct(ProjectRepository $repository, ProjectService $service, ProjectMemberRepository $membersRepository)
    {
        $this->repository        = $repository;
        $this->service           = $service;
        $this->membersRepository = $membersRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return $this->repository->findWhere(['owner_id' => \Authorizer::getResourceOwnerId()]);
    }
    /**
     * @param $id
     * @return array|mixed
     */
    public function show($id)
    {
        if ( ! $this->checkProjectPermissions($id))
        {
            return ['error' => 'Access Forbidden'];
        }
        return $this->repository->find($id);
    }
    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  Request $request
     * @param  int     $id
     * @return Response
     */
    public function update($id, Request $request)
    {
        if ( ! $this->checkProjectOwner($id))
        {
            return ['error' => 'Access Forbidden'];
        }
        return $this->service->update($request->all(), $id);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        if ( ! $this->checkProjectOwner($id))
        {
            return ['error' => 'Access Forbidden'];
        }
        return $this->service->delete($id);
    }
    /**
     * @param $id
     * @return mixed
     */
    public function members($id)
    {
        return $this->repository->skipPresenter()->find($id)->members;
    }
    /**
     * @param $id
     * @param $userId
     * @return array|mixed
     */
    public function addMember($id, $userId)
    {
        return $this->service->addMember($id, $userId);
    }
    /**
     * @param $id
     * @param $membersId
     * @return array
     */
    public function removeMember($id, $membersId)
    {
        return $this->service->removeMember($membersId);
    }
    /**
     * @param $projectId
     * @return mixed
     */
    private function checkProjectOwner($projectId)
    {
        $userId = \Authorizer::getResourceOwnerId();
        return $this->repository->isOwner($projectId, $userId);
    }
    private function checkProjectMember($projectId)
    {
        $userId = \Authorizer::getResourceOwnerId();
        return $this->repository->isMember($projectId, $userId);
    }
    /**
     * @param $projectId
     * @return bool
     */
    private function checkProjectPermissions($projectId){
        return ($this->checkProjectOwner($projectId) || $this->checkProjectMember($projectId));
    }
}