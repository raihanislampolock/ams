<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetTransactions extends Model
{
    protected $table = "asset_transactions";
    const CREATED_AT = 'cd';
    const UPDATED_AT = 'ud';

    public function assetModel()
    {
        return $this->hasOne(AssetModel::class, 'id', 'asset_model_id');
    }
    
}
