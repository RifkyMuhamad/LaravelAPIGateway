<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Contact;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Tests\TestCase;

class DontUseTest extends TestCase
{
    /**
     * Errors Response
     */
    public static function notFoundResponse()
    {
        return [
            'errors' => [
                'message' => [
                    'not found'
                ]
            ]
        ];
    }

    public static function unAuthorized()
    {
        return [
            "errors" => [
                "message" => [
                    "unauthorized"
                ]
            ]
        ];
    }

    public static function firstNameFieldIsRequired()
    {
        return [
            'errors' => [
                'first_name' => [
                    "The first name field is required."
                ]
            ]
        ];
    }

    public static function usernameOrPasswordWrong()
    {
        return [
            "errors" => [
                "message" => [
                    "username or password wrong"
                ]
            ]
        ];
    }

    public static function usernameAlreadyRegistered()
    {
        return [
            "errors" => [
                "username" => [
                    "username already registered"
                ]
            ]
        ];
    }

    public static function usernamePasswordNameRequired()
    {
        return [
            "errors" => [
                "username" => ["The username field is required."],
                "password" => ["The password field is required."],
                "name" => ["The name field is required."],
            ]
        ];
    }

    public static function countryFieldIsRequired()
    {
        return [
            'errors' => [
                'country' => [
                    'The country field is required.'
                ]
            ]
        ];
    }

    /**
     * Normal Response
     */
    public static function addressSuccessResponse()
    {
        return [
            'street' => 'Sukaraja',
            'city' => 'Majalengka',
            'province' => 'Jawa Barat',
            'country' => 'Indonesia',
            'postal_code' => '45454'
        ];
    }

    /**
     * Authorization
     */
    public static function correctAuthorization()
    {
        return [
            'Authorization' => 'test'
        ];
    }

    public static function correctAuthorizationTwo()
    {
        return [
            'Authorization' => 'test2'
        ];
    }

    public static function wrongAuthorization()
    {
        return [
            'Authorization' => 'salah'
        ];
    }

    /**
     * Address
     */
    public static function addressCompleted()
    {
        return [
            'street' => 'Sukaraja',
            'city' => 'Majalengka',
            'province' => 'Jawa Barat',
            'country' => 'Indonesia',
            'postal_code' => '45454'
        ];
    }

    public static function dataAddressCompleted()
    {
        return [
            'data' => self::addressCompleted()
        ];
    }

    /**
     * User Model
     */
    public static function userWhereUsernameTest()
    {
        return User::where("username", 'test')->first();
    }

    /**
     * Contact Model
     */
    public static function contactQueryLimitOneFirst()
    {
        return Contact::query()->limit(1)->first();
    }

    /**
     * Address Model
     */
    public static function addressQueryLimitOneFirst()
    {
        return Address::query()->limit(1)->first();
    }

    /**
     * Route
     */
    public static function usersRoute()
    {
        return '/users';
    }

    public static function usersLoginRoute()
    {
        return '/users/login';
    }

    public static function usersCurrentRoute()
    {
        return '/users/current';
    }

    public static function contactsRoute()
    {
        return '/contacts';
    }

    public static function contactsIdContactRoute()
    {
        $contact = self::contactQueryLimitOneFirst();
        return '/contacts/' . $contact->id;
    }

    public static function contactsIdContactRouteWrong()
    {
        $contact = self::contactQueryLimitOneFirst();
        return '/contacts/' . ($contact->id + 1);
    }

    public static function contactsIdContactAddressesRoute()
    {
        $contact = self::contactQueryLimitOneFirst();

        return '/contacts/' . $contact->id . '/addresses';
    }

    public static function contactsIdContactAddressesRouteWrong()
    {
        $contact = self::contactQueryLimitOneFirst();

        return '/contacts/' . ($contact->id + 1) . '/addresses';
    }

    public static function contactsIdContactAddressesIdAddressRoute()
    {
        $address = self::addressQueryLimitOneFirst();

        return '/contacts/' . $address->contact_id . '/addresses/' . $address->id;
    }

    public static function contactsIdContactAddressesIdAddressRouteWrong()
    {
        $address = self::addressQueryLimitOneFirst();

        return '/contacts/' . $address->contact_id . '/addresses/' . ($address->id + 1);
    }

    /**
     * Special
     */
    public static function updateSuccess()
    {
        return [
            'first_name' => 'test2',
            'last_name' => 'test2',
            'email' => 'test2@dyone.com',
            'phone' => '086464646462',
        ];
    }
}
