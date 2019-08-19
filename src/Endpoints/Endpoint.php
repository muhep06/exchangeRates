<?php


namespace Muhep\ExchangeRates\Endpoints;


use App\Utils\ApiHelper;
use App\Utils\GenerateApi;
use Muhep\ExchangeRates\Models\DynamicModel;
use Muhep\ExchangeRates\Utils\ExchangeRatesApi;

class Endpoint extends GenerateApi
{
    public $apiName = "exchangerates";

    public $description = "Güncel kur bilgileri";

    public $category = 1;

    public function boot(ApiHelper $helper = null)
    {
        $model = new DynamicModel();
        $model->setTable('a');
        return response()->json($model->get(), 200, array(), JSON_PRETTY_PRINT);
    }

    public function update()
    {
        $exchangeRates = new ExchangeRatesApi();
        $exchangeRates->boot();
    }
}
