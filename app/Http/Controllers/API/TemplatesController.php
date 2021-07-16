<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Validator;

use PhpOffice\PhpWord\TemplateProcessor;
   
class TemplatesController extends BaseController
{
    public function get(Request $request)
    {
        $templates = \App\Templates::get();
        return $this->sendResponse($templates, 'Found');
    }

    public function fill(Request $request)
    {
        $template = \App\Templates::find($request->templateId);
        if (!$template) return false;
        $contact = \App\Contacts::find($request->customerId);
        if (!$contact) return false;

        $templateProcessor = new TemplateProcessor($template->path);
        foreach ($contact as $key => $value) {
            $templateProcessor->setValue($key, $value);
        }

    }

    public function send(Request $request)
    {
    }

    public function getTemplate(Request $request, $id)
    {
        $template = \App\Templates::find($id);
        if (!$template) return $this->sendError('Template not found');
        if (!file_exists(base_path() . '/uploads/templates/' . $template->path)) return $this->sendError('Template not found in directory ' . base_path() . '/uploads/templates/' . $template->path);
        
        $contactId = $request->contactId;
        $contact = \App\Contacts::find($contactId);
        $templateProcessor = new TemplateProcessor(base_path() . '/uploads/templates/' . $template->path);
        $templateProcessor->setValue('name', $contact->name);
        $templateProcessor->setValue('surname', $contact->surname);
        $pathToSave = base_path() . '/uploads/templates/test_' . uniqid() . '.docx';
        $templateProcessor->saveAs($pathToSave);

        $phpWord = \PhpOffice\PhpWord\IOFactory::load($pathToSave);
        $htmlWriter = new \PhpOffice\PhpWord\Writer\HTML($phpWord);

        $path = '/test.html';
        \Illuminate\Support\Facades\File::put(public_path() . $path, $htmlWriter->getContent());

        \unlink($pathToSave);

        return $this->sendResponse(url($path), 'Success');

    }
    
}