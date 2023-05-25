<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_transaction', function (Blueprint $table) {
            $table->id();
            $table->unsignedbiginteger('asset_id');
            $table->unsignedbiginteger('vendor_id');
            $table->string('asset_price', 255);
            $table->date('asset_purchase_date');
            $table->string('asset_purchase_request', 255);
            $table->string('asset_purchase_order', 255);
            $table->date('asset_warranty_date');
            $table->string('cb', 255)->nullable();
            $table->timestamp('cd')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('ub', 255)->nullable();
            $table->timestamp('ud')->default(DB::raw('CURRENT_TIMESTAMP'));


            $table->foreign('asset_id')->references('id')->on('asset');
            $table->foreign('vendor_id')->references('id')->on('vendor');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_transaction');
    }
}
