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
        Schema::create('metameta', function (Blueprint $table) {
            $table->id();
            $table->string('dataset_name_ja')->nullable();
            $table->string('dataset_name_en')->nullable();
            $table->string('dataset_id')->nullable();
            $table->unsignedBigInteger('dataset_number')->nullable();
            $table->unsignedBigInteger('severity')->nullable();
            $table->text('remarks')->nullable();
            $table->string('manager')->nullable();
            $table->string('reception_id')->nullable();
            $table->unsignedBigInteger('application_progress')->default(CoreConst::METAMETA_STATUS['UNDECIDED']);
            $table->unsignedBigInteger('data_meeting_progress')->default(CoreConst::METAMETA_STATUS['UNDECIDED']);
            $table->unsignedBigInteger('leader_meeting_progress')->default(CoreConst::METAMETA_STATUS['UNDECIDED']);
            $table->unsignedBigInteger('data_transfer_progress')->default(CoreConst::METAMETA_STATUS['UNDECIDED']);
            $table->unsignedBigInteger('metadata_progress')->default(CoreConst::METAMETA_STATUS['UNDECIDED']);
            $table->unsignedBigInteger('download_progress')->default(CoreConst::METAMETA_STATUS['UNDECIDED']);
            $table->unsignedBigInteger('search_progress')->default(CoreConst::METAMETA_STATUS['UNDECIDED']);
            $table->unsignedBigInteger('pr_progress')->default(CoreConst::METAMETA_STATUS['UNDECIDED']);
            $table->unsignedBigInteger('permission')->default(CoreConst::METAMETA_PREMISSION['UNNECESSARY']);
            $table->string('doi')->nullable();
            $table->unsignedBigInteger('category')->default(CoreConst::METAMETA_CATEGORY['ON_SITE_OBSERVATION']);
            $table->unsignedBigInteger('release_method')->default(CoreConst::METAMETA_RELEASE_METHOD['DATA_PRIVATE']);
            $table->unsignedBigInteger('access_permission')->default(CoreConst::METAMETA_ACCESS_PREMISSION['FREE_OPEN']);
            $table->string('data_directory')->nullable();
            $table->string('metadata_ja_url')->nullable();
            $table->string('metadata_en_url')->nullable();
            $table->string('search_url')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('deleted_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('created_by')->references('id')->on('users')->nullOnDelete();
            $table->foreign('updated_by')->references('id')->on('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('metameta');
    }
};
