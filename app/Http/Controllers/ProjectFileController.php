<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Service\ProjectFileService;
use Illuminate\Http\Request;

class ProjectFileController extends Controller {
    /**
     * @var ProjectFileService
     */
    protected $service;
    /**
     * @var ProjectFileRepository
     */
    private $repository;
    /**
     * @param ProjectFileRepository $repository
     * @param ProjectFileService    $service
     */
    public function __construct(ProjectFileRepository $repository, ProjectFileService $service)
    {
        $this->repository = $repository;
        $this->service    = $service;
    }
    /**
     * Display a listing of the resource.
     *
     * @param $id
     * @return Response
     */
    public function index($id)
    {
        return $this->repository->findWhere(['project_id' => $id]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store($id, Request $request)
    {
        return $this->service->create($id, $request);
    }
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show($id, $fileId)
    {
        return $this->repository->findWhere(['project_id' => $id, 'id' => $fileId]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id, $fileId)
    {
        return $this->service->delete($id, $fileId);
    }
}