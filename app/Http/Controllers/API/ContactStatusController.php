<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\ContactStatus;
use App\Http\Middleware\ApiToken;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ContactStatus as ContactStatusResource;

class ContactStatusController extends BaseController
{

    public function index(Request $request)
    {
        $user = ApiToken::getUserFromRequest($request);
        $clients = ContactStatus::where('company_id', $user->company_id);

        return $this->sendResponse(ContactStatusResource::collection($clients->get()), 'ContactStatus retrieved successfully.');
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $user = ApiToken::getUserFromRequest($request);
        $input['company_id'] = $user->getAttribute('company_id');

        $validator = Validator::make($input, [
            'name' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $contactStatus = ContactStatus::create($input);

        return $this->sendResponse(new ContactStatusResource($contactStatus), 'ContactStatus created successfully.');
    }

    public function show(int $id)
    {
        $contactStatus = ContactStatus::find($id);

        if (is_null($contactStatus)) {
            return $this->sendError('ContactStatus not found.');
        }

        return $this->sendResponse(new ContactStatusResource($contactStatus), 'ContactStatus retrieved successfully.');
    }

    public function update(Request $request, ContactStatus $contactStatus)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $contactStatus->update($input);

        return $this->sendResponse(new ContactStatusResource($contactStatus), 'ContactStatus updated successfully.');
    }

    public function destroy(ContactStatus $contactStatus)
    {
        $contactStatus->delete();

        return $this->sendResponse([], 'ContactStatus deleted successfully.');
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
