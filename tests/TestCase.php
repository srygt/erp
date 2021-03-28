<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function mockModel($class, $attributes) {
        $mockedModel = \Mockery::mock($class);

        foreach ($attributes as $key => $value) {
            if (!is_array($value)) {
                $mockedModel
                    ->shouldReceive('getAttribute')
                    ->with($key)
                    ->andReturn($value);
            }
            else {
                $mockedModel
                    ->shouldReceive('getAttribute')
                    ->with($key)
                    ->andReturn(json_decode(json_encode($value)));
            }
        }

        return $mockedModel;
    }
}
