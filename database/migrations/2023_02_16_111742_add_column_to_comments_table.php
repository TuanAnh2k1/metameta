<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comments', function (Blueprint $table) {
            //
            $table->text('comment')->nullable()->change();
            $table->string('comment_date');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('metadata_no');
            $table->unsignedBigInteger('metameta_element_id');
            $table->dropColumn('item_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comments', function (Blueprint $table) {
            //
            $table->dropColumn('comment');
            $table->dropColumn('comment_date');
            $table->dropColumn('user_id');
            $table->dropColumn('metadata_no');
            $table->dropColumn('metameta_element_id');
            $table->dropColumn('item_id');
        });
    }
};
