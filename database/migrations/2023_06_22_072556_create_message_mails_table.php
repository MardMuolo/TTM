<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('message_mails', function (Blueprint $table) {
            $table->id();
            $table->string('code_name');
            $table->text('body');
            $table->string('type');
            $table->boolean('action')->default(false);
            $table->boolean('attachement')->default(false);
            $table->string('object')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('message_mails');
    }
};
