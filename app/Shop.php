<?php

namespace App;

use App\Traits\Scopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Kyslik\ColumnSortable\Sortable;
use Kyslik\LaravelFilterable\Filterable;

class Shop extends Model
{
    use SoftDeletes, Scopes, Sortable, Filterable;
    protected $table = 'shops';
    protected $fillable = ['shopID','name_en','name_ar','status','priority','countries_countryID','cities_cityID','areas_areaID','nearBy', 'longitude', 'latitude','phone'];
    protected $primaryKey ='shopID';

    protected $sortable = ['shopID', 'name_en', 'name_ar', 'nearBy', 'status'];

    public function User()
    {
        return $this->belongsToMany('App\User','shops_representative');
    }

    public function Country()
    {
        return $this->belongsTo('App\Country','countries_countryID');
    }

    public function City()
    {
        return $this->belongsTo('App\City','cities_cityID');
    }

    public function Area()
    {
        return $this->belongsTo('App\Area','areas_areaID');
    }

    public function getNameAttribute()
    {
        return $this['name_' . App::getLocale()];
    }
}
