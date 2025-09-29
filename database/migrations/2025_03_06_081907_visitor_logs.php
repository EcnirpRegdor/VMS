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
        Schema::create("visitor_logs", function (Blueprint $table) {
        $table->bigIncrements("id");
        $table->string("purpose")->nullable();
        $table->foreignId("user_id")->nullable()->constrained()->onDelete("cascade");
        $table->foreignId("visitor_id")->constrained()->onDelete("cascade");
        $table->dateTime("visited_at");
        $table->foreignId("dept_id")->nullable()->constrained('departments')->onDelete("cascade");
        
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
