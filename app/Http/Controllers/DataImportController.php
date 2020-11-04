<?php
namespace App\Http\Controllers;

use App\Model\Tag;
use App\Model\Url;
use Carbon\Carbon;
use App\Model\News;
use App\Model\NewsTag;
use App\Model\Vehicle;
use App\Model\MediaType;
use App\Model\DataImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DataImportController extends Controller
{
    //importacao XML
    public function import()
    {
        ini_set('max_execution_time', 0);
        set_time_limit(0);

        $date   = Carbon::now()->format('Y-m-d');

        $importLast = DataImport::orderBy('news_import_id', 'DESC')->first();
        // if(Carbon::now()->format('H') == '23')
        // {
        //     $importLast->news_import_id = 1;
        //     $link = "http://clipping.cservice.com.br/ServiceCliente/FAPESPService.asmx/Materias?DataCadastro=" . $date . "&MaxId=" . $importLast->news_import_id; //link do arquivo xml
        // }else{
        //     $link   = "http://clipping.cservice.com.br/servicecliente/FAPESPService.asmx/ListarMaterias?DataCadastro=" . $date . "&MaxDataEnvio=" . $importLast->created_at->format("Y-m-d%20H:i:s");
        //     //$link   = "http://clipping.cservice.com.br/servicecliente/FAPESPService.asmx/ListarMaterias?DataCadastro=" . $date . "&MaxDataEnvio=2019-08-31%2023:59:59";
        // }

        $link   = "http://clipping.cservice.com.br/servicecliente/FAPESPService.asmx/ListarMaterias?DataCadastro=" . $date . "&MaxDataEnvio=" . $importLast->send_at->format("Y-m-d%20H:i:s");

        $xmlLog = @file_get_contents($link);
        $xml    = simplexml_load_string($xmlLog);
        $log    = $this->_public_path . "/logs/" . Carbon::now()->format('Y-m-d_H-i-s') . '.xml';

        if (getType($xml)==='object' && isset($xml->item) && count($xml->item) > 0) {
            Storage::put($log, $xmlLog);
            foreach($xml->item as $item) {
                //noticia
                $news                     = new News();

                $news->author             = trim($item->nmAutor);
                $news->text               = trim($item->dsTexto);
                $news->title              = trim($item->dsTitulo);
                $news->dt_publication     = trim($item->dtNoticia);
                $news->lang_id            = 1;
                $news->news_status_id     = 12;
                $news->url                = str_replace('http://https://', 'http://', $item->dsUrl);
                $news->publishing         = $item->nmSecao != '-' && strtolower(trim($item->nmSecao)) != 'home' ? trim($item->nmSecao) : '';
                $news->pages              = $item->pagina  != '-' && $item->pagina  != 'home' ? trim($item->pagina)  : '';

                $deliter = $news->dt_publication->format('d/m/Y');
                $text = explode($deliter, $news->text);
                if(
                    count($text) > 1 &&
                    strlen($text[0]) > 0 &&
                    strlen($text[0]) < 170 &&
                    strlen($text[1]) > strlen($text[0])
                    )
                    {
                    $news->text = trim($text[1]);
                }

                $news->text = str_replace("\r", "\n", $news->text);
                $news->text = str_replace("\n\n", "\n", $news->text);
                $news->text = str_replace("\n\n", "\n", $news->text);
                $news->text = str_replace("\n\n", "\n", $news->text);

                $news->text = str_replace("\n", "</p><p>", $news->text);

                //midia
                $mediaType           = MediaType::where('description', $item->midia)->limit(1)->get();

                $news->media_type_id = $mediaType[0]->id;

                //veiculo
                $vehicle = Vehicle::where('import_id', 'like', 'CSERVICE ' . $item->cdVeiculo)->limit(1)->get();

                //veiculo por URL
                $url                 = explode('/', $news->url);
                if(count($vehicle) == 0 && isset($url[2]) && $url[2] != 'clipping.cservice.com.br')
                {
                    $url             = '%//' . $url[2] . '%';
                    $vehicle         = Vehicle::where('url', 'like', $url)->where('media_type_id', '=', $news->media_type_id)->orderBy('id', 'DESC')->limit(1)->get();
                }

                //veiculo por nome
                if(count($vehicle) == 0)
                {
                    $vehicle = Vehicle::where('description', 'like', $item->nmVeiculo)->where('media_type_id', '=', $news->media_type_id)->limit(1)->get();
                }

                //insert veiculo
                if(count($vehicle) == 0)
                {
                    $vehicle                    = new Vehicle();
                    $vehicle->description       = $item->nmVeiculo;
                    $vehicle->import_id         = 'CSERVICE ' . $item->cdVeiculo;
                    $vehicle->media_type_id     = $news->media_type_id;
                    $vehicle->status_vehicle_id = 2;
                    $vehicle->url               = '';
                    $url                        = explode('/', $news->url);
                    if(isset($url[2])  && $url[2] != 'clipping.cservice.com.br')
                    {
                        $url                    = $url[0] . '//' . $url[2];
                        $vehicle->url           = $url;
                    }
                    $vehicle->save();
                }
                else
                {
                    $vehicle = $vehicle[0];
                }

                //veiculo unificado
                while(is_int($vehicle->unify_id) && $vehicle->unify_id > 0)
                {
                    $vehicle = Vehicle::findOrFail($vehicle->unify_id);
                }

                $news->vehicle_id = $vehicle->id;

                //iguala tipo de midia
                $news->media_type_id = $vehicle->media_type_id;

                //acompanhamento de url
                $url    = explode('//', $news->url);
                $url    = isset($url[1]) ? '%' . trim($url[1]): $url[0];
                if(Url::where('url', 'like', $url)->count())
                {
                    $model = Url::where('url', 'like', $url)->first();
                    $model->register = '1';
                    $model->save();
                }

                //verifica duplicidade
                //por registro de importacao
                $count = DataImport::where('news_import_id', $item->cdNoticia)->count();
                //por URL
                $count += News::where('url', 'like', $url)->where('vehicle_id', $news->vehicle_id)->count();
                //por title e vehicle
                $count += News::where('title', 'like', $news->title)->where('vehicle_id', $news->vehicle_id)->count();

                if($count == 0)
                {
                    //noticia insert
                    $save = $news->save();

                    //registro importacao insert
                    $import = new DataImport();

                    $import->news_id         = $news->id;
                    $import->news_import_id  = $item->cdNoticia;
                    $import->url             = $link;
                    $import->send_at         = trim($item->dtEnvio) . ':00';

                    $impSave = $import->save();

                    /* //vincula tags
                    $tags = Tag::all();

                    foreach ($tags as $tag) {//tag a tag
                        $keys = $tag->keys;
                        $keys = explode(',', $keys);//chave a chave
                        foreach ($keys as $key) {
                            $key1 = trim($key) . ' ';
                            $key2 = trim($key) . '.';
                            if((strpos($news->text, $key1) || strpos($news->text, $key2)) && $key1 != ' ' && $key2 != '.')
                            {
                                $newsTag = new NewsTag();
                                $newsTag->news_id = $news->id;
                                $newsTag->tag_id = $tag->id;
                                $newsTag->save();
                                break;
                            }
                        }
                    } */
                }
            }
        }

        //acerta veiculos Brasil
        Vehicle::whereNull('country_id')->where('url', 'like', '%.br%')->update(['country_id' => 1]);

        //exclui materias duplicadas
        $repeat = DB::table('view_news_repeat')->get();

        foreach ($repeat as $item) {
            $ids = explode(',', $item->ids);
            for($i = 1; $i < count($ids); $i++)
            {
                News::where('id', $ids[$i])->delete();
            }
        }
    }
}