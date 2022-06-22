<?php

use App\Models\Employee;
use App\Models\Equipment;
use App\Models\EquipmentWorkStatus;
use App\Models\EquipmentWorkType;
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
        Schema::create('equipment_works', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Equipment::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(EquipmentWorkType::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignIdFor(EquipmentWorkStatus::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamp('started_at')->useCurrent();
            $table->timestamp('ended_at')->nullable();
            $table->foreignIdFor(Employee::class)->constrained()->cascadeOnDelete()->cascadeOnUpdate();
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
        Schema::dropIfExists('equipment_works');
    }
};
