<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MessageDtlRepository;
use App\Entities\MessageDtl;
use App\Validators\MessageDtlValidator;

/**
 * Class MessageDtlRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MessageDtlRepositoryEloquent extends BaseRepository implements MessageDtlRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MessageDtl::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return MessageDtlValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
