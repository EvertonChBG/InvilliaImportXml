<?php

namespace App\Http\Controllers;

use App\Repositories\ImportXmlRepository;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class ImportXmlController extends Controller
{

    public function import(Request $oRequest)
    {
        $oRequest->validate([
            'file' => 'required|mimes:application/xml,xml|max:10000',
        ]);

        $oFile = new File($oRequest->file('file'));

        $oImportFile = new ImportXmlRepository();
        $oImportFile->setFile($oFile);

        if ($oImportFile->upload() && !$oRequest->async) {
            $oImportFile->processFile();
        }

        $oNewImportation = [
            'file_name' => $oImportFile->getImport()->file_path,
            'size' => $oImportFile->getImport()->size
        ];

        $sMessageSuccess = '';

        if (!$oErrors = Session::get('errors')) {
            $sMessageSuccess = 'Successfully Processed!';
        }

        return Redirect::route('import', ['aImport' => $oNewImportation])
            ->with('success', $sMessageSuccess);
    }

}
