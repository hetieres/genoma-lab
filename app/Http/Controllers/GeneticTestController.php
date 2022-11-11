<?php

namespace App\Http\Controllers;

use DateTime;
use App\Model\Gene;
use App\Model\Post;
use App\Jobs\Import;
use App\Model\Session;
use App\Model\SystemKey;
use App\Model\GeneticTest;
use App\Model\PostHistory;
use Caxy\HtmlDiff\HtmlDiff;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Model\MedicalSpecialty;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class GeneticTestController extends Controller
{
    //
    public function index()
    {
        return view('admin.importTests', $this->data);
    }

    //
    public function import(Request $request)
    {
        if($request->hasFile('file')){
            $file = $request->file('file');
            $fileInfo = pathinfo($file->getClientOriginalName());
            // $fileInfo['name'] = str_slug($fileInfo['filename']) . '.' . str_slug($fileInfo['extension']);
            $fileInfo['name'] = 'genetic_tests.xlsx';
            $upload = $file->storeAs($this->_public_path . '/excel', $fileInfo['name']);

            $excel = Storage::disk('local')->getAdapter()->getPathPrefix() . $upload;

            Import::dispatch();

            return \Response::json('Iniciando');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function statusBar(){
        return SystemKey::where('key', 'like', 'Progress-bar-import')->first();
    }





}
