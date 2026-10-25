<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('product_licenses')) {
            Schema::create('product_licenses', function (Blueprint $table) {
                $table->engine = 'InnoDB';
                $table->bigIncrements('id');
                $table->unsignedInteger('product_id')->index();
                $table->unsignedInteger('product_order_id')->nullable()->index();
                $table->unsignedInteger('user_id')->nullable()->index();
                $table->string('license_key', 191)->unique();
                $table->enum('status', ['active', 'inactive', 'revoked'])->default('active');
                $table->unsignedInteger('max_activations')->default(1);
                $table->unsignedInteger('activation_count')->default(0);
                $table->unsignedBigInteger('expires_at')->nullable();
                $table->unsignedBigInteger('created_at');
                $table->unsignedBigInteger('updated_at')->nullable();

                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
                $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
        Schema::dropIfExists('product_licenses');
    }
}
