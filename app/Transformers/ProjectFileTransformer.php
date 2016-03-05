<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectFile;
use League\Fractal\TransformerAbstract;

class ProjectFileTransformer extends TransformerAbstract {

    public function transform(ProjectFile $model)
    {
        return [
            'project_id'  => $model->project_id,
            'id'          => $model->id,
            'name'        => $model->name,
            'description' => $model->description,
            'extension'   => $model->extension
        ];
    }
}