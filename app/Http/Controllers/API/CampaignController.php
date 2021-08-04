<?php

namespace App\Http\Controllers\API;

use App\Http\Middleware\ApiToken;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Campaigns;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Campaign as CampaignResource;

class CampaignController extends BaseController
{

    public function index(Request $request)
    {
        $campaigns = Campaigns::whereRaw('1 = 1')->get();

        return $this->sendResponse(CampaignResource::collection($campaigns), 'Campaigns retrieved successfully.');
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

        $campaign = Campaigns::create($input);

        return $this->sendResponse(new CampaignResource($campaign), 'Campaign created successfully.');
    }

    public function show(string $id)
    {
        $campaign = Campaigns::find($id);

        if (is_null($campaign)) {
            return $this->sendError('Campaign not found.');
        }

        return $this->sendResponse(new CampaignResource($campaign), 'Campaign retrieved successfully.');
    }

    public function update(Request $request, Campaigns $campaign)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $campaign->update($input);

        return $this->sendResponse(new CampaignResource($campaign), 'Campaign updated successfully.');
    }

    public function destroy(Campaigns $campaign)
    {
        $campaign->delete();

        return $this->sendResponse([], 'Campaign deleted successfully.');
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
