<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\WithdrawMstRepository;
use App\Entities\WithdrawMst;
use App\Validators\WithdrawMstValidator;

/**
 * Class WithdrawMstRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class WithdrawMstRepositoryEloquent extends BaseRepository implements WithdrawMstRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return WithdrawMst::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
