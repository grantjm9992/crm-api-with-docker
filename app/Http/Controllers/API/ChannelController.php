<?php

namespace App\Http\Controllers\API;

use App\Channel;
use App\Company;
use App\Http\Resources\ChannelResource;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Middleware\ApiToken;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ChannelController extends BaseController
{
    public function index(Request $request): Response
    {
        $user = ApiToken::getUserFromRequest($request);
        $channels = Channel::where('company_id', $user->company_id);

        return $this->sendResponse(ChannelResource::collection($channels->get()), 'Channels retrieved successfully.');
    }

    public function store(Request $request): Response
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

        $contactType = Channel::create($input);

        return $this->sendResponse(new ChannelResource($contactType), 'Channel created successfully.');
    }


    public function show(string $id): Response
    {
        $contactType = Channel::find($id);

        if (is_null($contactType)) {
            return $this->sendError('ContactType not found.');
        }

        return $this->sendResponse(new ChannelResource($contactType), 'Channel retrieved successfully.');
    }

    public function update(Request $request, Channel $channel): Response
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $channel->update($input);

        return $this->sendResponse(new ChannelResource($channel), 'Channel updated successfully.');
    }

    public function destroy(Channel $channel): Response
    {
        $channel->delete();

        return $this->sendResponse([], 'Channel deleted successfully.');
    }

    protected function makeWhere(Request $request): string
    {
        $where = '';
        if ($request)
        {
        }
        return $where;
    }
}
