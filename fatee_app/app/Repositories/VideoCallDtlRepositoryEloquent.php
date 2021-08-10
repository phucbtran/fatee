<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\VideoCallDtlRepository;
use App\Entities\VideoCallDtl;
use App\Validators\VideoCallDtlValidator;

/**
 * Class VideoCallDtlRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class VideoCallDtlRepositoryEloquent extends BaseRepository implements VideoCallDtlRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return VideoCallDtl::class;
    }

    /**
    * Specify Validator class name
    *
    * @return mixed
    */
    public function validator()
    {

        return VideoCallDtlValidator::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
