<?php

namespace AppModule\BookingProduct\Models;

use Illuminate\Database\Eloquent\Model;
use AppModule\BookingProduct\Contracts\BookingProductEventTicketTranslation as BookingProductEventTicketTranslationContract;

class BookingProductEventTicketTranslation extends Model implements BookingProductEventTicketTranslationContract
{
    public $timestamps = false;
    
    protected $fillable = [
        'name',
        'description',
    ];
}