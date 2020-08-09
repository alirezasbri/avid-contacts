<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeTypeOfContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {

            $table->dropColumn('type');

        });

        Schema::table('contacts', function (Blueprint $table) {

            $table->enum('type', ['private', 'public']);

        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('contacts', function (Blueprint $table) {
            $table->string('type', 8);
        });
    }
}
