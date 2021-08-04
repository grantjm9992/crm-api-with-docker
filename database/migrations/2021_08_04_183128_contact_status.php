<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ContactStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_status', function (Blueprint $table) {
            $table->uuid('id')->unique();
            $table->string('name');
            $table->string('colour')->nullable();
            $table->smallInteger('active')->default(0);
            $table->string('company_id');
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
}
