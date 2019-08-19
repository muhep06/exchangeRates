<?php


namespace Muhep\ExchangeRates\Utils;


use Muhep\ExchangeRates\Models\DynamicModel;

class CustomLogger
{
    static $table;

    public static function initialize(string $table, bool $reInitialize = false)
    {
        self::$table = $table;

        if ($reInitialize) {
            SchemaCreator::dropTables($table);
        }
        $schema = new SchemaCreator();
        $table = new Table($table);
        $table
            ->uuid('uuid')
            ->primary()
            ->text('message')
            ->nullable()
            ->integer('code')
            ->nullable()
            ->text('file')
            ->nullable()
            ->integer('line')
            ->nullable()
            ->text('trace')
            ->nullable()
            ->softDelete()
            ->setContinueIfExist(false);
        $schema->setTable($table);
        $schema->execute();
    }

    public static function log(\Exception $exception)
    {
        $model = new DynamicModel();
        $model->setTable(self::$table);
        $model->setUseUuid(true);
        $model->message = (string)$exception->getMessage();
        $model->code = (integer)$exception->getCode();
        $model->file = (string)$exception->getFile();
        $model->line = (integer)$exception->getLine();
        $model->trace = $exception->getTraceAsString();
        $model->save();
    }
}
