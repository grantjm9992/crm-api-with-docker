<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDbSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        // Create Contacts table
        Schema::create('contacts', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary();
            $table->string('company_id');
            $table->string('name');
            $table->string('surname');
            $table->string('phone')->nullable();
            $table->string('mobile')->nullable();
            $table->string('email')->unique();
            $table->string('channel_id')->nullable();
            $table->string('campaign_id')->nullable();
            $table->string('contact_type_id')->nullable();
            $table->string('assigned_to_id')->nullable();
            $table->string('contact_status_id')->nullable();
            $table->dateTime('date_attended')->nullable();
            $table->dateTime('date')->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('channels', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary();
            $table->string('company_id');
            $table->string('name');
            $table->smallInteger('active')->default(1);
            $table->timestamps();
        });

        Schema::create('campaign', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary();
            $table->string('name');
            $table->smallInteger('active')->default(1);
            $table->timestamps();
        });

        Schema::create('contact_type', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary();
            $table->string('company_id');
            $table->string('name');
            $table->smallInteger('active')->default(1);
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary();
            $table->string('company_id');
            $table->string('name');
            $table->string('surname');
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('role_id')->nullable();
            $table->string('password');
            $table->string('api_token');
            $table->timestamps();
        });

        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary()->unique();
            $table->string('name');
            $table->string('token');
            $table->timestamps();
        });

        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary();
            $table->string('name');
            $table->smallInteger('active')->default(1);
            $table->timestamps();
        });

        Schema::create('tasks', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary();
            $table->string('company_id');
            $table->string('title');
            $table->longText('description')->nullable();
            $table->string('status')->nullable();
            $table->string('user_id')->nullable();
            $table->string('contact_id')->nullable();
            $table->longText('notes')->nullable();
            $table->boolean('important')->nullable();
            $table->boolean('starred')->nullable();
            $table->boolean('completed')->nullable();
            $table->integer('order')->nullable();
            $table->timestamps();
        });

        Schema::create('task_categories', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary();
            $table->string('company_id');
            $table->string('name');
            $table->smallInteger('active')->default(1);
            $table->timestamps();
        });

        Schema::create('tasks_task_categories', function (Blueprint $table) {
            $table->id();
            $table->string('task_category_id')->index();
            $table->string('task_id')->index();
            $table->timestamps();
        });

        Schema::create('documents_entities', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary();
            $table->string('entity_type');
            $table->string('entity_id');
            $table->string('file_name');
            $table->string('file_path');
            $table->timestamps();
        });

        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary();
            $table->string('company_id');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->float('price')->nullable();
            $table->string('product_type_id')->nullable();
            $table->string('product_status')->nullable()->default('available');
            $table->timestamps();
        });

        Schema::create('product_types', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary();
            $table->string('company_id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('product_categories', function (Blueprint $table) {
            $table->uuid('id')->default(DB::raw('(UUID())'))->primary();
            $table->string('company_id');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('products_product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('product_id')->index();
            $table->string('product_category_id')->index();
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
        Schema::dropIfExists('contacts');
        Schema::dropIfExists('users');
        Schema::dropIfExists('tasks');
    }
}
