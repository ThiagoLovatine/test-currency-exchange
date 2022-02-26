<?php

namespace App\Http\Controllers;

use App\Http\Requests\CurrencyConvertRequest;
use App\Http\Requests\CurrencyGetRequest;
use App\Services\CurrencyService;
use Exception;

class CurrencyController extends Controller
{
    /**
     * @var currencyService
     */
    protected $currencyService;

    /**
     * CurrencyController Constructor
     *
     * @param CurrencyService $currencyService
     *
     */
    public function __construct(CurrencyService $currencyService)
    {
        $this->currencyService = $currencyService;
    }

    /**
     * @OA\Get(
     *     path="/api/currencies",
     *     description="Returns a list of currencies with pagination",
     *     summary="List all currencies",
     *     operationId="index",
     *     @OA\Parameter(
     *          name="offset",
     *          in="query",
     *          required=true,
     *          description="The pagination offset number (Starts from 0)",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *     ),
     *      @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          required=true,
     *          description="The pagination limit number (Takes X)",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Returns a list of currencies",
     *         @OA\JsonContent(
     *              type="object",
     *              example={{
     *                       "id": 1,
     *                      "symbol": "USD"
     *                   },
     *                   {
     *                       "id": 2,
     *                       "symbol": "JPY"
     *                   },
     *                   {
     *                       "id": 3,
     *                       "symbol": "EUR"
     *                   },
     *                   {
     *                       "id": 4,
     *                       "symbol": "BRL"
     *                   }}
     *          )
     *      )
     * )
     * */
    public function index(CurrencyGetRequest $request)
    {
        return response()->json($this->currencyService->getAll($request));
    }

    /**
     * @OA\Post(
     *     path="/api/exchange",
     *     description="",
     *     summary="Convert a currency value to another",
     *     operationId="convert",
     *     @OA\Parameter(
     *          name="from",
     *          in="query",
     *          required=true,
     *          description="The currency to convert the value from (Should exists in the database)",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *     ),
     *     @OA\Parameter(
     *          name="to",
     *          in="query",
     *          required=true,
     *          description="The currency to convert the value to (Should exists in the database)",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *     ),
     *     @OA\Parameter(
     *          name="amount",
     *          in="query",
     *          required=true,
     *          description="The amount to convert",
     *          @OA\Schema(
     *              type="number"
     *          ),
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="ok",
     *         content={
     *             @OA\MediaType(
     *                 mediaType="application/json",
     *                 @OA\Schema(
     *                     @OA\Property(
     *                         property="from",
     *                         type="string",
     *                         description="The currency the value was converted from"
     *                     ),
     *                     @OA\Property(
     *                         property="to",
     *                         type="string",
     *                         description="The currency the value was converted to"
     *                     ),
     *                     @OA\Property(
     *                         property="amount",
     *                         type="integer",
     *                         description="Token amount that was converted from"
     *                     ),
     *                     @OA\Property(
     *                         property="amount_exchanged",
     *                         type="integer",
     *                         description="Token amount that was converted to"
     *                     ),
     *                     example={
     *                         "from": "USD",
     *                         "to": "BRL",
     *                         "amount": 100,
     *                         "amount_exchanged": 516.3294
     *                     }
     *                 )
     *             )
     *         }
     *     )
     * )
     * */
    public function convert(CurrencyConvertRequest $request)
    {
        $convertedServiceResponse = $this->currencyService->convert($request);

        if ($convertedServiceResponse->json('success')) {
            $response = [
                "from" => $request->from,
                "to" => $request->to,
                "amount" => $request->amount,
                "amount_exchanged" => $convertedServiceResponse->json('result'),
            ];
            return response()->json($response);
        }
        return response()->json(['error' => $convertedServiceResponse], 500);
    }
}
