<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class GeneticTest extends Model
{
    protected $table = 'genetic_tests';
    protected $guarded = [];
    protected $dates = ['created_at', 'updated_at'];
    public $timestamps = true;

    public function link(){
        $return = route('teste', ['code' => str_slug($this->id)]);
        return $return;
    }

}
