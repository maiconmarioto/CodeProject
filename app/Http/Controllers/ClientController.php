<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use CodeProject\Repositories\ClientRepository;
use CodeProject\Service\ClientService;
use Illuminate\Http\Request;


class ClientController extends Controller
{
    /**
     * @var ClientRepository
     */
    private $repository;
    /**
     * @var ClientService
     */
    private $service;

    /**
     * ClientController constructor.
     * @param ClientRepository $repository
     * @param ClientService $service
     */
    public function __construct(ClientRepository $repository, ClientService $service)
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
        try {
            return [$this->repository->all()];
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => 'false', 'message' => 'record not found']);
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
        return ['success' => $this->service->create($request->all())];
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            return [$this->repository->find($id)];
        } catch (ModelNotFoundException  $e) {
            return response()->json(['success' => 'false', 'message' => 'record not found']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        try {
            return ['success' => $this->service->update($request->all(), $id)];
        } catch (ModelNotFoundException  $e) {
            return response()->json(['success' => 'false', 'message' => 'record not found']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            return ['Success' => $this->repository->delete($id)];
        } catch (ModelNotFoundException  $e) {
            return response()->json(['success' => 'false', 'message' => 'record not found']);
        }
    }
}
