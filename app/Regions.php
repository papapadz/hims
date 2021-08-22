<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Regions extends Model
{
    protected $table = 'tbl_region';

    public function provinces() {
        return $this->hasMany(Provinces::class,'regCode');
    }
}
