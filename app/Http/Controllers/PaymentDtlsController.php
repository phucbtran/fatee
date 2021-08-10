<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PaymentDtlCreateRequest;
use App\Http\Requests\PaymentDtlUpdateRequest;
use App\Repositories\PaymentDtlRepository;
use App\Validators\PaymentDtlValidator;

/**
 * Class PaymentDtlsController.
 *
 * @package namespace App\Http\Controllers;
 */
class PaymentDtlsController extends Controller
{
    /**
     * @var PaymentDtlRepository
     */
    protected $repository;

    /**
     * @var PaymentDtlValidator
     */
    protected $validator;

    /**
     * PaymentDtlsController constructor.
     *
     * @param PaymentDtlRepository $repository
     * @param PaymentDtlValidator $validator
     */
    public function __construct(PaymentDtlRepository $repository, PaymentDtlValidator $validator)
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
        $paymentDtls = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $paymentDtls,
            ]);
        }

        return view('paymentDtls.index', compact('paymentDtls'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PaymentDtlCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(PaymentDtlCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $paymentDtl = $this->repository->create($request->all());

            $response = [
                'message' => 'PaymentDtl created.',
                'data'    => $paymentDtl->toArray(),
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
        $paymentDtl = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $paymentDtl,
            ]);
        }

        return view('paymentDtls.show', compact('paymentDtl'));
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
        $paymentDtl = $this->repository->find($id);

        return view('paymentDtls.edit', compact('paymentDtl'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PaymentDtlUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(PaymentDtlUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $paymentDtl = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'PaymentDtl updated.',
                'data'    => $paymentDtl->toArray(),
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
                'message' => 'PaymentDtl deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'PaymentDtl deleted.');
    }
}
