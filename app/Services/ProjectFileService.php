<?php

namespace CodeProject\Services;

use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectFileValidator;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Illuminate\Filesystem\Filesystem;
use Prettus\Validator\Exceptions\ValidatorException;


class ProjectFileService
{
    protected $repository;
    protected $fileValidator;
    protected $storage;
    protected $fileSystem;
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    public function __construct(ProjectFileRepository $repository, ProjectRepository $projectRepository, ProjectFileValidator $fileValidator,  Storage $storage, Filesystem $filesystem)
    {
        $this->repository = $repository;
        $this->fileValidator = $fileValidator;
        $this->storage = $storage;
        $this->fileSystem = $filesystem;
        $this->projectRepository = $projectRepository;
    }

    public function create(array $data)
    {
        try{
            $this->fileValidator->with($data)->passesOrFail();
            $project = $this->projectRepository->skipPresenter()->find($data['project_id']);
            $projectFile = $project->files()->create($data);
            $this->storage->put($projectFile->id.".".$data['extension'], $this->fileSystem->get($data['file']));

            return ['error'=>false, 'message'=>'Arquivo inserido com sucesso!'];
        }
        catch(ValidatorException $e){
            $error = $e->getMessageBag();
            return [
                'error' => true,
                'message' => "Erro ao enviar o arquivo, alguns campos são obrigatórios!",
                'messages' => $error->getMessages(),
            ];
        }
    }

    public function update(array $data, $id)
    {
        try{
            $this->fileValidator->with($data)->passesOrFail();
            return $this->repository->update($data, $id);
        }
        catch(ValidatorException $e){
            $error = $e->getMessageBag();
            return [
                'error' => true,
                'message' => "Erro ao atualizar o projeto, alguns campos são obrigatórios!",
                'messages' => $error->getMessages(),
            ];
        }
    }

    public function delete($id)
    {
        $projectFile = $this->repository->skipPresenter()->find($id);
        if($this->storage->exists($projectFile->id.'.'.$projectFile->extension)){
            $this->storage->delete($projectFile->id.'.'.$projectFile->extension);
            return $projectFile->delete();
        }
    }

    public function getFilePath($id)
    {
        $projectFile = $this->repository->skipPresenter()->find($id);
        return $this->getBaseURL($projectFile);
    }

    public function getBaseURL($projectFile)
    {
        switch ($this->storage->getDefaultDriver()){
            case 'local':
                return $this->storage->getDriver()->getAdapter()->getPathPrefix()
                .'/'.$projectFile->id.'.'.$projectFile->extension;
        }
    }

    public function checkProjectOwner($projectFileId)
    {
        $userId = \Authorizer::getResourceOwnerId();
        $projectId = $this->repository->skipPresenter()->find($projectFileId)->project_id;

        return $this->projectRepository->isOwner($projectId,$userId);
    }

    public function checkProjectMember($projectFileId)
    {
        $userId = \Authorizer::getResourceOwnerId();
        $projectId = $this->repository->skipPresenter()->find($projectFileId)->project_id;

        return $this->repository->hasMember($projectId,$userId);
    }

    public function checkProjectPermissions($projectFileId)
    {
        if($this->checkProjectOwner($projectFileId) || $this->checkProjectMember($projectFileId)){
            return true;
        }

        return false;
    }
}