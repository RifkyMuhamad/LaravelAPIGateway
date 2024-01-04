<?php

namespace Tests\Feature;

use App\Models\Contact;
use Database\Seeders\ContactSeeder;
use Database\Seeders\SearchSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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

        $this->post('/contacts', [
            'first_name' => 'Dyone',
            'last_name' => 'Strankers',
            'email' => 'dyone@dyone.com',
            'phone' => '082121212121'
        ], [
            'Authorization' => 'test'
        ])->assertStatus(201)
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

        $this->post('/contacts', [
            'first_name' => '',
            'last_name' => 'Strankers',
            'email' => 'dyoneAja',
            'phone' => '082121212121'
        ], [
            'Authorization' => 'test'
        ])->assertStatus(400)
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

        $this->post('/contacts', [
            'first_name' => '',
            'last_name' => 'Strankers',
            'email' => 'dyoneAja',
            'phone' => '082121212121'
        ], [
            'Authorization' => 'salah'
        ])->assertStatus(401)
            ->assertJson([
                'errors' => [
                    'message' => [
                        'unauthorized'
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function getSuccess(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::query()->limit(1)->first();

        $this->get('/contacts/' . $contact->id, [
            'Authorization' => 'test'
        ])->assertStatus(200)
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

        $contact = Contact::query()->limit(1)->first();

        $this->get('/contacts/' . ($contact->id + 1), [
            'Authorization' => 'test'
        ])->assertStatus(404)
            ->assertJson([
                'errors' => [
                    'message' => [
                        'not found'
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function getOtherUserContact(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::query()->limit(1)->first();

        $this->get('/contacts/' . $contact->id, [
            'Authorization' => 'test2'
        ])->assertStatus(404)
            ->assertJson([
                'errors' => [
                    'message' => [
                        'not found'
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function updateSuccess(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::query()->limit(1)->first();

        $this->put('/contacts/' . $contact->id, [
            'first_name' => 'test2',
            'last_name' => 'test2',
            'email' => 'test2@dyone.com',
            'phone' => '086464646462',
        ], [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'first_name' => 'test2',
                    'last_name' => 'test2',
                    'email' => 'test2@dyone.com',
                    'phone' => '086464646462',
                ]
            ]);
    }

    /**
     * @test
     */
    public function updateValidationError(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::query()->limit(1)->first();

        $this->put('/contacts/' . $contact->id, [
            'first_name' => '',
            'last_name' => 'test2',
            'email' => 'test2@dyone.com',
            'phone' => '086464646462',
        ], [
            'Authorization' => 'test'
        ])->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'first_name' => [
                        "The first name field is required."
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function deleteSuccess():void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::query()->limit(1)->first();

        $this->delete('/contacts/' . $contact->id, [], [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                'data' => true
            ]);
    }

    /**
     * @test
     */
    public function deleteNotFound():void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $contact = Contact::query()->limit(1)->first();

        $this->delete('/contacts/' . ($contact->id + 1), [], [
            'Authorization' => 'test'
        ])->assertStatus(404)
            ->assertJson([
                'errors' => [
                    'message' => [
                        'not found'
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function searchByFirstName():void
    {
        $this->seed([UserSeeder::class, SearchSeeder::class]);

        $response = $this->get('/contacts?name=first', [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->json();

        Log::info(json_encode($response, JSON_PRETTY_PRINT));

        self::assertEquals(10, count($response['data']));
        self::assertEquals(20, $response['meta']['total']);
    }

    /**
     * @test
     */
    public function searchByLastName():void
    {
        $this->seed([UserSeeder::class, SearchSeeder::class]);

        $response = $this->get('/contacts?name=last', [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->json();

        Log::info(json_encode($response, JSON_PRETTY_PRINT));

        self::assertEquals(10, count($response['data']));
        self::assertEquals(20, $response['meta']['total']);
    }

    /**
     * @test
     */
    public function searchByEmail():void
    {
        $this->seed([UserSeeder::class, SearchSeeder::class]);

        $response = $this->get('/contacts?email=test', [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->json();

        Log::info(json_encode($response, JSON_PRETTY_PRINT));

        self::assertEquals(10, count($response['data']));
        self::assertEquals(20, $response['meta']['total']);
    }

    /**
     * @test
     */
    public function searchByPhone():void
    {
        $this->seed([UserSeeder::class, SearchSeeder::class]);

        $response = $this->get('/contacts?phone=08818181818', [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->json();

        Log::info(json_encode($response, JSON_PRETTY_PRINT));

        self::assertEquals(10, count($response['data']));
        self::assertEquals(20, $response['meta']['total']);
    }

    /**
     * @test
     */
    public function searchNotFound():void
    {
        $this->seed([UserSeeder::class, SearchSeeder::class]);

        $response = $this->get('/contacts?name=salah', [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->json();

        Log::info(json_encode($response, JSON_PRETTY_PRINT));

        self::assertEquals(0, count($response['data']));
        self::assertEquals(0, $response['meta']['total']);
    }

    /**
     * @test
     */
    public function searchWithPage():void
    {
        $this->seed([UserSeeder::class, SearchSeeder::class]);

        $response = $this->get('/contacts?size=5&page=2', [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->json();

        Log::info(json_encode($response, JSON_PRETTY_PRINT));

        self::assertEquals(5, count($response['data']));
        self::assertEquals(20, $response['meta']['total']);
        self::assertEquals(2, $response['meta']['current_page']);
    }
}
