<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetTransactions extends Model
{
    protected $table = "asset_transaction";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';

    public function asset()
    {
        return $this->hasOne(Asset::class, 'id', 'asset_id');
    }
    public function vendor()
    {
        return $this->hasOne(Vendor::class, 'id', 'vendor_id');
    }
    public function asasset()
    {
        return $this->belongsTo(Asset::class, 'asset_id');
    }
}
