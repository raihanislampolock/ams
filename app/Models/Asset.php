<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = "asset";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';

    public function assetType()
    {
        return $this->hasOne(AssetType::class, 'id', 'asset_type_id');
    }

    public function assetModel()
    {
        return $this->hasOne(AssetModel::class, 'id', 'asset_model_id');
    }

    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }

    public function assetTransactions()
    {
        return $this->hasOne(AssetTransactions::class, 'id', 'asset_transactions_id');
    }

    public function manufacturer()
    {
        return $this->hasOne(Manufacturer::class, 'id', 'manufacturer_id');
    }

}
