<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use DateTime;
use App\Model\Gene;
use App\Model\Post;
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
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Import implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // dd('aqui');
        $key = SystemKey::where('key', 'like', 'Progress-bar-import')->first();


        if($key == null){
            $key = new SystemKey();
        }

        $key->key = "Progress-bar-import";
        $key->value = "Iniciando...";
        $key->save();


        $reader = new Xlsx();

        $spreadsheet = $reader->load('files/excel/genetic_tests.xlsx');
        $spreadsheet->setActiveSheetIndex(0);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        GeneticTest::truncate();
        Gene::truncate();
        MedicalSpecialty::truncate();

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
                $genes = explode(',', $genes);

                foreach ($genes as $item) {
                    $item = trim($item);
                    $gene = Gene::where('description', $item)->get();
                    if(count($gene) == 0 && \str_replace(' ', '-', $item) == $item){
                        $gene = new Gene();
                        $gene->description = $item;
                        $gene->save();
                    }
                }

                $medical_specialty = explode(';', $test->medical_specialty);
                $medical_specialty = implode(',', $medical_specialty);
                $medical_specialty = explode(',', $medical_specialty);

                foreach ($medical_specialty as $item) {
                    $item = trim($item);
                    $model = MedicalSpecialty::where('description', $item)->get();
                    if(count($model) == 0){
                        $model = new MedicalSpecialty();
                        $model->description = $item;
                        $model->save();
                    }
                }

                $key->value = $i * 100 / count($sheetData);
                $key->save();
            }
        }

        $key->value = count($sheetData) - 1 . ' registros importados com sucesso.';
        $key->save();

        sleep(5);

        $key->value = 'false';
        $key->save();
    }
}
