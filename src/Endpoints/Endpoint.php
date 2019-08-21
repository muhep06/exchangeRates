<?php


namespace Muhep\ExchangeRates\Endpoints;


use AcikVeri\Importer\XMLImporter\XMLImporter;
use App\Utils\ApiHelper;
use App\Utils\GenerateApi;
use Muhep\ExchangeRates\Models\DynamicModel;
use Muhep\ExchangeRates\Utils\ExchangeRatesApi;
use Muhep\vendor\acikveri\importer;
class Endpoint extends GenerateApi
{
    public $apiName = "exchangerates";

    public $description = "Güncel kur bilgileri";

    public $category = 1;

    public function boot(ApiHelper $helper = null)
    {
        $model = new DynamicModel();
        $model->setTable('exchange_rates');
        return response()->json($model->get(), 200, array(), JSON_PRETTY_PRINT);
    }

    public function update()
    {
        $model = new DynamicModel();
        $model->setTable('exchange_rates');
        $xml = new XMLImporter();
        $xml->index = 'Currency';
        $xml
            ->loadFromUrl('https://www.tcmb.gov.tr/kurlar/today.xml')
            ->setTable('exchange_rates')
            ->insert('unit', 'Unit')
            ->insert('isim', 'Isim')
            ->insert('forexBuying', 'ForexBuying')
            ->insert('forexSelling', 'ForexSelling')
            ->insert('banknoteBuying', 'BanknoteBuying')
            ->insert('banknoteSelling', 'BanknoteSelling');
        if ($model->get() ?? []) {
            $xml->update();
        } else {
            $xml->import();
        }
    }
}
