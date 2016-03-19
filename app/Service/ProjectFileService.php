<?php

namespace CodeProject\Service;

use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validator\ProjectFileValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectFileService {
    /**
     * @var ProjectFileRepository
     */
    protected $repository;
    /**
     * @var Filesystem
     */
    private $filesystem;
    /**
     * @var Storage
     */
    private $storage;
    /**
     * @var ProjectRepository
     */
    private $projectRepository;
    /**
     * @var ProjectFileValidator
     */
    private $validator;
    /**
     * @param ProjectRepository     $projectRepository
     * @param ProjectFileRepository $repository
     * @param ProjectFileValidator  $validator
     * @param Storage               $storage
     * @param Filesystem            $filesystem
     */
    public function __construct(ProjectRepository $projectRepository, ProjectFileRepository $repository, ProjectFileValidator $validator, Storage $storage, Filesystem $filesystem)
    {
        $this->projectRepository = $projectRepository;
        $this->repository        = $repository;
        $this->validator         = $validator;
        $this->storage           = $storage;
        $this->filesystem        = $filesystem;
    }
    public function create($id, $data)
    {
        try
        {
            $project = $this->projectRepository->skipPresenter()->find($id);
            $this->validator->with($data->all())->passesOrFail();
            $file = $data->file('file');
            $data = array_merge($data->all(), ['extension' => $file->getClientOriginalExtension()]);
            $projectFile = $project->files()->create($data);
            $this->storage->put($projectFile->id . '.' . $data['extension'], $this->filesystem->get($file));
            return $projectFile;
        }
        catch (ValidatorException $e)
        {
            return [
                'error'   => true,
                'message' => $e->getMessageBag()
            ];
        }
    }
    public function delete($id, $fileId)
    {
        try
        {
            $projectFile = $this->repository->skipPresenter()->findWhere(['project_id' => $id, 'id' => $fileId])->first();
     //       $this->repository->delete($fileId);
            $this->storage->delete($projectFile->id . '.' . $projectFile->extension);
        }
        catch (ModelNotFoundException $e)
        {
            return [
                'error'   => true,
                'message' => $e->getMessage()
            ];
        }
    }
}