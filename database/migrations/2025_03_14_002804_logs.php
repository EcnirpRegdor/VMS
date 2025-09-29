<?php

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
        Schema::create("general_logs", function (Blueprint $table) {
        $table->bigIncrements("id");
        $table->enum("action", allowed: ["Created","Updated","Deleted", "Login", "Logout"]);
        $table->unsignedBigInteger("row_id");
        $table->string("table_name");
        $table->text("description");
        $table->foreignId("user_id")->nullable()->constrained()->onDelete("cascade");
        $table->string("ip_address")->nullable();
        $table->json("changes")->nullable();
        $table->string('device_name')->nullable();
        $table->string('device_platform');
        $table->string('device_model');
        $table->string('device_type');
        $table->timestamps();
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
