<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('exercise_logs', function (Blueprint $table) {
            $table->decimal('weight', 5, 2)->nullable()->change();
            $table->integer('reps')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('exercise_logs', function (Blueprint $table) {
            $table->decimal('weight', 5, 2)->nullable(false)->change();
            $table->integer('reps')->nullable(false)->change();
        });
    }
};
