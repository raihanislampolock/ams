<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetModel extends Model
{
    protected $table = "asset_model";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';

    public function assetType()
    {
        return $this->hasOne(AssetType::class, 'id', 'asset_type_id');
    }
 
    public function manufacturer()
    {
        return $this->hasOne(Manufacturer::class, 'id', 'manufacturer_id');
    }

}
