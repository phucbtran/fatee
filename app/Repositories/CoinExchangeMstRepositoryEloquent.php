<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\CoinExchangeMstRepository;
use App\Entities\CoinExchangeMst;
use App\Validators\CoinExchangeMstValidator;

/**
 * Class CoinExchangeMstRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CoinExchangeMstRepositoryEloquent extends BaseRepository implements CoinExchangeMstRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CoinExchangeMst::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return CoinExchangeMstValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
