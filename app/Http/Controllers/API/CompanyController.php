<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Company;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\Company as CompanyResource;

class CompanyController extends BaseController
{
    public function index(Request $request)
    {
        $company = Company::whereRaw('1 = 1')->get();
        // $company->whereRaw($this->makeWhere($request));

        return $this->sendResponse(CompanyResource::collection($company), 'Company retrieved successfully.');
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

        $company = Company::create($input);

        return $this->sendResponse(new CompanyResource($company), 'Company created successfully.');
    }

    public function show(string $id)
    {
        $company = Company::find($id);
        if (is_null($company)) {
            return $this->sendError('Company not found.');
        }

        return $this->sendResponse(new CompanyResource($company), 'Company retrieved successfully.');
    }

    public function update(Request $request, Company $company)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $company->update($input);

        return $this->sendResponse(new CompanyResource($company), 'Company updated successfully.');
    }

    public function destroy(Company $company)
    {
        $company->delete();

        return $this->sendResponse([], 'Company deleted successfully.');
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
