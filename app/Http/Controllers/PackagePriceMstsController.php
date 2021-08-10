<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\PackagePriceMstCreateRequest;
use App\Http\Requests\PackagePriceMstUpdateRequest;
use App\Repositories\PackagePriceMstRepository;
use App\Validators\PackagePriceMstValidator;

/**
 * Class PackagePriceMstsController.
 *
 * @package namespace App\Http\Controllers;
 */
class PackagePriceMstsController extends Controller
{
    /**
     * @var PackagePriceMstRepository
     */
    protected $repository;

    /**
     * @var PackagePriceMstValidator
     */
    protected $validator;

    /**
     * PackagePriceMstsController constructor.
     *
     * @param PackagePriceMstRepository $repository
     * @param PackagePriceMstValidator $validator
     */
    public function __construct(PackagePriceMstRepository $repository, PackagePriceMstValidator $validator)
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
        $packagePriceMsts = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $packagePriceMsts,
            ]);
        }

        return view('packagePriceMsts.index', compact('packagePriceMsts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  PackagePriceMstCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(PackagePriceMstCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $packagePriceMst = $this->repository->create($request->all());

            $response = [
                'message' => 'PackagePriceMst created.',
                'data'    => $packagePriceMst->toArray(),
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
        $packagePriceMst = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $packagePriceMst,
            ]);
        }

        return view('packagePriceMsts.show', compact('packagePriceMst'));
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
        $packagePriceMst = $this->repository->find($id);

        return view('packagePriceMsts.edit', compact('packagePriceMst'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PackagePriceMstUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(PackagePriceMstUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $packagePriceMst = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'PackagePriceMst updated.',
                'data'    => $packagePriceMst->toArray(),
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
                'message' => 'PackagePriceMst deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'PackagePriceMst deleted.');
    }
}
