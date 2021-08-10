<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\NotificationMstRepository;
use App\Entities\NotificationMst;
use App\Validators\NotificationMstValidator;

/**
 * Class NotificationMstRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class NotificationMstRepositoryEloquent extends BaseRepository implements NotificationMstRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return NotificationMst::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return NotificationMstValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
