<?php

namespace App\Http\Controllers\API;

use App\Http\Middleware\ApiToken;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Contacts;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Contact as ContactResource;

class ContactController extends BaseController
{
    public function index(Request $request)
    {
        $contacts = Contacts::whereRaw('1 = 1')->get();
        $newArray = [];

        foreach ($contacts as $contact) {
            $contact->campaign;
            $contact->channel;
            $contact->contactType;
            $newArray[] = $contact;
        }

        return $this->sendResponse(ContactResource::collection($newArray), 'Contacts retrieved successfully.');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $user = ApiToken::getUserFromRequest($request);
        $input['company_id'] = $user->getAttribute('company_id');

        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|unique:contacts'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $contact = Contacts::create($input);

        return $this->sendResponse(new ContactResource($contact), 'Contact created successfully.');
    }

    public function show(string $id)
    {
        $contact = Contacts::find($id);

        $contact->campaign;
        $contact->tasks;
        if (is_null($contact)) {
            return $this->sendError('Contact not found.');
        }

        return $this->sendResponse(new ContactResource($contact), 'Contact retrieved successfully.');
    }

    public function update(Request $request, Contacts $contact)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $contact->update($input);

        return $this->sendResponse(new ContactResource($contact), 'Contact updated successfully.');
    }

    public function destroy(Contacts $contact)
    {
        $contact->delete();

        return $this->sendResponse([], 'Contact deleted successfully.');
    }

    protected function makeWhere(Request $request)
    {
        $where = '';
        if ($request)
        {
        }
        return $where;
    }
}
