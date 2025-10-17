<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('intake_forms', function (Blueprint $table) {
            $table->dropColumn(['business_hours_start', 'business_hours_end']);
            $table->boolean('on_call_saturday')->default(false);
            $table->boolean('on_call_sunday')->default(false);
            $table->json('business_hours')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('intake_forms', function (Blueprint $table) {
            $table->dropColumn(['on_call_saturday', 'on_call_sunday','business_hours']);
            $table->time('business_hours_start')->nullable();
            $table->time('business_hours_end')->nullable();
        });
    }
};
