<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateCheckoutsTableRevise extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('checkouts', function (Blueprint $table) {
            $table->dropColumn(['payload', 'payload_value', 'price']);
            $table->bigInteger('payment_method_id')->after('account_id');
            $table->double('sub_total')->after('payment_method_id');
            $table->double('tax')->after('sub_total');
            $table->double('total')->after('tax');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('checkouts', function (Blueprint $table) {
            //
        });
    }
}
