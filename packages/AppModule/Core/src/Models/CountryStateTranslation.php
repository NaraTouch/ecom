<?php

namespace AppModule\Core\Models;

use Illuminate\Database\Eloquent\Model;
use AppModule\Core\Contracts\CountryStateTranslation as CountryStateTranslationContract;

class CountryStateTranslation extends Model implements CountryStateTranslationContract
{
    public $timestamps = false;

    protected $fillable = ['default_name'];
}