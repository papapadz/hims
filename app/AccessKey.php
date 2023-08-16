<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccessKey extends Model
{
    protected $fillable = [
        'facility_id','public','serverURL'
    ];

    protected $hidden = [
        'public','serverURL'
    ];
}
