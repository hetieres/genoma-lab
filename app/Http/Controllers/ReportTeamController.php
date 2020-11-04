<?php

namespace App\Http\Controllers;

use App\Model\News;
use App\Model\Country;
use App\Model\Vehicle;
use App\Model\Category;
use App\Model\MediaType;
use App\Model\NewsStatus;
use App\Model\CitationType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReportTeamController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.teamReport', $this->data);
    }

    public function report(Request $request)
    {
        $reports                       = [];
        $reports['news_by_member']     = $this->newsByMember($request);
        $reports['vehicles_by_member'] = $this->vehiclesByMember($request);
        $reports['news_balance']       = $this->newsBalance($request);

        return \Response::json($reports);
    }

    public function newsByMember(Request $request)
    {
        $format = '';
        $order  = '';
        switch ($request->group) {
            case '0':
                $format = '%d/%m/%Y';
                $order  = '%Y-%m-%d';
                break;
            case '1':
                $format = '%m/%Y';
                $order  = '%Y-%m';
                break;
            case '2':
                $format = '%Y';
                $order  = '%Y';
                break;
        }
        $rs = News::selectRaw('DATE_FORMAT(created_at, \'' . $format . '\') as date,
                                SUM(IF(user_id = 2, 1, 0)) as jussara,
                                SUM(IF(user_id = 10, 1, 0)) as monica_luri,
                                SUM(IF(user_id = 13, 1, 0)) as monica_lopes,
                                SUM(IF(user_id = 18, 1, 0)) as sheyla,
                                SUM(IF(user_id is null , 1, 0)) as system,
                                SUM(1) as total');
        $rs->where('news_status_id', '<>', 12);
        if(isset($request->daterange) && $request->daterange != ''){
            $aux = explode(',', $request->daterange);
            $rs->where('created_at', '>=', $aux[0]);
            $rs->where('created_at', '<=', $aux[1]);
        }else{
            $rs->whereRaw('created_at >= DATE_FORMAT(now(), \'%Y-01-01\')');
            $rs->whereRaw('created_at <= DATE_FORMAT(now(), \'%Y-12-31\')');
        }
        $rs->groupBy(DB::raw('DATE_FORMAT(created_at, \'' . $format . '\')'));
        $rs->orderByRaw('DATE_FORMAT(created_at, \'' . $order . '\') ' . $request->order);
        $rs = $rs->get();

        return $rs;
    }

    public function vehiclesByMember(Request $request)
    {
        $format = '';
        $order  = '';
        switch ($request->group) {
            case '0':
                $format = '%d/%m/%Y';
                $order  = '%Y-%m-%d';
                break;
            case '1':
                $format = '%m/%Y';
                $order  = '%Y-%m';
                break;
            case '2':
                $format = '%Y';
                $order  = '%Y';
                break;
        }
        $rs = Vehicle::selectRaw('DATE_FORMAT(created_at, \'' . $format . '\') as date,
                                SUM(1) as total,
                                SUM(IF(status_vehicle_id <> 2, 1, 0)) as total_indexed,
                                SUM(IF(status_vehicle_id <> 2 and user_id = 2, 1, 0)) as jussara,
                                SUM(IF(status_vehicle_id <> 2 and user_id = 10, 1, 0)) as monica_luri,
                                SUM(IF(status_vehicle_id <> 2 and user_id = 13, 1, 0)) as monica_lopes,
                                SUM(IF(status_vehicle_id <> 2 and user_id = 18, 1, 0)) as sheyla,
                                SUM(IF(status_vehicle_id <> 2 and user_id is null , 1, 0)) as system');
        $rs->where('status_vehicle_id', '<>', 2);
        if(isset($request->daterange) && $request->daterange != ''){
            $aux = explode(',', $request->daterange);
            $rs->where('created_at', '>=', $aux[0]);
            $rs->where('created_at', '<=', $aux[1]);
        }else{
            $rs->whereRaw('created_at >= DATE_FORMAT(now(), \'%Y-01-01\')');
            $rs->whereRaw('created_at <= DATE_FORMAT(now(), \'%Y-12-31\')');
        }
        $rs->groupBy(DB::raw('DATE_FORMAT(created_at, \'' . $format . '\')'));
        $rs->orderByRaw('DATE_FORMAT(created_at, \'' . $order . '\') ' . $request->order);
        $rs = $rs->get();

        return $rs;
    }

    public function newsBalance(Request $request)
    {
        $format = '';
        $order  = '';
        switch ($request->group) {
            case '0':
                $format = '%d/%m/%Y';
                $order  = '%Y-%m-%d';
                break;
            case '1':
                $format = '%m/%Y';
                $order  = '%Y-%m';
                break;
            case '2':
                $format = '%Y';
                $order  = '%Y';
                break;
        }

        $rs = DB::table('view_count_news');
        $rs->selectRaw('DATE_FORMAT(view_count_news.date, \'' . $format . '\') as date,
                        SUM(view_count_news.totalmanual) as total_manual,
                        SUM(view_count_news.totalclipping) as total_clipping,
                        SUM(view_count_news.indexed) as indexed,
                        SUM(view_count_news.noindex) as no_indexed,
                        SUM(if(view_count_urls.urltotal is null, 0, view_count_urls.urltotal)) as url_total,
                        SUM(if(view_count_urls.urlindexed is null, 0, view_count_urls.urlindexed)) as url_indexed');
        $rs->leftJoin('view_count_urls', 'view_count_news.date', '=', 'view_count_urls.date');
        if(isset($request->daterange) && $request->daterange != ''){
            $aux = explode(',', $request->daterange);
            $rs->where('view_count_news.date', '>=', $aux[0]);
            $rs->where('view_count_news.date', '<=', $aux[1]);
        }else{
            $rs->whereRaw('view_count_news.date >= DATE_FORMAT(now(), \'%Y-01-01\')');
            $rs->whereRaw('view_count_news.date <= DATE_FORMAT(now(), \'%Y-12-31\')');
        }
        $rs->groupBy(DB::raw('DATE_FORMAT(view_count_news.date, \'' . $format . '\')'));
        $rs->orderByRaw('DATE_FORMAT(view_count_news.date, \'' . $order . '\') ' . $request->order);
        $rs = $rs->get();

        return $rs;
    }

    public function download(Request $request)
    {
        switch ($request->report) {
            case 1:
                $rs   = $this->newsByMember($request);
                $file = 'Materias_editadas_X_equipe';
                break;
            case 2:
                $rs   = $this->newsBalance($request);
                $file = 'Balanco_de_materias';
                break;
            case 3:
                $rs   = $this->vehiclesByMember($request);
                $file = 'Veiculos_X_equipe';
                break;
        }

        $this->data['rs'] = $rs;
        $this->data['report'] = $request->report;

        header('Content-type: application/excel');
        header('Content-Disposition: attachment; filename=' . $file . '.xls');
        header("Pragma: ");
        header("Cache-Control: ");

         return view('admin.teamReportList', $this->data);

    }

}
