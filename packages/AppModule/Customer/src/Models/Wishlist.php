<?php

namespace AppModule\Customer\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use AppModule\Customer\Contracts\Wishlist as WishlistContract;
use AppModule\Product\Models\ProductProxy;
use AppModule\Core\Models\ChannelProxy;
use AppModule\Customer\Models\CustomerProxy;

class Wishlist extends Model implements WishlistContract
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'wishlist';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'additional' => 'array',
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * The product that belong to the wishlist.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(ProductProxy::modelClass());
    }

    /**
     * The Channel that belong to the wishlist.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function channel()
    {
        return $this->hasOne(ChannelProxy::modelClass(), 'id', 'channel_id');
    }

    /**
     * The Customer that belong to the wishlist.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function customer()
    {
        return $this->belongsTo(CustomerProxy::modelClass(), 'customer_id');
    }

    /**
     * Create a new factory instance for the model
     *
     * @return Factory
     */
    protected static function newFactory()
    {
        return \AppModule\Customer\Database\Factories\CustomerWishlistFactory::new ();
    }
}
