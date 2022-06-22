<?php

use App\Models\Equipment;
use App\Models\EquipmentChar;
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
        Schema::create('equipment_char_map', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(EquipmentChar::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->foreignIdFor(Equipment::class)->nullable()->constrained()->cascadeOnUpdate()->nullOnDelete();
            $table->string('value')->nullable();
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
        Schema::dropIfExists('equipment_char_map');
    }
};
