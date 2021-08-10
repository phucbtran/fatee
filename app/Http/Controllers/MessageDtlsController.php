<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\MessageDtlCreateRequest;
use App\Http\Requests\MessageDtlUpdateRequest;
use App\Repositories\MessageDtlRepository;
use App\Validators\MessageDtlValidator;

/**
 * Class MessageDtlsController.
 *
 * @package namespace App\Http\Controllers;
 */
class MessageDtlsController extends Controller
{
    /**
     * @var MessageDtlRepository
     */
    protected $repository;

    /**
     * @var MessageDtlValidator
     */
    protected $validator;

    /**
     * MessageDtlsController constructor.
     *
     * @param MessageDtlRepository $repository
     * @param MessageDtlValidator $validator
     */
    public function __construct(MessageDtlRepository $repository, MessageDtlValidator $validator)
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
        $messageDtls = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $messageDtls,
            ]);
        }

        return view('messageDtls.index', compact('messageDtls'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  MessageDtlCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(MessageDtlCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $messageDtl = $this->repository->create($request->all());

            $response = [
                'message' => 'MessageDtl created.',
                'data'    => $messageDtl->toArray(),
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
        $messageDtl = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $messageDtl,
            ]);
        }

        return view('messageDtls.show', compact('messageDtl'));
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
        $messageDtl = $this->repository->find($id);

        return view('messageDtls.edit', compact('messageDtl'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  MessageDtlUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(MessageDtlUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $messageDtl = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'MessageDtl updated.',
                'data'    => $messageDtl->toArray(),
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
                'message' => 'MessageDtl deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'MessageDtl deleted.');
    }
}
