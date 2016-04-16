<?php
/**
* Created by PhpStorm.
* User: maicon
* Date: 07/02/16
* Time: 21:02
*/

namespace CodeProject\Service;

use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validator\ProjectNoteValidator;
use Illuminate\Contracts\Validation\ValidationException;
use Prettus\Validator\Exceptions\ValidatorException;

/**
* Class ProjectService
* @package CodeProject\Services
*/
class ProjectNoteService
{
/**
 * @var ProjectRepository
 */
private $repository;
/**
 * @var ClientValidator
 */
private $validator;


public function __construct(ProjectNoteRepository $repository, ProjectNoteValidator $validator)
{

    $this->repository = $repository;
    $this->validator = $validator;
}

/**
 * @param array $data
 * @return array|mixed
// */
//public function create(array $data)
//{
//    try {
//        $this->validator->with($data)->passesOrFail();
//        return $this->repository->create($data);
//    } catch (ValidatorException $e){
//        return [
//                'error' => true,
//                'message' => $e->getMessageBag()
//            ];
//    }
//}

public function create(array $data)
{
    try {
        $this->validator->with($data)->passesOrFail();
        return $this->repository->create($data);
    } catch(ValidatorException $e) {
        return [
            'error' => true,
            'message' => $e->getMessageBag()
        ];
    };
}


/**
 * @param array $data
 * @param $id
 * @return array|mixed
 */
public function update(array $data, $id)
{
    try {
        $this->validator->with($data)->passesOrFail();
        return $this->repository->update($data, $id);
    } catch (ValidatorException $e){
        return [
            'error' => true,
            'message' => $e->getMessageBag()
            ];
    }
}
}