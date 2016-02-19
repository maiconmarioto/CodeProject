<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Service\ProjectTaskService;
use Illuminate\Http\Request;
use CodeProject\Http\Requests;
use CodeProject\Http\Controllers\Controller;

class ProjectTaskController extends Controller
{


    /**
     * @var ProjectTaskRepository
     */
    private $repository;
    /**
     * @var ProjectTaskService
     */
    private $service;

    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        try {
            return $this->repository->findWhere(['project_id' => $id]);
        } catch (ModelNotFoundException  $e) {
            return response()->json(['Erro' => '1', 'Mensagem' => 'Registro nao localizado']);
        }
    }


    /**
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        return ['success' => $this->service->create($request->all())];
    }

    /**
     * @param $id
     * @param $noteId
     * @return array|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function show($id, $taskId)
    {
        try {
            return $this->repository->findWhere(['project_id' => $id, 'id' => $taskId]);
        } catch (ModelNotFoundException  $e) {
            return response()->json(['Erro' => '1', 'Mensagem' => 'Registro nao localizado']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $taskId)
    {
        try {
            return ['success' => $this->service->update($request->all(), $taskId)];
        } catch (ModelNotFoundException  $e) {
            return response()->json(['Erro' => '1', 'Mensagem' => 'Registro nao localizado']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $taskId)
    {
        try {
            return ['success' => $this->repository->delete($taskId)];
        } catch (ModelNotFoundException  $e) {
            return response()->json(['Erro' => '1', 'Mensagem' => 'Registro nao localizado']);
        }
    }
}
