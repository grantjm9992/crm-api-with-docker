<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;

use PhpOffice\PhpWord\TemplateProcessor;
   
class DocumentsController extends BaseController
{
    public function get(Request $request)
    {
        $documents = \App\Documents::get();
        return $this->sendResponse($documents, 'Found');
    }
    
}