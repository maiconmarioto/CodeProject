<?php
namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\ProjectMemberRepository;

use CodeProject\Service\ProjectMemberService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ProjectMemberController extends Controller
{
    /**
     * @var ProjectMemberRepository
     */
    private $repository;
    /**
     * @var ProjectMemberService
     */
    private $service;
    /**
     * @param ProjectMemberRepository $repository
     * @param ProjectMemberService $service
     */
    public function __construct(ProjectMemberRepository $repository, ProjectMemberService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index($id)
    {
        return $this->repository->findWhere(['project_id' => $id]);
    }

    public function store(Request $request, $id)
    {
        $data = $request->all();
        $data['project_id'] = $id;
        return $this->service->create($data);
    }

    public function show($id, $idProjectMember)
    {
        return $this->repository->find($idProjectMember);
    }

    public function destroy($id, $idProjectMember)
    {
        try {
            return ['success' => $this->repository->delete($idProjectMember)];
        } catch (ModelNotFoundException  $e) {
            return response()->json(['Erro' => '1', 'Mensagem' => 'Registro nao localizado']);
        }
    }
}