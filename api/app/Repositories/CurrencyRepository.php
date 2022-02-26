<?php

namespace App\Repositories;

use App\Http\Requests\CurrencyGetRequest;
use App\Models\Currency;

class CurrencyRepository
{
    /**
     * @var Currency
     */
    protected $currency;

    public function __construct(Currency $currency)
    {
        $this->currency = $currency;
    }

    /**
     * Get all currencies.
     *
     * @return Currency $currency
     */
    public function getAll(CurrencyGetRequest $request)
    {
        return $this->currency
            ->skip($request->offset)
            ->take($request->limit)
            ->get();
    }
}
