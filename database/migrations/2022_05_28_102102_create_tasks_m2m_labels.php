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
        Schema::create('tasks_m2m_labels', function (Blueprint $table) {
            $table->id();

            $table->integer('label_id');
            $table->foreign('label_id')
                ->references('id')
                ->on('labels')
                ->onDelete('restrict');

            $table->integer('task_id');
            $table->foreign('task_id')
                ->references('id')
                ->on('tasks')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks_m2m_labels');
    }
};
