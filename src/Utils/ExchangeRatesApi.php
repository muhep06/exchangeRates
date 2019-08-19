<?php


namespace Muhep\ExchangeRates\Utils;


use Muhep\ExchangeRates\Interfaces\ExchangeRatesApiInterface;

class ExchangeRatesApi implements ExchangeRatesApiInterface
{
    public function boot()
    {
        CustomLogger::initialize('exchangeRates_exceptions');
        try {
            //throw new \Exception('Görüyorsunuz. Anlatmaya gerek yok.'); // Logger test etmek için sahte hata

            //SchemaCreator::dropTables('b', 'a');  // Girilen sıraya göre tabloları siler. Relationship bulunan tablolar için ideal.
           /* $schema = new SchemaCreator(); // Tabloları oluşturmak için arayüz.

            $table = new Table('a'); // Yeni tablo için ortam oluşturur.
            $table->bigIncrements('id')
                ->string('unit')
                ->string('isim')*/
                //
                // Relationship için yorum ekle
                // O--->
                /*->string('forexBuying')
                ->nullable()
                ->string('forexSelling')
                ->nullable()
                ->string('banknoteBuying')
                ->nullable()
                ->string('banknoteSelling')
                ->nullable();
            // >---O

            $schema->setTable($table);
            $table->setContinueIfExist(false); // Eğer tablo varsa tablo oluşturmayı durdurabilir veya oluşturmayı deneyebilmeyi sağlar.
            $schema->execute(); // Belirtilen tabloyu oluşturur.*/


            //
            // Relatioship ilişki için yorumu kaldır
            // O--->
            /*$b = new Table('b');
            $b->bigIncrements('id')
                ->unsignedBigInteger('a_id')
                ->relation('id', 'a')  // Kendinden önceki için relatinship ayarlar.
                ->string('forexBuying')
                ->nullable() // Kendinden önceki column için boş olabileceğini belirtir.
                ->string('forexSelling')
                ->nullable()
                ->string('banknoteBuying')
                ->nullable()
                ->string('banknoteSelling')
                ->nullable();
            $schema->setTable($b);
            $schema->execute();*/
            // >---O

            $xmlParser = new XmlParser();
            $xmlParser
                ->loadXmlFromUrl('https://www.tcmb.gov.tr/kurlar/today.xml') // Belirtilen Xmli urlden alır
                ->setIndex('Currency')
                ->setTable('a') // Hedef tabloyu belirler
                ->insert('unit', 'Unit') // Hedef tabloya veri eklemek için kullanılır. 1. tablodaki column; 2. Xmldeki key
                ->insert('isim', 'Isim')
                //
                // Relatioship ilişki için yorumu kaldır
                // O--->
                /*->setTable('b')
                ->relation('a_id', function (DynamicModel $model, XMLParserRelation $relation) {
                    return null;
                })*/
                // >---O
                ->insert('forexBuying', 'ForexBuying')
                ->insert('forexSelling', 'ForexSelling')
                ->insert('banknoteBuying', 'BanknoteBuying')
                ->insert('banknoteSelling', 'BanknoteSelling')
                ->update()  // Eğer hedef tablo boş değilde tabloyu okur, xml ile karşılaştırır ve gereken kısımları günceller.
                ->import();  // Eğer hedef tablo boş ise tabloyu xml ve belirtilenlere göre doldurur.
        } catch (\Exception $exception) {
            CustomLogger::log($exception);
        }
    }
}
