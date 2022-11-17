<?php

namespace App\Jobs;

use DateTime;
use App\Model\Gene;
use App\Model\Post;
use App\Model\Session;
use App\Model\SystemKey;

use App\Model\GeneticTest;
use App\Model\PostHistory;
use Caxy\HtmlDiff\HtmlDiff;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Carbon;
use App\Model\MedicalSpecialty;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Queue\InteractsWithQueue;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class Import implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    // use SerializesModels;

    public $timeout = 0;

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
        Log::debug('exec job');
        $key = SystemKey::where('key', 'like', 'Progress-bar-import')->first();


        if($key == null){
            $key = new SystemKey();
        }

        $key->key = "Progress-bar-import";
        $key->value = "0%";
        $key->save();


        $reader = new Xlsx();
        // Log::debug(public_path('/files/excel/genetic_tests.xlsx'));
        // die();

        $spreadsheet = $reader->load(public_path('files/excel/genetic_tests.xlsx'));
        $spreadsheet->setActiveSheetIndex(0);
        $sheetData = $spreadsheet->getActiveSheet()->toArray();

        // GeneticTest::truncate();
        // Gene::truncate();
        // MedicalSpecialty::truncate();

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
                $test->active            = $sheetData[$i][12] == 'VERDADEIRO' ? 0 : 1;
                $test->tuss              = $sheetData[$i][13];

                if($test->price[strlen($test->price)-3] == '.'){
                    $test->price = str_replace('.', 'X', $test->price);
                    $test->price = str_replace(',', '.', $test->price);
                    $test->price = str_replace('X', ',', $test->price);
                }

                $test->genes = explode(';', $test->genes);
                $test->genes = implode(',', $test->genes);

                $test->save();

                $genes = explode(',', $test->genes);

                foreach ($genes as $item) {
                    $item = trim($item);
                    $gene = Gene::where('description', $item)->get();
                    if(count($gene) <= 1 && \str_replace(' ', '-', $item) == $item){
                        $gene = new Gene();
                        $gene->description = $item;
                        $gene->active      = 0;
                        $gene->save();
                    }
                }

                $medical_specialty = explode(';', $test->medical_specialty);
                $medical_specialty = implode(',', $medical_specialty);
                $medical_specialty = explode(',', $medical_specialty);

                foreach ($medical_specialty as $item) {
                    $item = trim($item);
                    $model = MedicalSpecialty::where('description', $item)->get();
                    if(count($model) <= 1){
                        $model = new MedicalSpecialty();
                        $model->description = $item;
                        $model->active      = 0;
                        $model->save();
                    }
                }

                $key->value = 'Excel <br>' . floor($i * 100 / count($sheetData)) . '%';
                $key->save();

            }
        }


        $key->value = 'false';
        $key->save();

        MedicalSpecialty::where('active', 1)->delete();
        MedicalSpecialty::where('active', 0)->update(['active' => 1]);
        $rs = MedicalSpecialty::orderBy('id')->get();

        for ($i=0; $i < count($rs); $i++) {
            MedicalSpecialty::where('id', $rs[$i]->id)->update(['id' => $i+1]);
            $key->value = 'Especialidade medica <br>' . floor($i * 100 / count($rs)) . '%';
            $key->save();
        }

        Gene::where('active', 1)->delete();
        Gene::where('active', 0)->update(['active' => 1]);
        $rs = Gene::orderBy('id')->get();

        for ($i=0; $i < count($rs); $i++) {
            Gene::where('id', $rs[$i]->id)->update(['id' => $i+1]);
            $key->value = 'Genes <br>' . floor($i * 100 / count($rs)) . '%';
            $key->save();
        }

        GeneticTest::where('active', 1)->delete();
        GeneticTest::where('active', 0)->update(['active' => 1]);
        $rs = GeneticTest::orderBy('id')->get();

        for ($i=0; $i < count($rs); $i++) {
            GeneticTest::where('id', $rs[$i]->id)->update(['id' => $i+1]);
            $key->value = 'Exames <br>' . floor($i * 100 / count($rs)) . '%';
            $key->save();
        }

        $key->value = 'false';
        $key->save();

    }
}
