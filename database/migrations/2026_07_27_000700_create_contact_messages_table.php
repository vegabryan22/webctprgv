<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_messages', function (Blueprint $table): void {
            $table->id();
            $table->string('name', 150);
            $table->string('email');
            $table->string('phone', 40)->nullable();
            $table->string('subject', 180);
            $table->text('message');
            $table->string('status', 20)->default('new')->index();
            $table->timestamp('consented_at');
            $table->timestamp('read_at')->nullable();
            $table->timestamp('handled_at')->nullable();
            $table->timestamps();
        });

        DB::table('site_settings')->insert([
            'key' => 'contact_notification_email',
            'value' => null,
            'group' => 'contacto',
            'label' => 'Correo receptor del formulario',
            'type' => 'email',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function down(): void
    {
        DB::table('site_settings')->where('key', 'contact_notification_email')->delete();
        Schema::dropIfExists('contact_messages');
    }
};
