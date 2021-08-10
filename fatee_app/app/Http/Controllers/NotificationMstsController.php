<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\NotificationMstCreateRequest;
use App\Http\Requests\NotificationMstUpdateRequest;
use App\Repositories\NotificationMstRepository;
use App\Validators\NotificationMstValidator;

/**
 * Class NotificationMstsController.
 *
 * @package namespace App\Http\Controllers;
 */
class NotificationMstsController extends Controller
{
    /**
     * @var NotificationMstRepository
     */
    protected $repository;

    /**
     * @var NotificationMstValidator
     */
    protected $validator;

    /**
     * NotificationMstsController constructor.
     *
     * @param NotificationMstRepository $repository
     * @param NotificationMstValidator $validator
     */
    public function __construct(NotificationMstRepository $repository, NotificationMstValidator $validator)
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
        $notificationMsts = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $notificationMsts,
            ]);
        }

        return view('notificationMsts.index', compact('notificationMsts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  NotificationMstCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(NotificationMstCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $notificationMst = $this->repository->create($request->all());

            $response = [
                'message' => 'NotificationMst created.',
                'data'    => $notificationMst->toArray(),
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
        $notificationMst = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $notificationMst,
            ]);
        }

        return view('notificationMsts.show', compact('notificationMst'));
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
        $notificationMst = $this->repository->find($id);

        return view('notificationMsts.edit', compact('notificationMst'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  NotificationMstUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(NotificationMstUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $notificationMst = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'NotificationMst updated.',
                'data'    => $notificationMst->toArray(),
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
                'message' => 'NotificationMst deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'NotificationMst deleted.');
    }
}
