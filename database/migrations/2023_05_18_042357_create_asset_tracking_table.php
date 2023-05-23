<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_tracking', function (Blueprint $table) {
            $table->id();
            $table->unsignedbiginteger('department_id');
            $table->unsignedbiginteger('emp_id');
            $table->unsignedbiginteger('asset_id');
            $table->date('assign_date');
            $table->unsignedbiginteger('asset_location_id');
            $table->string('remarks', 255)->nullable();
            $table->string('cb', 255)->nullable();
            $table->timestamp('cd')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('ub', 255)->nullable();
            $table->timestamp('ud')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('department_id')->references('id')->on('department');
            $table->foreign('emp_id')->references('id')->on('employee');
            $table->foreign('asset_id')->references('id')->on('asset');
            $table->foreign('asset_location_id')->references('id')->on('asset_location');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_tracking');
    }
}
