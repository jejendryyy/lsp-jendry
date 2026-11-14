<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->string('project_tag', 80)->nullable();
            $table->string('image_path')->nullable();
            $table->text('caption')->nullable();
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('galleries');
    }
};
