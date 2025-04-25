<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddWeightToUserCategoryPreferencesTable extends Migration
{
    public function up()
    {
        Schema::table('user_category_preferences', function (Blueprint $table) {
            $table->integer('weight')->default(1);
        });
    }

    public function down()
    {
        Schema::table('user_category_preferences', function (Blueprint $table) {
            $table->dropColumn('weight');
        });
    }
}
