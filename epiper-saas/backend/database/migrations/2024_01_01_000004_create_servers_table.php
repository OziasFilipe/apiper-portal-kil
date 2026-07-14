<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('host');
            $table->integer('port')->default(22);
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->text('private_key')->nullable();
            $table->string('type')->default('vps');
            $table->boolean('status')->default(true);
            $table->foreignId('company_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('os')->nullable();
            $table->float('cpu')->nullable();
            $table->float('ram')->nullable();
            $table->float('disk')->nullable();
            $table->timestamp('last_ping_at')->nullable();
            $table->timestamps();

            $table->index(['company_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servers');
    }
};
