<?php

namespace App\Http\Controllers;
use App\Model\Gene;
use App\Model\GeneticTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class DataImportController extends Controller
{
    //importacao XML
    public function import()
    {
        $reader = new Xlsx();

        $spreadsheet = $reader->load('files/excel/genetic_tests.xlsx');
        $spreadsheet->setActiveSheetIndex(0);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        GeneticTest::truncate();
        Gene::truncate();

        if (!empty($sheetData)) {
            for ($i=1; $i<count($sheetData); $i++) {
                $test                    = new GeneticTest();
                $test->test              = $sheetData[$i][0];
                $test->description       = $sheetData[$i][1];
                $test->note              = $sheetData[$i][2];
                $test->genes             = $sheetData[$i][3];
                $test->code              = $sheetData[$i][4];
                $test->time              = $sheetData[$i][5];
                $test->price             = $sheetData[$i][6];
                $test->forms             = $sheetData[$i][7];
                $test->medical_specialty = $sheetData[$i][8];
                $test->more              = $sheetData[$i][9];
                $test->priority          = $sheetData[$i][10] == 'VERDADEIRO' ? 1 : 0;
                $test->highlight         = $sheetData[$i][11] == 'VERDADEIRO' ? 1 : 0;
                $test->active            = $sheetData[$i][12] == 'VERDADEIRO' ? 1 : 0;
                $test->tuss              = $sheetData[$i][13];

                $test->save();

                $genes = explode(';', $test->genes);
                $genes = implode(',', $genes);
                $genes = explode(',', $test->genes);

                foreach ($genes as $item) {
                    $item = trim($item);
                    $gene = Gene::where('description', $item)->get();
                    if(count($gene) == 0 && \str_replace(' ', '-', $item) == $item){
                        $gene = new Gene();
                        $gene->description = $item;
                        $gene->save();
                    }
                }
            }
        }

        dd('fim');

    }
}
