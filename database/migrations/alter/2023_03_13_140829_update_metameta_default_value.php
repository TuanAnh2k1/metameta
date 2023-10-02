<?php

use App\Core\Common\CoreConst;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('metameta', function (Blueprint $table) {
            $table->unsignedBigInteger('permission')->default(CoreConst::METAMETA_PREMISSION['UNNECESSARY'])->change();
            $table->unsignedBigInteger('category')->default(CoreConst::METAMETA_CATEGORY['ON_SITE_OBSERVATION'])->change();
            $table->unsignedBigInteger('release_method')->default(CoreConst::METAMETA_RELEASE_METHOD['DATA_PRIVATE'])->change();
            $table->unsignedBigInteger('access_permission')->default(CoreConst::METAMETA_ACCESS_PREMISSION['FREE_OPEN'])->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
