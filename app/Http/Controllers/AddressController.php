<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressCreateRequest;
use App\Http\Requests\AddressUpdateRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use App\Models\Contact;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{

    private function getAddress(Contact $contact, int $idAddress):Address
    {
        $address = Address::where('contact_id', $contact->id)->where('id', $idAddress)->first();
        if (!$address) {
            throw new HttpResponseException(DontUseController::notFoundResponse());
        }
        return $address;
    }

    public function create(int $idContact, AddressCreateRequest $req): JsonResponse
    {
        $user = Auth::user();
        $contact = ContactController::getContact($user, $idContact);
        $data = $req->validated();
        $address = new Address($data);
        $address->contact_id = $contact->id;
        $address->save();
        return (new AddressResource($address))->response()->setStatusCode(201);
    }

    public function get(int $idContact, int $idAddress): AddressResource
    {
        $user = Auth::user();
        $contact = ContactController::getContact($user, $idContact);
        $address = $this->getAddress($contact, $idAddress);
        return new AddressResource($address);
    }

    public function update(int $idContact, int $idAddress, AddressUpdateRequest $req):AddressResource
    {
        $user = Auth::user();
        $contact = ContactController::getContact($user, $idContact);
        $address = $this->getAddress($contact, $idAddress);
        $data = $req->validated();
        $address->fill($data);
        $address->save();
        return new AddressResource($address);
    }

    public function delete(int $idContact, int $idAddress):JsonResponse
    {
        $user = Auth::user();
        $contact = ContactController::getContact($user, $idContact);
        $address = $this->getAddress($contact, $idAddress);
        $address->delete();
        return response()->json([
            'data' => true
        ])->setStatusCode(200);
    }

    public function list(int $idContact):JsonResponse
    {
        $user = Auth::user();
        $contact = ContactController::getContact($user, $idContact);
        $address = Address::where('contact_id', $contact->id)->get();
        return (AddressResource::collection($address))->response()->setStatusCode(200);
    }
}
