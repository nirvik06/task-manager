<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('status', ['pending', 'in_progress', 'done'])->default('pending');
            $table->date('due_date');
            // optional: sent reminder flag
            $table->timestamp('reminder_sent_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'status', 'due_date']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
