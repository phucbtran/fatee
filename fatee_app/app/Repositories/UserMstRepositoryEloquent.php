<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UserMstRepository;
use App\Entities\UserMst;
use App\Validators\UserMstValidator;

/**
 * Class UserMstRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserMstRepositoryEloquent extends BaseRepository implements UserMstRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserMst::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return UserMstValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
