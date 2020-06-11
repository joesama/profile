<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserForProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'guid')) {
                $table->string('guid')->nullable();
            }

            if (! Schema::hasColumn('users', 'name')) {
                $table->string('name')->after('guid')->nullable();
            }

            if (! Schema::hasColumn('users', 'email')) {
                $table->string('email')->after('name')->unique();
                $table->timestamp('email_verified_at')->after('email')->nullable();
            }

            if (! Schema::hasColumn('users', 'password')) {
                $table->string('password')->after('email_verified_at')->nullable();
            }

            if (! Schema::hasColumn('users', 'deleted_at')) {
                $table->softDeletes();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // DO NOTHING HERE
        });
    }
}
