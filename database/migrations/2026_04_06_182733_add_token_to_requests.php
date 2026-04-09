<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTokenToRequests extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
Schema::table('requests', function (Blueprint $table) {
$table->string('token')->nullable();
});
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requests', function (Blueprint $table) {
            //
        });
    }
}
