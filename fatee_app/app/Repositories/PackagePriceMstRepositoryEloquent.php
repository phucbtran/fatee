<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\PackagePriceMstRepository;
use App\Entities\PackagePriceMst;
use App\Validators\PackagePriceMstValidator;

/**
 * Class PackagePriceMstRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class PackagePriceMstRepositoryEloquent extends BaseRepository implements PackagePriceMstRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return PackagePriceMst::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return PackagePriceMstValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
