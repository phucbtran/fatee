<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\UserMstCreateRequest;
use App\Http\Requests\UserMstUpdateRequest;
use App\Repositories\UserMstRepository;
use App\Validators\UserMstValidator;

/**
 * Class UserMstsController.
 *
 * @package namespace App\Http\Controllers;
 */
class UserMstsController extends Controller
{
    /**
     * @var UserMstRepository
     */
    protected $repository;

    /**
     * @var UserMstValidator
     */
    protected $validator;

    /**
     * UserMstsController constructor.
     *
     * @param UserMstRepository $repository
     * @param UserMstValidator $validator
     */
    public function __construct(UserMstRepository $repository, UserMstValidator $validator)
    {
        $this->repository = $repository;
        $this->validator  = $validator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(app('Prettus\Repository\Criteria\RequestCriteria'));
        $userMsts = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $userMsts,
            ]);
        }

        return view('userMsts.index', compact('userMsts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  UserMstCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(UserMstCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $userMst = $this->repository->create($request->all());

            $response = [
                'message' => 'UserMst created.',
                'data'    => $userMst->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {
            if ($request->wantsJson()) {
                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userMst = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $userMst,
            ]);
        }

        return view('userMsts.show', compact('userMst'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $userMst = $this->repository->find($id);

        return view('userMsts.edit', compact('userMst'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UserMstUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(UserMstUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $userMst = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'UserMst updated.',
                'data'    => $userMst->toArray(),
            ];

            if ($request->wantsJson()) {

                return response()->json($response);
            }

            return redirect()->back()->with('message', $response['message']);
        } catch (ValidatorException $e) {

            if ($request->wantsJson()) {

                return response()->json([
                    'error'   => true,
                    'message' => $e->getMessageBag()
                ]);
            }

            return redirect()->back()->withErrors($e->getMessageBag())->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $deleted = $this->repository->delete($id);

        if (request()->wantsJson()) {

            return response()->json([
                'message' => 'UserMst deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'UserMst deleted.');
    }
}
