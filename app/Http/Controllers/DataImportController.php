<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataImportController extends Controller
{
    //importacao XML
    public function import()
    {
        set_time_limit(0);

        //acerto
        $ids = DB::table('posts')->orderBy('id')->get();
        dd($ids);
        for($i = 0; $i < count($ids); $i++){
            $new_id = $i+1;
            DB::table('sessions')->where('ids', 'like' , "%\"" . $ids[$i]->id . "\"%")->update(['ids' => DB::raw( 'replace(ids, \'"' . $ids[$i]->id . '"\', \'"' . $new_id . '"\')' )]);
            DB::table('posts')->where('id', '=', $ids[$i]->id)->update(['id' => $new_id]);
        }

    }
}
