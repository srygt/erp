<?php

namespace App\Providers;

use App\Models\Abone;
use App\Models\AyarEkKalem;
use App\Services\Sms\Contracts\SmsGatewayContract;
use App\Services\Sms\Gateways\VizyonMesaj\VizyonMesajGatewayService;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
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
        $this->app->bind(SmsGatewayContract::class, VizyonMesajGatewayService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Validator::extend('ek_kalem_exists', function ($attribute, $value, $parameters, \Illuminate\Validation\Validator $validator) {
            list($type) = $parameters;

            $ekKalem    = AyarEkKalem::where(AyarEkKalem::COLUMN_ID, $value);

            if ($type) {
                $ekKalem = $ekKalem->where(AyarEkKalem::COLUMN_UCRET_TUR, $type);
            }

            return $ekKalem->exists();
        });

        Validator::extend('abone_exists', function ($attribute, $value, $parameters, \Illuminate\Validation\Validator $validator) {
            list($type)  = $parameters;

            return Abone::where(Abone::COLUMN_ABONE_NO, $value)
                ->where(Abone::COLUMN_TUR, $type)
                ->exists();
        });

        Validator::extend('abone_activation', function ($sourceAttribute, $value, $parameters, \Illuminate\Validation\Validator $validator) {
            list($primaryAttribute, $aboneType, $enableColumn)   = $parameters;

            $modelClass = Abone::class;
            $primaryColumn = Abone::COLUMN_ABONE_NO;

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
            $record = $model
                ->where($primaryColumn, $targetValue)
                ->where(Abone::COLUMN_TUR, $aboneType)
                ->first();

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
