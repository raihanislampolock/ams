<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetTracking extends Model
{
    protected $table = "asset_tracking";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';

    public function department()
    {
        return $this->hasOne(Department::class, 'id', 'department_id');
    }

    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'emp_id');
    }

    public function asset()
    {
        return $this->hasOne(Asset::class, 'id', 'asset_id');
    }

    public function assetLocation()
    {
        return $this->hasOne(AssetLocation::class, 'id', 'asset_location_id');
    }
    public function emp()
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }
    public function depart()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function ast()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
