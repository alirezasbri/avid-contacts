<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSharedTypeToContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('contacts', function (Blueprint $table) {
//            $table->enum('type', ['private', 'public', 'shared'])->change();
            DB::statement("ALTER TABLE `contacts` CHANGE `type` `type` ENUM('private', 'public', 'shared');");
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
            DB::statement("ALTER TABLE `contacts` CHANGE `type` `type` ENUM('private', 'public');");
        });
    }
}
