<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetModelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_model', function (Blueprint $table) {
            $table->id();
            $table->unsignedbiginteger('asset_type_id');
            $table->unsignedbiginteger('manufacturer_id');
            $table->string('model_name', 255);
            $table->string('cb', 255)->nullable();
            $table->timestamp('cd')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('ub', 255)->nullable();
            $table->timestamp('ud')->default(DB::raw('CURRENT_TIMESTAMP'));


            $table->foreign('asset_type_id')->references('id')->on('asset_type');
            $table->foreign('manufacturer_id')->references('id')->on('manufacturer');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_model');
    }
}
