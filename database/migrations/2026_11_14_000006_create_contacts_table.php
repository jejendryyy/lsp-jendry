<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('sender_name', 100);
            $table->string('sender_email', 150);
            $table->string('sender_phone', 30)->nullable();
            $table->foreignId('product_id')->nullable()->constrained( )->nullOnDelete();
            $table->text('message')->nullable();
            $table->enum('status', ['waiting', 'approved', 'active', 'non active'])->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contacts');
    }
};
