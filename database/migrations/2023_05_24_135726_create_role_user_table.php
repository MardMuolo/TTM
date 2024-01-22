<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('role_user', function (Blueprint $table) {
            $table->foreignId('role_id')->onDelete('cascade');
            $table->foreignId('user_id')->onDelete('cascade');
        });

        $role = Role::where('name', env('RootAdmin'))->first();
        $admin = User::where('username', env('RootAdmin'))->first();

        // Affect admin role to admin default user
        $admin->roles()->sync($role->id);
        $admin->save();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('role_user', function (Blueprint $table) {
            $table->id();
            $table->dropForeign('role_user_role_id_foreing');
            $table->dropForeign('role_user_user_id_foreing');
        });
    }
};
