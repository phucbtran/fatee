<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Prettus\Validator\Contracts\ValidatorInterface;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Requests\CoinExchangeMstCreateRequest;
use App\Http\Requests\CoinExchangeMstUpdateRequest;
use App\Repositories\CoinExchangeMstRepository;
use App\Validators\CoinExchangeMstValidator;

/**
 * Class CoinExchangeMstsController.
 *
 * @package namespace App\Http\Controllers;
 */
class CoinExchangeMstsController extends Controller
{
    /**
     * @var CoinExchangeMstRepository
     */
    protected $repository;

    /**
     * @var CoinExchangeMstValidator
     */
    protected $validator;

    /**
     * CoinExchangeMstsController constructor.
     *
     * @param CoinExchangeMstRepository $repository
     * @param CoinExchangeMstValidator $validator
     */
    public function __construct(CoinExchangeMstRepository $repository, CoinExchangeMstValidator $validator)
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
        $coinExchangeMsts = $this->repository->all();

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $coinExchangeMsts,
            ]);
        }

        return view('coinExchangeMsts.index', compact('coinExchangeMsts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CoinExchangeMstCreateRequest $request
     *
     * @return \Illuminate\Http\Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CoinExchangeMstCreateRequest $request)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_CREATE);

            $coinExchangeMst = $this->repository->create($request->all());

            $response = [
                'message' => 'CoinExchangeMst created.',
                'data'    => $coinExchangeMst->toArray(),
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
        $coinExchangeMst = $this->repository->find($id);

        if (request()->wantsJson()) {

            return response()->json([
                'data' => $coinExchangeMst,
            ]);
        }

        return view('coinExchangeMsts.show', compact('coinExchangeMst'));
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
        $coinExchangeMst = $this->repository->find($id);

        return view('coinExchangeMsts.edit', compact('coinExchangeMst'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CoinExchangeMstUpdateRequest $request
     * @param  string            $id
     *
     * @return Response
     *
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(CoinExchangeMstUpdateRequest $request, $id)
    {
        try {

            $this->validator->with($request->all())->passesOrFail(ValidatorInterface::RULE_UPDATE);

            $coinExchangeMst = $this->repository->update($request->all(), $id);

            $response = [
                'message' => 'CoinExchangeMst updated.',
                'data'    => $coinExchangeMst->toArray(),
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
                'message' => 'CoinExchangeMst deleted.',
                'deleted' => $deleted,
            ]);
        }

        return redirect()->back()->with('message', 'CoinExchangeMst deleted.');
    }
}
