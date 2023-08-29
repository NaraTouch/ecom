<?php

namespace AppModule\Marketing\Models;

use Illuminate\Database\Eloquent\Model;
use AppModule\Product\Models\ProductProxy;
use AppModule\Marketing\Contracts\Event as EventContract;

class Event extends Model implements EventContract
{
    protected $table = 'marketing_events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'date',
    ];
}