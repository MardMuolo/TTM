<?php

use App\Models\Jalon;
use App\Models\Demande;
use App\Models\CategoryDemande;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('demandes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->foreignId('category_demande_id')->constrained('category_demandes')->onDelete('cascade');
            $table->foreignId('jalon_id')->constrained('jalons')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        $csvData = fopen(public_path('demandes.csv'), 'r');
        $transRow = true;

        while (($data = fgetcsv($csvData, 555, ';')) !== false) {
            if (!$transRow && count($data) >= 3) {
                $jalon = Jalon::where('id', $data[2])->first();
                $category_demande = CategoryDemande::where('id', $data[1])->first();

                if ($jalon && $category_demande) {
                    $demande = new Demande();
                    $demande->title = $data[0];
                    $demande->jalon_id = $jalon->id;
                    $demande->category_demande_id = $category_demande->id;
                    $demande->save();
                }
            }
            $transRow = false;
        }
        fclose($csvData);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('demandes');
    }
};
