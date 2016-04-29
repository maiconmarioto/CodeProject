<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use CodeProject\Entities\Client;
use CodeProject\Presenters\ClientPresenter;

class ClientRepositoryEloquent extends BaseRepository implements ClientRepository
{

    protected $filterSearchable = [
        'name'
    ];

	public function model()
	{
		return Client::class;
	}

	public function presenter()
	{
		return ClientPresenter::class;
	}

	public function  boot()
	{
		$this->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
	}
}

