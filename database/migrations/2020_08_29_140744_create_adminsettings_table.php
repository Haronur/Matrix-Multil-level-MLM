<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adminsettings', function (Blueprint $table) {
            $table->id();
            $table->integer('width')->nullable();
            $table->integer('depth')->nullable();
            $table->string('account_email')->nullable();
            $table->decimal('membership_budget',5,2)->nullable();
            $table->text('percent_value')->nullable();
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
        Schema::dropIfExists('adminsettings');
    }
}
