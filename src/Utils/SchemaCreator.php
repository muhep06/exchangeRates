<?php

namespace Muhep\ExchangeRates\Utils;


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Muhep\ExchangeRates\Models\DynamicModel;

class SchemaCreator {

    private $table;

    public function setTable(Table $table) {
        $this->table = $table;
    }

    public function execute() {
        if (!$this->table->isContinueIfExist()) {
            if (Schema::hasTable($this->table->getTable())) {
                return;
            }
        }
        if ($this->table->isDropIfExist()) {
            Schema::dropIfExists($this->table->getTable());
        }
        $columns = $this->table->getColumns();
        Schema::create($this->table->getTable(), function (Blueprint $table) use($columns) {
            foreach ($columns as $column) {
                $item = $table->{$column['types'][0]}($column['name']);
                $extras = $column['types']['extras'];
                foreach ($extras as $key=>$extra) {
                    if ($key !== 'relation') {
                        if ($extra == 'nullable') {
                            $item->nullable();
                        } else if ($extra == 'unique') {
                            $item->unique();
                        } else if ($extra == 'index') {
                            $item->index();
                        } else if ($extra == 'autoIncrement') {
                            $item->autoIncrement();
                        } else if ($extra == 'primary') {
                            $item->primary();
                        }
                    } else {
                        $relations = $extra;
                        if (is_array($relations)) {
                            $table->foreign($column['name'])
                                ->references($relations['references'])
                                ->on($relations['on'])
                                ->onDelete('cascade');
                        }
                    }
                }
            }
            if ($this->table->isUseSoftDelete()) {
                $table->softDeletes();
            }
            $table->timestamps();
        });
    }

    public static function dropTables(...$var)
    {
        foreach ($var as $table) {
            if (is_string($table)) {
                Schema::dropIfExists($table);
            }
        }
    }

    public static function isEmpty($table)
    {
        $model = new DynamicModel();
        $model->setTable($table);
        if (count($model->get()) <= 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function isExists(string $table): bool {
        if (Schema::hasTable($table)) {
            return true;
        } else {
            return false;
        }
    }
}
