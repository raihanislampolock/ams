<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset_Model extends Model
{
    protected $table = "asset_model";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';

    public function AssetTypefk()
    {
        return $this->hasOne(Asset_Type::class, 'id', 'asset_type_id');
    }
 

    public function Manufacturerfk()
    {
        return $this->hasOne(Manufacturer::class, 'id', 'manufacturer_id');
    }

    public function Vendorfk()
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }
}
