<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NewProfileUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->uuidMorphs('user');
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->foreignId('position')->nullable();
            $table->dateTime('activated_at', 0)->nullable();
            $table->dateTime('deactivated_at', 0)->nullable();
            $table->boolean('active')->default(false)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
