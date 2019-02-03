<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateAccountImagesTableAddChange extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('account_images', function (Blueprint $table) {
            $table->string('payload')->after('account_id')->nullable();
            $table->string('payload_value')->after('payload')->nullable();
            $table->string('status')->after('payload_value')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('account_images', function (Blueprint $table) {
            //
        });
    }
}
