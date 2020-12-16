<?php

namespace App\Http\Controllers;

use App\Model\Url;
use App\Model\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class ApiController extends Controller
{
    public function bv(Request $request)
    {
        $rs = News::query();
        $rs->selectRaw('news.id, news.title, news.number_process, news.dt_publication, news.created_at, news.updated_at, vehicles.country_id as international');
        $rs->join('vehicles', 'news.vehicle_id', 'vehicles.id');

        if (isset($request->date)) {
            $rs->where('news.updated_at', '>=', $request->date);
        } else if (isset($request->id)) {
            $rs->where('news.id', '>=', $request->id);
        }

        $data   = $rs->where('news.number_process', '<>', '')->get();
        $return = [];
        if ($data->count()>0) {
            foreach ($data as $item) {
                $object      = (object) array('id' => $item->id, 'title' => $item->title, 'dt_publication' => $item->dt_publication->format('Y-m-d'), 'created_at' => $item->created_at->format('Y-m-d  H:i:s'), 'updated_at' => $item->updated_at->format('Y-m-d  H:i:s'));
                $object->url = route('detalhe', ['title' => str_slug($item->title), 'id' => $item->id]);
                $process     = json_decode($item->number_process);
                $process     = (is_array($process) ? $process: [$process]);

                for ($i = 0; $i < count($process); $i++) {
                    if (strlen($process[$i]) == 8) {
                        $process[$i] = '20' . $process[$i];
                    }
                }

                $object->number_process = $process;
                $object->international  = $item->international ? false : true;
                $return[] = $object;
            }
        }

        return $return;
    }

    public function bv2(Request $request)
    {
        $rs = News::query();
        $rs->selectRaw('news.id, vehicles.description as vehicle, news.title, news.number_process, news.dt_publication, news.created_at, news.updated_at, vehicles.country_id as international');
        $rs->join('vehicles', 'news.vehicle_id', 'vehicles.id');
        $rs->whereIn('news.news_status_id', News::statusActive());

        if (isset($request->date)) {
            $rs->where('news.updated_at', '>=', $request->date . ' 00:00:00');
        } else {
            $rs->where('news.number_process', '<>', '');
        }

        if (isset($request->id)) {
            $rs->where('news.id', '>=', $request->id);
        }

        $data   = $rs->get();
        $return = [];
        if ($data->count()>0) {
            foreach ($data as $item) {
                $object      = (object) array('id' => $item->id, 'vehicle' => $item->vehicle, 'title' => $item->title, 'dt_publication' => $item->dt_publication->format('Y-m-d'), 'created_at' => $item->created_at->format('Y-m-d  H:i:s'), 'updated_at' => $item->updated_at->format('Y-m-d  H:i:s'));
                $object->url = route('detalhe', ['title' => str_slug($item->title), 'id' => $item->id]);
                $process     = json_decode($item->number_process);
                $process     = (is_array($process) ? $process: [$process]);

                for ($i = 0; $i < count($process); $i++) {
                    if (strlen($process[$i]) == 8) {
                        $process[$i] = '20' . $process[$i];
                    }
                }

                $object->number_process = $process;
                $object->international  = $item->international == 1 ? false : true;
                $return[] = $object;
            }
        }

        return $return;
    }

    public function clippingService(Request $request)
    {
        $rs = Url::query();
        $rs->selectRaw('url');
        $rs->whereIn('url_type_id', [1, 3]);
        $rs->where('register', 0);
        if (isset($request->date)) {
            $rs->where('created_at', '>=', $request->date . ' 00:00:00');
        }
        $rs = $rs->get();
        $url = [];
        foreach ($rs as $item) {
            $url[] = $item->url;
        }
        return $url;
    }

}
