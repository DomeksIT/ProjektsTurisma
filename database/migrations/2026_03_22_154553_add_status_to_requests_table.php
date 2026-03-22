<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class AddStatusToRequestsTable extends Migration
{
    public function up()
    {

        Schema::table('requests', function (Blueprint $table) {

            $table->string('status')->default('Jauns');

        });

    }
    public function down()
    {
        Schema::table('requests', function (Blueprint $table) {

            $table->dropColumn('status');

        });

    }
}
 
