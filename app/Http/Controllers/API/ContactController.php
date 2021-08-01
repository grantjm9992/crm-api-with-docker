<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Contacts;
use Illuminate\Http\Response;
use Validator;
use App\Http\Resources\Contact as ContactResource;

class ContactController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $contacts = Contacts::whereRaw('1 = 1')->get();
        // $contacts->whereRaw($this->makeWhere($request));

        return $this->sendResponse(ContactResource::collection($contacts), 'Contacts retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $contact = Contacts::create($input);

        return $this->sendResponse(new ContactResource($contact), 'Contact created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $contact = Contacts::find($id);

        $contact->campaign;
        $contact->tasks;
        if (is_null($contact)) {
            return $this->sendError('Contact not found.');
        }

        return $this->sendResponse(new ContactResource($contact), 'Contact retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy(Contacts $contact)
    {
        $contact->delete();

        return $this->sendResponse([], 'Contact deleted successfully.');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     */
    protected function makeWhere(Request $request)
    {
        $where = '';
        if ($request)
        {
        }
        return $where;
    }
}
