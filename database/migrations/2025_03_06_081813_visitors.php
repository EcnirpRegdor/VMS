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
        Schema::create("visitors", function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->string("first_name");
            $table->string("last_name");
            $table->string("email");
            $table->string("contact");
            $table->string("address");
            $table->text('profile_image')->nullable();
            $table->string("affiliation")->nullable();
            $table->foreignId('user_id')->nullable();
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
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
