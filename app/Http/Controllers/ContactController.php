<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactCreateRequest;
use App\Http\Requests\ContactUpdateRequest;
use App\Http\Resources\ContactCollection;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public static function getContact(User $user, int $id): Contact
    {
        $contact = Contact::where('id', $id)->where('user_id', $user->id)->first();
        if (!$contact) {
            throw new HttpResponseException(DontUseController::notFoundResponse());
        }
        return $contact;
    }

    public function create(ContactCreateRequest $req): JsonResponse
    {
        $data = $req->validated();
        $user = Auth::user();
        $contact = new Contact($data);
        $contact->user_id = $user->id;
        $contact->save();
        return (new ContactResource($contact))->response()->setStatusCode(201);
    }

    public function get(int $id): ContactResource
    {
        $user = Auth::user();
        $contact = $this->getContact($user, $id);
        return new ContactResource($contact);
    }

    public function update(int $id, ContactUpdateRequest $req): ContactResource
    {
        $user = Auth::user();
        $contact = $this->getContact($user, $id);
        $data = $req->validated();
        $contact->fill($data);
        $contact->save();
        return new ContactResource($contact);
    }

    public function delete(int $id): JsonResponse
    {
        $user = Auth::user();
        $contact = $this->getContact($user, $id);
        $contact->delete();
        return response()->json([
            'data' => true
        ])->setStatusCode(200);
    }

    public function search(Request $req): ContactCollection
    {
        $user = Auth::user();
        $page = $req->input('page', 1);
        $size = $req->input('size', 10);

        $contacts = Contact::query()
            ->where('user_id', $user->id)
            ->search(
                $req->input('name'),
                $req->input('email'),
                $req->input('phone')
            )
            ->paginate(perPage: $size, page: $page);

        return new ContactCollection($contacts);
    }
}










// $contacts = Contact::query()->where('user_id', $user->id);
// $contacts = $contacts->where(function (Builder $builder) use ($req){
//     $name = $req->input('name');
//     if ($name){
//         $builder->where(function (Builder $builder) use ($name){
//             $builder->orWhere('first_name', 'like', '%' . $name . '%');
//             $builder->orWhere('last_name', 'like', '%' . $name . '%');
//         });
//     }
//     $email = $req->input('email');
//     if ($email) {
//         $builder->where('email', 'like', '%' . $email . '%');
//     }
//     $phone = $req->input('phone');
//     if ($phone) {
//         $builder->where('phone', 'like', '%' . $phone . '%');
//     }
// });
// $contacts = $contacts->paginate(perPage: $size, page: $page);