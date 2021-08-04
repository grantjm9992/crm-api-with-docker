<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\ContactType;
use App\Http\Middleware\ApiToken;
use Validator;
use App\Http\Resources\ContactType as ContactTypeResource;

class ContactTypeController extends BaseController
{
    public function index(Request $request)
    {
        $user = ApiToken::getUserFromRequest($request);
        $clients = ContactType::where('company_id', $user->company_id);

        return $this->sendResponse(ContactTypeResource::collection($clients->get()), 'ContactType retrieved successfully.');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $contactType = ContactType::create($input);

        return $this->sendResponse(new ContactTypeResource($contactType), 'ContactType created successfully.');
    }

    public function show($id)
    {
        $contactType = ContactType::find($id);

        if (is_null($contactType)) {
            return $this->sendError('ContactType not found.');
        }

        return $this->sendResponse(new ContactTypeResource($contactType), 'ContactType retrieved successfully.');
    }

    public function update(Request $request, ContactType $contactType)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $contactType->update($input);

        return $this->sendResponse(new ContactTypeResource($contactType), 'ContactType updated successfully.');
    }

    public function destroy(ContactType $contactType)
    {
        $contactType->delete();

        return $this->sendResponse([], 'ContactType deleted successfully.');
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
