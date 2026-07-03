<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVisitCountToWebinarsAndProductsTable extends Migration
{
    public function up()
    {
        if (!Schema::hasColumn('webinars', 'visit_count')) {
            Schema::table('webinars', function (Blueprint $table) {
                $table->integer('visit_count')->unsigned()->nullable()->default(0);
            });
        }
        if (!Schema::hasColumn('products', 'visit_count')) {
            Schema::table('products', function (Blueprint $table) {
                $table->integer('visit_count')->unsigned()->nullable()->default(0);
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('webinars', 'visit_count')) {
            Schema::table('webinars', function (Blueprint $table) {
                $table->dropColumn('visit_count');
            });
        }
        if (Schema::hasColumn('products', 'visit_count')) {
            Schema::table('products', function (Blueprint $table) {
                $table->dropColumn('visit_count');
            });
        }
    }
}