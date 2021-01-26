<?php

namespace App;

use App\Enums\UserType;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Kyslik\ColumnSortable\Sortable;
use Kyslik\LaravelFilterable\Filterable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use SoftDeletes,Notifiable,HasApiTokens,HasRoles,Sortable,Filterable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'gender', 'DOB', 'type'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

	/**
	 * The attributes that should be appended on arrays.
	 *
	 * @var array
	 */
    protected $appends = ['shops_shopID','deliveries_deliveryID'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $sortable = ['id', 'name', 'email', 'type', 'created_at'];

    public function Shop()
    {
        return $this->belongsToMany('App\Shop','shops_representative','users_id','shops_shopID');
    }

    public function Delivery()
    {
       return $this->belongsToMany('App\Delivery','deliveries_representative', 'users_id', 'deliveries_deliveryID');
    }

    public function getTypeAttribute($value)
    {
        return UserType::$types[$value - 1];
    }

    /** getting shop for user */
	public function getShopsShopIDAttribute()
	{
		return Shop::find(ShopRepresentative::where('users_id', $this->attributes['id'])->orderby('id','desc')->first()->shops_shopID)->shopID;
    }
	/** getting delivery for user */
	public function getDeliveriesDeliveryIDAttribute()
	{
		return Delivery::find(DeliveryRepresentative::where('users_id', $this->attributes['id'])->orderby('id','desc')->first()->deliveries_deliveryID)->deliveryID;
	}
}
