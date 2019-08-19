<?php


namespace Muhep\ExchangeRates\Migrations;


use App\Utils\ApiMigration;
use Illuminate\Database\Schema\Blueprint;

class ExchangeRatesTable extends ApiMigration
{
    public $table = "a";

    public function blueprint(): \Closure
    {
        return function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('unit');
            $table->string('isim');
            $table->string('forexBuying')->nullable();
            $table->string('forexSelling')->nullable();
            $table->string('banknoteBuying')->nullable();
            $table->string('banknoteSelling')->nullable();
            $table->timestamps();
        };
    }
}
