<?php

namespace App\Providers;

use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('activation', function ($sourceAttribute, $value, $parameters, \Illuminate\Validation\Validator $validator) {
            list($primaryAttribute, $modelClass, $primaryColumn, $enableColumn)   = $parameters;

            $explodedPrimaryAttribute = collect(explode('.', $primaryAttribute));

            // converting "*" symbols to static keys
            if ($explodedPrimaryAttribute->count() > 0)
            {
                $explodedSourceAttribute = explode('.', $sourceAttribute);

                $renderedPrimaryAttribute = $explodedPrimaryAttribute
                    ->map(function($item, $key) use (&$explodedSourceAttribute) {
                        if ($item === '*') {
                            return $explodedSourceAttribute[$key];
                        }

                        return $item;
                    });

                $renderedPrimaryAttribute = $renderedPrimaryAttribute->join('.');
            }
            else
            {
                $renderedPrimaryAttribute = $primaryAttribute;
            }


            $targetValue = data_get($validator->getData(), $renderedPrimaryAttribute);

            if (is_null($targetValue)) {
                return true;
            }

            /** @var Model $model */
            $model = app($modelClass);

            /** @var Model $record */
            $record = $model->where($primaryColumn, $targetValue)->first();

            if (is_null($record)) {
                return true;
            }

            if (! empty((float)($value)) && $record->{$enableColumn}) {
                return true;
            }
            else if (empty((float)($value)) && ! $record->{$enableColumn}) {
                return true;
            }

            return false;
        });

        $this->app->singleton(Generator::class, function () {
            return Factory::create('tr_TR');
        });
    }
}
