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
        $this->post('/users', [
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
        $this->post('/users', [
            "username" => "",
            "password" => "",
            "name" => ""
        ])->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "username" => ["The username field is required."],
                    "password" => ["The password field is required."],
                    "name" => ["The name field is required."],
                ]
            ]);
    }

    /**
     * @test
     */
    public function registerAlreadyExist(): void
    {
        $this->registerSuccess();
        $this->post('/users', [
            "username" => "dyone",
            "password" => "rahasia123",
            "name" => "Dyone Strankers"
        ])->assertStatus(400)
            ->assertJson([
                "errors" => [
                    "username" => [
                        "username already registered"
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function loginSuccess(): void
    {
        $this->seed([UserSeeder::class]);
        $this->post('/users/login', [
            "username" => "test",
            "password" => "test",
        ])->assertStatus(200)
            ->assertJson([
                "data" => [
                    "username" => "test",
                    "name" => "test"
                ]
            ]);

        $user = User::where("username", "test")->first();
        self::assertNotNull($user->token);
    }

    /**
     * @test
     */
    public function loginFailed(): void
    {
        $this->post('/users/login', [
            "username" => "test",
            "password" => "test",
        ])->assertStatus(401)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "username or password wrong"
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function loginFailedWrongPassword(): void
    {
        $this->seed([UserSeeder::class]);
        $this->post('/users/login', [
            "username" => "test",
            "password" => "salah",
        ])->assertStatus(401)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "username or password wrong"
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function getSuccess()
    {
        $this->seed([UserSeeder::class]);

        $this->get('/users/current', [
            "Authorization" => "test"
        ])->assertStatus(200)
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

        $this->get('/users/current')
            ->assertStatus(401)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "unauthorized"
                    ],
                ]
            ]);
    }

    /**
     * @test
     */
    public function getInvalidToken()
    {
        $this->seed([UserSeeder::class]);

        $this->get('/users/current', [
            "Authorization" => "salah"
        ])->assertStatus(401)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "unauthorized"
                    ],
                ]
            ]);
    }

    /**
     * @test
     */
    public function updatePasswordSuccess()
    {
        $this->seed([UserSeeder::class]);
        $oldUser = User::where("username", 'test')->first();

        $this->patch(
            '/users/current',
            [
                "password" => "baru"
            ],
            [
                "Authorization" => "test"
            ]
        )->assertStatus(200)
            ->assertJson([
                "data" => [
                    "username" => "test",
                    "name" => "test"
                ]
            ]);

        $newUser = User::where("username", 'test')->first();

        self::assertNotEquals($oldUser->password, $newUser->password);
    }

    /**
     * @test
     */
    public function updateNameSuccess()
    {
        $this->seed([UserSeeder::class]);
        $oldUser = User::where("username", 'test')->first();

        $this->patch(
            '/users/current',
            [
                "name" => "DyoneStrankers"
            ],
            [
                "Authorization" => "test"
            ]
        )->assertStatus(200)
            ->assertJson([
                "data" => [
                    "username" => "test",
                    "name" => "DyoneStrankers"
                ]
            ]);

        $newUser = User::where("username", 'test')->first();

        self::assertNotEquals($oldUser->name, $newUser->name);
    }

    /**
     * @test
     */
    public function updateFailed()
    {
        $this->seed([UserSeeder::class]);

        $this->patch(
            '/users/current',
            [
                "name" => "WleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleoWleo"
            ],
            [
                "Authorization" => "test"
            ]
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

        $this->delete(uri: '/users/logout', headers: [
            'Authorization' => "test"
        ])->assertStatus(200)
            ->assertJson([
                "data" => true
            ]);

        $user = User::where("username", "test")->first();
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
        ])->assertStatus(401)
            ->assertJson([
                "errors" => [
                    "message" => [
                        "unauthorized"
                    ]
                ]
            ]);
    }
}
