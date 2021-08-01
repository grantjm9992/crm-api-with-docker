<?php

namespace App\Http\Controllers\API;

use App\Channel;
use App\Company;
use App\Http\Resources\ChannelResource;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Http\Middleware\ApiToken;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Validator;

class ChannelController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $user = ApiToken::getUserFromRequest($request);
        $channels = Channel::where('company_id', $user->company_id);

        return $this->sendResponse(ChannelResource::collection($channels->get()), 'Channels retrieved successfully.');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $input = $request->all();
        $user = ApiToken::getUserFromRequest($request);
        /** @var Company $company */
        $company = $user->company();
        $input['company_id'] = dd($user);

        $validator = Validator::make($input, [
            'name' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $contactType = Channel::create($input);

        return $this->sendResponse(new ChannelResource($contactType), 'Channel created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id): Response
    {
        $contactType = Channel::find($id);

        if (is_null($contactType)) {
            return $this->sendError('ContactType not found.');
        }

        return $this->sendResponse(new ChannelResource($contactType), 'Channel retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Channel $channel
     * @return Response
     */
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

    /**
     * Remove the specified resource from storage.
     *
     * @param Channel $channel
     * @return Response
     * @throws \Exception
     */
    public function destroy(Channel $channel): Response
    {
        $channel->delete();

        return $this->sendResponse([], 'Channel deleted successfully.');
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return string
     */
    protected function makeWhere(Request $request): string
    {
        $where = '';
        if ($request)
        {
        }
        return $where;
    }
}
