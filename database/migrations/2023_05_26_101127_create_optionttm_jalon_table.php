<?php

use App\Models\Jalon;
use App\Models\OptionTtm;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('optionttm_jalon', function (Blueprint $table) {
            $table->foreignId('option_ttm_id')->constrained('option_ttms')->onDelete('cascade');
            $table->foreignId('jalon_id')->constrained('jalons')->onDelete('cascade');
            $table->primary(['option_ttm_id', 'jalon_id']);
            $table->timestamps();
        });

        $option1 = OptionTtm::create([
            'nom' => 'Super Fast Track',
            'minComplexite' => 0,
            'maxComplexite' => 15,
        ]);
        $option2 = OptionTtm::create([
            'nom' => 'Fast Track',
            'minComplexite' => 15,
            'maxComplexite' => 30,
        ]);
        $option3 = OptionTtm::create([
            'nom' => 'Full Track',
            'minComplexite' => 30,
            'maxComplexite' => 30000,
        ]);

        // Attache des jalons aux options TTM
        $jalonIds = Jalon::pluck('id')->toArray();

        // Option 1 est attachée à 6 jalons
        $option1->jalons()->attach(array_slice($jalonIds, 0, 6));

        // Option 2 est attachée aux jalons 1, 2 5,6
        $option2->jalons()->attach([1, 2, 5,6]);

        // Option 3 est attachée aux jalons 2, 5 et 6
        $option3->jalons()->attach([2, 5, 6]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('optionttm_jalon');
    }
};
