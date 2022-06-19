<?php

use App\Models\Audience;
use App\Models\Equipment;
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
        Schema::create('equipment_placement', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Equipment::class)->constrained()->nullOnDelete();
            $table->foreignIdFor(Audience::class)->constrained()->nullOnDelete();
            $table->timestamp('placed_at')->useCurrent();
            $table->timestamp('removed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipment_placement');
    }
};