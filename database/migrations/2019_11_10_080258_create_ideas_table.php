<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdeasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('ideas', static function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid', 20)->unique();
            $table->string('complain_id', 20)->unique();
            $table->bigInteger('user_id')->nullable();
			// $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->boolean('is_active')->default(false);
			$table->boolean('is_submitted')->default(false);
            $table->timestamp('submitted_at')->nullable();
            $table->boolean('is_approved')->default(false);
            $table->timestamp('approved_at')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->timestamp('featured_at')->nullable();
			$table->boolean('is_read')->default(true);

			$table->integer('status')->default(0);

			$table->string('name', 60);
			$table->string('contact', 60);
			$table->string('email', 191);

			$table->string('address', 191)->nullable();
			$table->string('entrepreneur_id', 60)->nullable();
			$table->string('product_code', 60)->nullable();
			$table->string('order_id', 60)->nullable();

            $table->string('title', 100)->nullable();
            $table->string('short_description', 1536)->nullable();
            $table->longText('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('ideas');
    }
}
