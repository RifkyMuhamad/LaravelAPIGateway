<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Contact;
use Database\Seeders\AddressSeeder;
use Database\Seeders\ContactSeeder;
use Database\Seeders\UserSeeder;
use Tests\TestCase;

class AddressTest extends TestCase
{
    /**
     * @test
     */
    public function createSuccess(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);
        $contact = Contact::query()->limit(1)->first();

        $this->post('/contacts/' . $contact->id . '/addresses', [
            'street' => 'Sukaraja',
            'city' => 'Majalengka',
            'province' => 'Jawa Barat',
            'country' => 'Indonesia',
            'postal_code' => '45454'
        ], [
            'Authorization' => 'test'
        ])->assertStatus(201)
            ->assertJson([
                'data' => [
                    'street' => 'Sukaraja',
                    'city' => 'Majalengka',
                    'province' => 'Jawa Barat',
                    'country' => 'Indonesia',
                    'postal_code' => '45454'
                ]
            ]);
    }

    /**
     * @test
     */
    public function createFailed(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);
        $contact = Contact::query()->limit(1)->first();

        $this->post('/contacts/' . $contact->id . '/addresses', [
            'street' => 'Sukaraja',
            'city' => 'Majalengka',
            'province' => 'Jawa Barat',
            'country' => '',
            'postal_code' => '45454'
        ], [
            'Authorization' => 'test'
        ])->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'country' => [
                        'The country field is required.'
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function createContactNotFound(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);
        $contact = Contact::query()->limit(1)->first();

        $this->post('/contacts/' . ($contact->id + 1) . '/addresses', [
            'street' => 'Sukaraja',
            'city' => 'Majalengka',
            'province' => 'Jawa Barat',
            'country' => 'Indonesia',
            'postal_code' => '45454'
        ], [
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
    public function getSuccess(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $address = Address::query()->limit(1)->first();

        $this->get('/contacts/' . $address->contact_id . '/addresses/' . $address->id, [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'street' => 'Sukaraja',
                    'city' => 'Majalengka',
                    'province' => 'Jawa Barat',
                    'country' => 'Indonesia',
                    'postal_code' => '45454'
                ]
            ]);
    }

    /**
     * @test
     */
    public function getNotFound(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $address = Address::query()->limit(1)->first();

        $this->get('/contacts/' . $address->contact_id . '/addresses/' . ($address->id + 1), [
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
    public function updateSuccess(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $address = Address::query()->limit(1)->first();

        $this->put('/contacts/' . $address->contact_id . '/addresses/' . $address->id, [
            'street' => 'Sukaraja Update',
            'city' => 'Majalengka Update',
            'province' => 'Jawa Barat Update',
            'country' => 'Indonesia Update',
            'postal_code' => '99999'
        ], [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    'street' => 'Sukaraja Update',
                    'city' => 'Majalengka Update',
                    'province' => 'Jawa Barat Update',
                    'country' => 'Indonesia Update',
                    'postal_code' => '99999'
                ]
            ]);
    }

    /**
     * @test
     */
    public function updateFailed(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $address = Address::query()->limit(1)->first();

        $this->put('/contacts/' . $address->contact_id . '/addresses/' . $address->id, [
            'street' => 'Sukaraja Update',
            'city' => 'Majalengka Update',
            'province' => 'Jawa Barat Update',
            'country' => '',
            'postal_code' => '99999'
        ], [
            'Authorization' => 'test'
        ])->assertStatus(400)
            ->assertJson([
                'errors' => [
                    'country' => [
                        'The country field is required.'
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function updateNotFound(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $address = Address::query()->limit(1)->first();

        $this->put('/contacts/' . $address->contact_id . '/addresses/' . ($address->id + 1), [
            'street' => 'Sukaraja Update',
            'city' => 'Majalengka Update',
            'province' => 'Jawa Barat Update',
            'country' => 'Indonesia Update',
            'postal_code' => '99999'
        ], [
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
    public function deleteSuccess(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $address = Address::query()->limit(1)->first();

        $this->delete('/contacts/' . $address->contact_id . '/addresses/' . $address->id, [], [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                'data' => true
            ]);
    }

    /**
     * @test
     */
    public function deleteNotFound(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $address = Address::query()->limit(1)->first();

        $this->delete('/contacts/' . $address->contact_id . '/addresses/' . ($address->id + 1), [], [
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
    public function listSuccess(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $contact = Contact::query()->limit(1)->first();

        $this->get('/contacts/' . $contact->id . '/addresses/', [
            'Authorization' => 'test'
        ])->assertStatus(200)
            ->assertJson([
                'data' => [
                    [
                        'street' => 'Sukaraja',
                        'city' => 'Majalengka',
                        'province' => 'Jawa Barat',
                        'country' => 'Indonesia',
                        'postal_code' => '45454'
                    ]
                ]
            ]);
    }

    /**
     * @test
     */
    public function listContactNotFound(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $contact = Contact::query()->limit(1)->first();

        $this->get('/contacts/' . ($contact->id + 1) . '/addresses/', [
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
}
