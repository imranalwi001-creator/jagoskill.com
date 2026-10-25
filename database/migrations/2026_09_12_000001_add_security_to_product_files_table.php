<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSecurityToProductFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('product_files', function (Blueprint $table) {
            if (!Schema::hasColumn('product_files', 'download_limit')) {
                $table->unsignedInteger('download_limit')->nullable()->default(0)->after('volume');
            }
            if (!Schema::hasColumn('product_files', 'access_type')) {
                $table->enum('access_type', ['upload', 'external_link'])->default('upload')->after('download_limit');
            }
            if (!Schema::hasColumn('product_files', 'external_link')) {
                $table->text('external_link')->nullable()->after('access_type');
            }
            if (!Schema::hasColumn('product_files', 'storage_driver')) {
                $table->string('storage_driver', 50)->default('local_private')->after('external_link');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('product_files', function (Blueprint $table) {
            $table->dropColumn(['download_limit', 'access_type', 'external_link', 'storage_driver']);
        });
    }
}
