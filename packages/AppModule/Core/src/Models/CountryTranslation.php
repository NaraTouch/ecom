<?php

namespace AppModule\Core\Models;

use Illuminate\Database\Eloquent\Model;
use AppModule\Core\Contracts\CountryTranslation as CountryTranslationContract;

class CountryTranslation extends Model implements CountryTranslationContract
{
    public $timestamps = false;

    protected $fillable = ['name'];
}