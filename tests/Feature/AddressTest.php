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

        $this->post(
            DontUseTest::contactsIdContactAddressesRoute(),
            DontUseTest::addressCompleted(),
            DontUseTest::correctAuthorization()
        )->assertStatus(201)
            ->assertJson(DontUseTest::dataAddressCompleted());
    }

    /**
     * @test
     */
    public function createFailed(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $this->post(
            DontUseTest::contactsIdContactAddressesRoute(), [
            'street' => 'Sukaraja',
            'city' => 'Majalengka',
            'province' => 'Jawa Barat',
            'country' => '',
            'postal_code' => '45454'
        ], DontUseTest::correctAuthorization()
        )->assertStatus(400)
            ->assertJson(DontUseTest::countryFieldIsRequired());
    }

    /**
     * @test
     */
    public function createContactNotFound(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class]);

        $this->post(
            DontUseTest::contactsIdContactAddressesRouteWrong(),
            DontUseTest::addressSuccessResponse(),
            DontUseTest::correctAuthorization()
        )->assertStatus(404)
            ->assertJson(DontUseTest::notFoundResponse());
    }

    /**
     * @test
     */
    public function getSuccess(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $this->get(
            DontUseTest::contactsIdContactAddressesIdAddressRoute(), 
            DontUseTest::correctAuthorization()
            )->assertStatus(200)
                ->assertJson([
                    'data' => DontUseTest::addressSuccessResponse()
                ]);
    }

    /**
     * @test
     */
    public function getNotFound(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $this->get(
            DontUseTest::contactsIdContactAddressesIdAddressRouteWrong(), 
            DontUseTest::correctAuthorization()
            )->assertStatus(404)
                ->assertJson(DontUseTest::notFoundResponse());
    }

    /**
     * @test
     */
    public function updateSuccess(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $this->put(
            DontUseTest::contactsIdContactAddressesIdAddressRoute(), [
            'street' => 'Sukaraja Update',
            'city' => 'Majalengka Update',
            'province' => 'Jawa Barat Update',
            'country' => 'Indonesia Update',
            'postal_code' => '99999'
        ], DontUseTest::correctAuthorization()
        )->assertStatus(200)
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

        $this->put(
            DontUseTest::contactsIdContactAddressesIdAddressRoute(), [
            'street' => 'Sukaraja Update',
            'city' => 'Majalengka Update',
            'province' => 'Jawa Barat Update',
            'country' => '',
            'postal_code' => '99999'
        ], DontUseTest::correctAuthorization())->assertStatus(400)
            ->assertJson(DontUseTest::countryFieldIsRequired());
    }

    /**
     * @test
     */
    public function updateNotFound(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $this->put(DontUseTest::contactsIdContactAddressesIdAddressRouteWrong(), [
            'street' => 'Sukaraja Update',
            'city' => 'Majalengka Update',
            'province' => 'Jawa Barat Update',
            'country' => 'Indonesia Update',
            'postal_code' => '99999'
        ], DontUseTest::correctAuthorization()
        )->assertStatus(404)
            ->assertJson(DontUseTest::notFoundResponse());
    }

    /**
     * @test
     */
    public function deleteSuccess(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $this->delete(
            DontUseTest::contactsIdContactAddressesIdAddressRoute(), 
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
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $address = Address::query()->limit(1)->first();

        $this->delete('/contacts/' . $address->contact_id . '/addresses/' . ($address->id + 1), [], DontUseTest::correctAuthorization())->assertStatus(404)
            ->assertJson(DontUseTest::notFoundResponse());
    }

    /**
     * @test
     */
    public function listSuccess(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);


        $this->get(
            DontUseTest::contactsIdContactAddressesRoute(), 
            DontUseTest::correctAuthorization()
            )->assertStatus(200)
            ->assertJson([
                'data' => [
                    DontUseTest::addressSuccessResponse()
                ]
            ]);
    }

    /**
     * @test
     */
    public function listContactNotFound(): void
    {
        $this->seed([UserSeeder::class, ContactSeeder::class, AddressSeeder::class]);

        $this->get(
            DontUseTest::contactsIdContactAddressesRouteWrong(),
            DontUseTest::correctAuthorization()
            )->assertStatus(404)
                ->assertJson(DontUseTest::notFoundResponse());
    }
}
