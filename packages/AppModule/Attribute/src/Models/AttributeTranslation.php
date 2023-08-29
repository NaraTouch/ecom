<?php

namespace AppModule\Attribute\Models;

use Illuminate\Database\Eloquent\Model;
use AppModule\Attribute\Contracts\AttributeTranslation as AttributeTranslationContract;

class AttributeTranslation extends Model implements AttributeTranslationContract
{
    public $timestamps = false;

    protected $fillable = ['name'];
}