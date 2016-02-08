<?php
/**
 * Created by PhpStorm.
 * User: maicon
 * Date: 07/02/16
 * Time: 18:45
 */

namespace CodeProject\Service;


use CodeProject\Repositories\ClientRepository;
use CodeProject\Validator\ClientValidator;
use Illuminate\Contracts\Validation\ValidationException;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class ClientService
 * @package CodeProject\Services
 */
class ClientService
{

    protected $repository;
    /**
     * @var ClientValidator
     */
    private $validator;


    /**
     * ClientService constructor.
     * @param ClientRepository $repository
     * @param ClientValidator $validator
     */
    public function __construct(ClientRepository $repository, ClientValidator $validator)

    {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
        } catch (ValidatorException $e)        {
            return [
                'error'=> true,
                'message' => $e->getMessageBag()
            ];
        }
    }

    /**
     * @param array $data
     * @param $id
     * @return mixed
     */
    public function update(array $data, $id)
    {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data,$id);
        } catch (ValidatorException $e){
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }
}