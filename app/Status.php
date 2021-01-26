<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;
use Kyslik\ColumnSortable\Sortable;
use Kyslik\LaravelFilterable\Filterable;

class Status extends Model
{
    use SoftDeletes, Sortable, Filterable;

    protected $table = 'status';
    protected $fillable = ['name_en', 'name_ar', 'status_type', 'status_flow', 'x', 'y'];
    protected $primaryKey = 'statusID';

    protected $sortable = ['statusID', 'name_en', 'name_ar', 'StatusFlow'];

    public function FromStatus()
    {
        return $this->belongsToMany('App\Status', 'status_next', 'ToStatus', 'FromStatus');
    }

    public function ToStatus()
    {
        return $this->belongsToMany('App\Status', 'status_next', 'FromStatus', 'ToStatus');
    }

    public function StatusType()
    {
        return $this->belongsTo('App\StatusType', 'status_type', 'id', 'status_type');
    }

    public function StatusFlow()
    {
        return $this->belongsTo('App\StatusFlow', 'status_flow', 'id', 'status_flow');
    }

    public function getNameAttribute()
    {
        return $this['name_' . App::getLocale()];
    }
}
