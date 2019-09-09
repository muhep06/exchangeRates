<?php


namespace Muhep\ExchangeRates\Endpoints;


use AcikVeri\Importer\XMLImporter\XMLImporter;
use App\Utils\ApiHelper;
use App\Utils\GenerateApi;
use App\Utils\UpdateHelper;
use Muhep\ExchangeRates\Models\ExchangeRate;
use Muhep\ExchangeRates\Utils\ExchangeRatesApi;
use Muhep\vendor\acikveri\importer;
class Endpoint extends GenerateApi
{
    public $apiName = "exchangerates";

    public $description = "Güncel kur bilgileri";

    public $category = 1;

    public function boot(ApiHelper $helper = null)
    {
        return response()->json(ExchangeRate::all(), 200, array(), JSON_PRETTY_PRINT);
    }

    public function update(UpdateHelper $updateHelper = null)
    {
        $xml = new XMLImporter();
        $xml->index = 'Currency';
        $xml
            ->loadFromUrl('https://www.tcmb.gov.tr/kurlar/today.xml')
            ->setModel(ExchangeRate::class)
            ->insert('unit', 'Unit')
            ->insert('isim', 'Isim')
            ->insert('forexBuying', 'ForexBuying')
            ->insert('forexSelling', 'ForexSelling')
            ->insert('banknoteBuying', 'BanknoteBuying')
            ->insert('banknoteSelling', 'BanknoteSelling');

        if (ExchangeRate::count() <= 0) {
            $xml->import();
        } else {
            $xml->update();

        }
    }
}
