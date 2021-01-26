<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Clear all data in eloquent
     *
     * @param $model
     */
    public function clearModel($model)
    {
        $model::all()->each(function ($item) {
            $item->delete();
        });
    }

    /**
     * Acting test as user
     *
     * @param null $user
     * @param null $role
     * @param string $driver
     * @return array
     */
    public function login($user = null, $role = null, $driver = 'web')
    {
        if (!$user) {
            $user = create(User::class);
        }

        $this->actingAs($user, $driver);

        return $user;
    }

}
