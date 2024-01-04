<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * @test
     */
    public function registerSuccess(): void
    {
        $this->post(
            DontUseTest::usersRoute(), [
            "username" => "dyone",
            "password" => "rahasia123",
            "name" => "Dyone Strankers"
        ])->assertStatus(201)
            ->assertJson([
                "data" => [
                    "username" => "dyone",
                    "name" => "Dyone Strankers"
                ]
            ]);
    }

    /**
     * @test
     */
    public function registerFailed(): void
    {
        $this->post(
            DontUseTest::usersRoute(), [
            "username" => "",
            "password" => "",
            "name" => ""
        ])->assertStatus(400)
            ->assertJson(DontUseTest::usernamePasswordNameRequired());
    }

    /**
     * @test
     */
    public function registerAlreadyExist(): void
    {
        $this->registerSuccess();
        $this->post(
            DontUseTest::usersRoute(), [
            "username" => "dyone",
            "password" => "rahasia123",
            "name" => "Dyone Strankers"
        ])->assertStatus(400)
            ->assertJson(DontUseTest::usernameAlreadyRegistered());
    }

    /**
     * @test
     */
    public function loginSuccess(): void
    {
        $this->seed([UserSeeder::class]);
        $this->post(DontUseTest::usersLoginRoute(), [
            "username" => "test",
            "password" => "test",
        ])->assertStatus(200)
            ->assertJson([
                "data" => [
                    "username" => "test",
                    "name" => "test"
                ]
            ]);

        $user = DontUseTest::userWhereUsernameTest();
        self::assertNotNull($user->token);
    }

    /**
     * @test
     */
    public function loginFailed(): void
    {
        $this->post(DontUseTest::usersLoginRoute(), [
            "username" => "test",
            "password" => "test",
        ])->assertStatus(401)
            ->assertJson(DontUseTest::usernameOrPasswordWrong());
    }

    /**
     * @test
     */
    public function loginFailedWrongPassword(): void
    {
        $this->seed([UserSeeder::class]);
        $this->post(DontUseTest::usersLoginRoute(), [
            "username" => "test",
            "password" => "salah",
        ])->assertStatus(401)
            ->assertJson(DontUseTest::usernameOrPasswordWrong());
    }

    /**
     * @test
     */
    public function getSuccess()
    {
        $this->seed([UserSeeder::class]);

        $this->get(
            DontUseTest::usersCurrentRoute(), 
            DontUseTest::correctAuthorization()
            )->assertStatus(200)
                ->assertJson([
                    "data" => [
                        "username" => "test",
                        "name" => "test"
                    ]
                ]);
    }

    /**
     * @test
     */
    public function getUnauthorized()
    {
        $this->seed([UserSeeder::class]);

        $this->get(DontUseTest::usersCurrentRoute())
            ->assertStatus(401)
            ->assertJson(DontUseTest::unAuthorized());
    }

    /**
     * @test
     */
    public function getInvalidToken()
    {
        $this->seed([UserSeeder::class]);

        $this->get(DontUseTest::usersCurrentRoute(), [
            "Authorization" => "salah"
        ])->assertStatus(401)->assertJson(DontUseTest::unAuthorized());
    }

    /**
     * @test
     */
    public function updatePasswordSuccess()
    {
        $this->seed([UserSeeder::class]);
        $oldUser = DontUseTest::userWhereUsernameTest();

        $this->patch(
            DontUseTest::usersCurrentRoute(),
            [
                "password" => "baru"
            ],
            DontUseTest::correctAuthorization()
        )->assertStatus(200)
            ->assertJson([
                "data" => [
                    "username" => "test",
                    "name" => "test"
                ]
            ]);

        $newUser = DontUseTest::userWhereUsernameTest();

        self::assertNotEquals($oldUser->password, $newUser->password);
    }

    /**
     * @test
     */
    public function updateNameSuccess()
    {
        $this->seed([UserSeeder::class]);
        $oldUser = DontUseTest::userWhereUsernameTest();

        $this->patch(
            DontUseTest::usersCurrentRoute(),
            [
                "name" => "DyoneStrankers"
            ],
            DontUseTest::correctAuthorization()
        )->assertStatus(200)
            ->assertJson([
                "data" => [
                    "username" => "test",
                    "name" => "DyoneStrankers"
                ]
            ]);

        $newUser = DontUseTest::userWhereUsernameTest();

        self::assertNotEquals($oldUser->name, $newUser->name);
    }

    /**
     * @test
     */
    public function updateFailed()
    {
        $this->seed([UserSeeder::class]);

        $this->patch(
            DontUseTest::usersCurrentRoute(),
            [
                "name" => "WleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleo"
            ],
            DontUseTest::correctAuthorization()
        )->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "name" => [
                        "The name field must not be greater than 100 characters."
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function logoutSuccess()
    {
        $this->seed([UserSeeder::class]);

        $this->delete(uri: '/users/logout', headers: DontUseTest::correctAuthorization())->assertStatus(200)
            ->assertJson([
                "data" => true
            ]);

        $user = DontUseTest::userWhereUsernameTest();
        self::assertNull($user->token);
    }

    /**
     * @test
     */
    public function logoutFailed()
    {
        $this->seed([UserSeeder::class]);

        $this->delete(uri: '/users/logout', headers: [
            'Authorization' => "salah"
        ])->assertStatus(401)->assertJson(DontUseTest::unAuthorized());
    }
}
