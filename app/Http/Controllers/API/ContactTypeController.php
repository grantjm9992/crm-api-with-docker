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
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = ApiToken::getUserFromRequest($request);
        $clients = ContactType::where('company_id', $user->company_id);
    
        return $this->sendResponse(ContactTypeResource::collection($clients->get()), 'ContactType retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
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
   
        $contactType = ContactType::create($input);
   
        return $this->sendResponse(new ContactTypeResource($contactType), 'ContactType created successfully.');
    } 
   
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contactType = ContactType::find($id);
  
        if (is_null($contactType)) {
            return $this->sendError('ContactType not found.');
        }
   
        return $this->sendResponse(new ContactTypeResource($contactType), 'ContactType retrieved successfully.');
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ContactType $contactType)
    {
        $contactType->delete();
   
        return $this->sendResponse([], 'ContactType deleted successfully.');
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
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