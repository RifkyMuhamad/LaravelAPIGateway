<?php

namespace Tests\Feature;

use App\Models\Contact;
use Database\Seeders\ContactSeeder;
use Database\Seeders\SearchSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ContactTest extends TestCase
{
    /**
     * @test
     */
    public function createSuccess(): void
    {
        $this->seed([UserSeeder::class]);

        $this->post(
            DontUseTest::contactsRoute(),
            [
                'first_name' => 'Dyone',
                'last_name' => 'Strankers',
                'email' => 'dyone@dyone.com',
                'phone' => '082121212121'
            ],
            DontUseTest::correctAuthorization()
        )->assertStatus(201)
            ->assertJson([
                'data' => [
                    'first_name' => 'Dyone',
                    'last_name' => 'Strankers',
                    'email' => 'dyone@dyone.com',
                    'phone' => '082121212121'
                ]
            ]);
    }

    /**
     * @test
     */
    public function createFailed(): void
    {
        $this->seed([UserSeeder::class]);

        $this->post(
            DontUseTest::contactsRoute(),
            [
                'first_name' => '',
                'last_name' => 'Strankers',
                'email' => 'dyoneAja',
                'phone' => '082121212121'
            ],
            DontUseTest::correctAuthorization()
        )->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'first_name' => [
                        'The first name field is required.'
                    ],
                    'email' => [
                        'The email field must be a valid email address.'
                    ],
                ]
            ]);
    }

    /**
     * @test
     */
    public function createUnauthorized(): void
    {
        $this->seed([UserSeeder::class]);

        $this->post(
            DontUseTest::contactsRoute(),
            [
                'first_name' => '',
                'last_name' => 'Strankers',
                'email' => 'dyoneAja',
                'phone' => '082121212121'
            ],
            DontUseTest::wrongAuthorization()
        )->assertStatus(401)
            ->assertJson(DontUseTest::unAuthorized());
    }

    /**
     * @test
     */
    public function getSuccess(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $this->get(
            DontUseTest::contactsIdContactRoute(),
            DontUseTest::correctAuthorization()
        )->assertStatus(200)
            ->assertJson([
                'data' => [
                    'first_name' => 'test',
                    'last_name' => 'test',
                    'email' => 'test@dyone.com',
                    'phone' => '086464646464',
                ]
            ]);
    }

    /**
     * @test
     */
    public function getNotFound(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $this->get(
            DontUseTest::contactsIdContactRouteWrong(),
            DontUseTest::correctAuthorization()
        )->assertStatus(404)
            ->assertJson(DontUseTest::notFoundResponse());
    }

    /**
     * @test
     */
    public function getOtherUserContact(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $this->get(
            DontUseTest::contactsIdContactRoute(),
            DontUseTest::correctAuthorizationTwo()
        )->assertStatus(404)
            ->assertJson(DontUseTest::notFoundResponse());
    }

    /**
     * @test
     */
    public function updateSuccess(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $this->put(
            DontUseTest::contactsIdContactRoute(), 
            DontUseTest::updateSuccess(),
            DontUseTest::correctAuthorization()
            )->assertStatus(200)
                ->assertJson([
                    'data' => DontUseTest::updateSuccess()
                ]);
    }

    /**
     * @test
     */
    public function updateValidationError(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $this->put(
            DontUseTest::contactsIdContactRoute(), [
            'first_name' => '',
            'last_name' => 'test2',
            'email' => 'test2@dyone.com',
            'phone' => '086464646462',
        ], DontUseTest::correctAuthorization()
        )->assertStatus(400)
            ->assertJson(DontUseTest::firstNameFieldIsRequired());
    }

    /**
     * @test
     */
    public function deleteSuccess(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $this->delete(
            DontUseTest::contactsIdContactRoute(),
            [],
            DontUseTest::correctAuthorization()
            )->assertStatus(200)
                ->assertJson([
                    'data' => true
                ]);
    }

    /**
     * @test
     */
    public function deleteNotFound(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $this->delete(
            DontUseTest::contactsIdContactRouteWrong(), 
            [], 
            DontUseTest::correctAuthorization()
            )->assertStatus(404)
                ->assertJson(DontUseTest::notFoundResponse());
    }

    /**
     * @test
     */
    public function searchByFirstName(): void
    {
        $this->seed([UserSeeder::class, SearchSeeder::class]);

        $response = $this->get(
            '/contacts?name=first', 
            DontUseTest::correctAuthorization()
            )->assertStatus(200)
                ->json();

        Log::info(json_encode($response, JSON_PRETTY_PRINT));

        self::assertEquals(10, count($response['data']));
        self::assertEquals(20, $response['meta']['total']);
    }

    /**
     * @test
     */
    public function searchByLastName(): void
    {
        $this->seed([UserSeeder::class, SearchSeeder::class]);

        $response = $this->get(
            '/contacts?name=last', 
            DontUseTest::correctAuthorization()
            )->assertStatus(200)
                ->json();

        Log::info(json_encode($response, JSON_PRETTY_PRINT));

        self::assertEquals(10, count($response['data']));
        self::assertEquals(20, $response['meta']['total']);
    }

    /**
     * @test
     */
    public function searchByEmail(): void
    {
        $this->seed([UserSeeder::class, SearchSeeder::class]);

        $response = $this->get(
            '/contacts?email=test',
            DontUseTest::correctAuthorization()
            )->assertStatus(200)
                ->json();

        Log::info(json_encode($response, JSON_PRETTY_PRINT));

        self::assertEquals(10, count($response['data']));
        self::assertEquals(20, $response['meta']['total']);
    }

    /**
     * @test
     */
    public function searchByPhone(): void
    {
        $this->seed([UserSeeder::class, SearchSeeder::class]);

        $response = $this->get(
            '/contacts?phone=08818181818',
            DontUseTest::correctAuthorization()
            )->assertStatus(200)
                ->json();

        Log::info(json_encode($response, JSON_PRETTY_PRINT));

        self::assertEquals(10, count($response['data']));
        self::assertEquals(20, $response['meta']['total']);
    }

    /**
     * @test
     */
    public function searchNotFound(): void
    {
        $this->seed([UserSeeder::class, SearchSeeder::class]);

        $response = $this->get(
            '/contacts?name=salah', 
            DontUseTest::correctAuthorization()
            )->assertStatus(200)
                ->json();

        Log::info(json_encode($response, JSON_PRETTY_PRINT));

        self::assertEquals(0, count($response['data']));
        self::assertEquals(0, $response['meta']['total']);
    }

    /**
     * @test
     */
    public function searchWithPage(): void
    {
        $this->seed([UserSeeder::class, SearchSeeder::class]);

        $response = $this->get(
            '/contacts?size=5&page=2', 
            DontUseTest::correctAuthorization()
            )->assertStatus(200)
                ->json();

        Log::info(json_encode($response, JSON_PRETTY_PRINT));

        self::assertEquals(5, count($response['data']));
        self::assertEquals(20, $response['meta']['total']);
        self::assertEquals(2, $response['meta']['current_page']);
    }
}
