<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductLicenseActivationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('product_license_activations')) {
            Schema::create('product_license_activations', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->bigIncrements('id');
                $table->unsignedBigInteger('license_id')->index();
                $table->string('domain', 255)->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->string('machine_id', 255)->nullable()->index();
                $table->text('user_agent')->nullable();
                $table->unsignedBigInteger('activated_at');

                $table->foreign('license_id')->references('id')->on('product_licenses')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_license_activations');
    }
}
