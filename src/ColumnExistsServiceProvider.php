<?php

namespace Cyrus\Blueprint;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\ColumnDefinition;
use Illuminate\Support\Fluent;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AuthServiceProvider extends ServiceProvider {
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blueprint::macro('columnExists', function (string $column) {
            return Schema::hasColumn($this->getTable(), $column);
        });

        Blueprint::macro('addColumnUnlessExists', function (string $type, string $column, array $parameters = []) {
            return $this->columnExists($column) ? new ColumnDefinition : $this->addColumn($type, $column, $parameters);
        });

        Blueprint::macro('dropColumnIfExists', function (string $column) {
            return $this->columnExists($column) ? $this->dropColumn($column) : new Fluent;
        });

        Blueprint::macro('timestampsUnlessExist', function () {
            $columns = ['created_at', 'updated_at', 'deleted_at'];
            foreach ($columns as $column) {
                $this->addColumnUnlessExists('timestamp', $column, ['precision' => 0])->nullable();
            }
            $columns = ['created_by', 'updated_by', 'deleted_by'];
            foreach ($columns as $column) {
                $this->addColumnUnlessExists('integer', $column, [])->nullable();
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
