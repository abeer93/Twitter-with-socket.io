<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker\Factory;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * overide setUp phpunit method.
     */
    protected function setUp()
    {
        parent::setUp();
        // prevent laravel from handle exceptions && hiding errors that make test cases failed
        $this->withoutExceptionHandling();
        // return a dummy user using user factory see @UserFactory
         $this->user = factory('App\User')->create();
         // create faker object to create random data
         $this->faker = Factory::create();
    }
}
