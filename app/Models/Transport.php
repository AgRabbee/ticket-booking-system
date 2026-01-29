<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    public function companies()
    {
        return $this->belongsToMany("App\Models\Company")->withPivot('total_seats','registration_no');
    }

    public function transport()
    {
        return $this->belongsTo("App/Models/CompanyTransport");
    }
}
