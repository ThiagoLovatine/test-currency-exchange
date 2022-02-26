<?php

namespace App\Services;

use App\Http\Requests\CurrencyConvertRequest;
use App\Http\Requests\CurrencyGetRequest;
use App\Models\Currency;
use App\Repositories\CurrencyRepository;
use App\Repositories\PostRepository;
use Exception;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpKernel\Exception\HttpException;

class CurrencyService
{
    /**
     * @var $currencyRepository
     */
    protected $currencyRepository;

    /**
     * CurrencyService constructor.
     *
     * @param CurrencyRepository $currencyRepository
     */
    public function __construct(CurrencyRepository $currencyRepository)
    {
        $this->currencyRepository = $currencyRepository;
    }


    /**
     * Get all currency.
     *
     * @return String
     */
    public function getAll(CurrencyGetRequest $request)
    {
        return $this->currencyRepository->getAll($request);
    }

    /**
     * Convert from one currency value to another
     *
     * @return object
     */
    public function convert(CurrencyConvertRequest $request)
    {
        $response = Http::get(config('fixer-api.url') . 'convert', [
            'access_key'    => config('fixer-api.access_key'),
            'amount'        => $request['amount'],
            'from'          => $request['from'],
            'to'            => $request['to'],
        ]);

        return $response;
    }
}
