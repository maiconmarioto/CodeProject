<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Service\ProjectService;
use Illuminate\Http\Request;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;


class ProjectController extends Controller
{
    /**
     * @var ProjectRepository
     */
    private $repository;
    /**
     * @var ProjectService
     */
    private $service;



    /**
     * ProjectController constructor.
     * @param ProjectRepository $repository
     * @param ProjectService $service
     */
    public function __construct(ProjectRepository $repository, ProjectService $service)
    {

        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->repository->with(['owner','client'])->findWhere(['owner_id' => \Authorizer::getResourceOwnerId() ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($this->checkProjectPermissions($id)==false){
            return ['error' => 'Access Forbidden'];
        }
        return $this->repository->with(['owner','client'])->find($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($this->checkProjectOwner($id)==false){
            return ['error' => 'Access Forbidden'];
        }

        return $this->service->update($request->all(),$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($this->checkProjectOwner($id)==false){
            return ['error' => 'Access Forbidden'];
        }

        return $this->repository->delete($id);
    }

    public function addMember(Request $request)
    {
        $this->service->addMember($request->all());
    }

    public function removeMember($projectId, $userId)
    {
        $this->service->removeMember($projectId, $userId);
    }

    public function showMembers($id)
    {
        $project = $this->repository->find($id);
        return  $project->members;
    }

    public function membersShow($id, $idMember)
    {
        return \CodeProject\Entities\ProjectMember::where('project_id', $id)->where('member_id', $idMember)->first();
    }

    private function checkProjectOwner($projectId)
    {
        $userId = \Authorizer::getResourceOwnerId();
        return $this->repository->isOwner($projectId, $userId);
    }

    private function checkProjectMember($projectId)
    {
        $userId = \Authorizer::getResourceOwnerId();
        return $this->repository->hasMember($projectId, $userId);
    }

    private function checkProjectPermissions($projectId)
    {
        if($this->checkProjectOwner($projectId) or $this->checkProjectMember($projectId)){
            return true;
        }

        return false;
    }
}
