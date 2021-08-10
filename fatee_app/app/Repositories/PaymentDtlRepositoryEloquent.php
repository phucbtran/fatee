<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PaymentDtlRepository;
use App\Entities\PaymentDtl;
use App\Validators\PaymentDtlValidator;

/**
 * Class PaymentDtlRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PaymentDtlRepositoryEloquent extends BaseRepository implements PaymentDtlRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PaymentDtl::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PaymentDtlValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
