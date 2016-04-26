<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Repositories\ProjectRepository;

use CodeProject\Service\ProjectNoteService;
use CodeProject\Service\ProjectService;
use Illuminate\Http\Request;


class ProjectNoteController extends Controller
{
    /**
     * @var ProjectRepository
     */
    private $repository;
    /**
     * @var ProjectService
     */
    private $service;

    private $proRepo;

    private $proServ;

    /**
     * ProjectNoteController constructor.
     * @param ProjectNoteRepository $repository
     * @param ProjectNoteService $service
     */
    public function __construct(ProjectNoteRepository $repository, ProjectNoteService $service, ProjectRepository $proRepo, ProjectService $proServ)
    {
        $this->repository = $repository;
        $this->service = $service;
        $this->proRepo = $proRepo;
        $this->proServ = $proServ;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
            
            if ($this->proRepo->findWhere(['id' => $id,'owner_id' => $member]) || $this->proRepo->findWhere(['id' => $id,'client_id' => $member])){
                try {
                    return $this->repository->findWhere(['project_id' => $id]);
                } catch (ModelNotFoundException  $e) {
                    return response()->json(['Erro' => '1', 'Mensagem' => 'Registro nao localizado']);
                }
            }            
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $noteId)
    {
        $result = $this->repository->findWhere(['project_id' => $id, 'id' => $noteId]);
        if(isset($result['data']) && count($result['data'])==1){
            $result = [
            'data' => $result['data'][0]
            ];
        }
        return $result;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $noteId)
    {
        return $this->service->update($request->all(), $noteId);
//        try{
//            return $this->service->update($request->all(),$noteId);
//        } catch(ModelNotFoundException  $e) {
//            return response()->json(['Erro' => true, 'Mensagem' => 'Registro nao localizado']);
//        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $noteId)
    {
        try {
            return ['Success' => $this->repository->delete($id)];
        } catch (ModelNotFoundException  $e) {
            return response()->json(['success' => 'false', 'message' => 'record not found']);
        }
    }
}
