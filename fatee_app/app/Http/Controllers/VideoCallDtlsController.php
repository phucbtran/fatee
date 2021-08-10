<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\VideoCallDtlCreateRequest;
use App\Http\Requests\VideoCallDtlUpdateRequest;
use App\Repositories\VideoCallDtlRepository;
use App\Validators\VideoCallDtlValidator;

/**
 * Class VideoCallDtlsController.
 *
 * @package namespace App\Http\Controllers;
 */
class VideoCallDtlsController extends Controller
{
    /**
     * @var VideoCallDtlRepository
     */
    protected $repository;

    /**
     * @var VideoCallDtlValidator
     */
    protected $validator;

    /**
     * VideoCallDtlsController constructor.
     *
     * @param VideoCallDtlRepository $repository
     * @param VideoCallDtlValidator $validator
     */
    public function __construct(VideoCallDtlRepository $repository, VideoCallDtlValidator $validator)
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
        $videoCallDtls = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $videoCallDtls,
            ]);
        }

        return view('videoCallDtls.index', compact('videoCallDtls'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  VideoCallDtlCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(VideoCallDtlCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $videoCallDtl = $this->repository->create($request->all());

            $response = [
                'message' => 'VideoCallDtl created.',
                'data'    => $videoCallDtl->toArray(),
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
        $videoCallDtl = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $videoCallDtl,
            ]);
        }

        return view('videoCallDtls.show', compact('videoCallDtl'));
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
        $videoCallDtl = $this->repository->find($id);

        return view('videoCallDtls.edit', compact('videoCallDtl'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  VideoCallDtlUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(VideoCallDtlUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $videoCallDtl = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'VideoCallDtl updated.',
                'data'    => $videoCallDtl->toArray(),
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
                'message' => 'VideoCallDtl deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'VideoCallDtl deleted.');
    }
}
