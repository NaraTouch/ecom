<?php

namespace AppModule\Core\Models;

use Illuminate\Database\Eloquent\Model;
use AppModule\Core\Contracts\ChannelTranslation as ChannelTranslationContract;

class ChannelTranslation extends Model implements ChannelTranslationContract
{
    protected $guarded = [];
}