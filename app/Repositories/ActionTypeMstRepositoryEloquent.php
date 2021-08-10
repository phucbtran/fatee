<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ActionTypeMstRepository;
use App\Entities\ActionTypeMst;
use App\Validators\ActionTypeMstValidator;

/**
 * Class ActionTypeMstRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ActionTypeMstRepositoryEloquent extends BaseRepository implements ActionTypeMstRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ActionTypeMst::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
