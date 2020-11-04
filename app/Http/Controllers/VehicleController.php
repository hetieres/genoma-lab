<?php

namespace App\Http\Controllers;

use App\Model\News;
use App\Model\Country;
use App\Model\Vehicle;
use App\Model\MediaType;
use App\Model\StatusVehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    //
    public function index()
    {
        return view('admin.vehicleList', $this->data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createUpdate(Request $request)
    {
        if($request->input('id') > 0)
        {
            $vehicle = Vehicle::findOrFail($request->input('id'));
        }else{
            $vehicle = new Vehicle();
        }

        $vehicle->description       = $request->input('description');
        $vehicle->country_id        = $request->input('country_id');
        $vehicle->user_id           = $request->input('user_id');
        $vehicle->status_vehicle_id = $request->input('status_vehicle_id');
        $vehicle->state             = $request->input('state');
        $vehicle->city              = $request->input('city');
        $vehicle->url               = $request->input('url');
        $vehicle->unify_id          = $request->input('unify_id');
        $vehicle->media_type_id     = $request->input('media_type_id');
        $vehicle->big               = $request->input('big') == 'true' ? 1 : 0;
        $vehicle->limited_access    = $request->input('limited_access') == 'true' ? 1 : 0;

        $vehicle->save();
        //padroniza tipo de midia na noticia pelo veiculo
        News::where('vehicle_id', '=' , $vehicle->id)->update(['media_type_id' => $vehicle->media_type_id]);

        if($vehicle->id != $vehicle->unify_id && $vehicle->unify_id > 0){
            Vehicle::where('id', $vehicle->id)->update(['unify_id' => $vehicle->unify_id, 'status_vehicle_id' => 3]);
            News::where('vehicle_id', $vehicle->id)->update(['vehicle_id' => $vehicle->unify_id]);
        }

        return $vehicle;

    }

    public function list(Request $request)
    {
        $rs = Vehicle::query();

        if(isset($request->status_vehicle_id) && $request->status_vehicle_id > 0)
            $rs->where('status_vehicle_id', $request->status_vehicle_id);
        else
            $request->status_vehicle_id = 0;

        if(isset($request->country_id) && $request->country_id > 0)
            $rs->where('country_id', $request->country_id);
        else if(!isset($request->country_id))
            $request->country_id = 0;

        if(isset($request->media_type_id) && $request->media_type_id > 0)
            $rs->where('media_type_id', $request->media_type_id);
        else if(!isset($request->media_type_id))
            $request->media_type_id = 0;

        if($request->country_id == 'outside')
            $rs->where('country_id', '<>' , 1);

        if(isset($request->key) && $request->key != '')
        {
            if((int) $request->key > 0)
            {
                $rs->where('id', $request->key);
            }
            else if(filter_var($request->key, FILTER_VALIDATE_URL))
            {
                $url = explode('//', $request->key);
                $url = isset($url[1]) ? '%' . trim($url[1]) . '%' : $url[0];
                $rs->where('url', 'like', $url);
            }
            else
            {
                $like = '%' . $request->key . '%';
                $rs->where('description', 'like', $like)->orWhere('city', 'like', $like);
            }
        }
        else
            $request->key = '';

        $rs = $rs->orderBy('description')->paginate(25);

        foreach ($rs as $item)
        {
            $country         = $item->country;
            $item->status    = $item->status;
            $item->mediaType = $item->mediaType;
            //$item->description .= ' (' . $item->news->count() . ' Notícias)';

            $item->id     = str_pad($item->id, 5, "0", STR_PAD_LEFT);

            //local de origem do veiculo
            $from = '';

            if(isset($country)){
                if($country->id == 1)
                    $from = $country->description . ' | ' . $item->state . " | " . $item->city;
                else
                    $from = $country->description;
            }
            $item->from = $from;

            //url
            if($item->url == ''){
                $url  = "";
                $news = News::where('vehicle_id', '=', $item->id)->limit(1)->get();
                if(isset($news[0]) && $news[0]->url){
                    $url = $news[0]->url;
                    $aux = explode('/', $url);
                    if(isset($aux[2]) && $aux[2] != 'clipping.cservice.com.br')
                    {
                        $url = $aux[0] . '//' . $aux[2];
                    }
                }
                $item->url = $url;
            }

            //unificado
            if($item->unify_id > 0 && Vehicle::where('id', $item->unify_id)->count() > 0){
                $item->unify = Vehicle::findOrFail($item->unify_id);
            }else{
                $item->unify_id = null;
            }
        }

        $lastPage             = $rs->lastPage();
        $currentPage          = $rs->currentPage();

        $return               = array();
        $return['rs']         = $rs;
        $return['rangePages'] = $this->rangePages($lastPage, $currentPage);
        $return['rangePages'] = (object) $return['rangePages'];
        $return               = (object) $return;

        return json_encode($return);
    }


    public function edit(Request $request)
    {
        if(isset($request->id))
        {
            $vehicle = Vehicle::find($request->id);
        }else{
            $vehicle = new Vehicle();
        }

        $vehicle->news_total = $vehicle->news()->whereIn('news_status_id', News::statusActive())->count();


        $this->data['vehicle']     = $vehicle;
        $this->data['user_id']     = Auth::user()->id;
        $this->data['countries']   = Country::orderBy('description')->get();
        $this->data['medias']      = MediaType::orderBy('description')->get();
        $this->data['status']      = StatusVehicle::orderBy('id')->get();
        $this->data['vehicles']    = Vehicle::selectRaw('vehicles.*, (select count(*) from news where vehicle_id = vehicles.id) total, media_types.description as media')
                                        ->join('media_types', 'vehicles.media_type_id', '=', 'media_types.id')
                                        ->whereIn('vehicles.status_vehicle_id', array(1, 2))
                                        ->orderBy('vehicles.description')
                                        ->groupBy('vehicles.id')
                                        ->get();
        $this->data['states']     = Vehicle::selectRaw('DISTINCT state')
                                        ->where('state', '<>', '')
                                        ->groupBy('state')
                                        ->get();
        return view('admin.vehicleEdit', $this->data);
    }


    public function multipleEdit(Request $request)
    {
        $ids = explode('-', $request->ids);

        $vehicles = Vehicle::whereIn('id', $ids)->orderBy('description')->get();

        //from
        foreach ($vehicles as $item)
        {
            $country      = $item->country;
            $item->status = $item->status;

            $from = '';

            if(isset($country)){
                if($country->id == 1)
                    $from = $country->description . ' | ' . $item->state . " | " . $item->city;
                else
                    $from = $country->description;
            }
            //local de origem do veiculo
            $item->from = $from;
        }

        $this->data['ids']           = $request->ids;
        $this->data['vehicles']      = $vehicles;
        $this->data['cb_vehicles']   = Vehicle::selectRaw('vehicles.*, (select count(*) from news where vehicle_id = vehicles.id) total, media_types.description as media')
                                        ->join('media_types', 'vehicles.media_type_id', '=', 'media_types.id')
                                        ->whereIn('vehicles.status_vehicle_id', array(1, 2))
                                        ->orderBy('vehicles.description')
                                        ->groupBy('vehicles.id')
                                        ->get()
                                        ->toArray();
        $this->data['countries']     = Country::orderBy('description')->get();
        $this->data['status']        = StatusVehicle::orderBy('id')->get();
        $this->data['user_id']       = Auth::user()->id;

        return view('admin.vehicleEditMultiple', $this->data);
    }

    public function multipleSave(Request $request)
    {
        $ids = explode('-', $request->input('ids'));

        $vehicles = Vehicle::whereIn('id', $ids)->orderBy('description')->get();

        foreach ($vehicles as $vehicle) {
            $vehicle->unify_id          = $request->input('unify_id');
            $vehicle->status_vehicle_id = 3;
            $vehicle->user_id           = $request->input('user_id');
            if($vehicle->id != $vehicle->unify_id && $request->input('unify_id') > 0){
                $vehicle->save();
                Vehicle::where('unify_id', $vehicle->id)->update(['unify_id' => $vehicle->unify_id, 'status_vehicle_id' => 3]);
            }
        }

        //update news
        News::whereIn('vehicle_id', $ids)->update(['vehicle_id' => $request->input('unify_id')]);

        return $vehicles;
    }

    public function allComboBox()
    {

        $status     = StatusVehicle::all();
        $country    = Country::orderBy('description')->get();
        $mediaTypes = MediaType::orderBy('description')->get();

        $return               = array();
        $return['status']     = $status;
        $return['countries']  = $country;
        $return['mediaTypes'] = $mediaTypes;
        $return               = (object) $return;

        return \Response::json($return);

    }

}
