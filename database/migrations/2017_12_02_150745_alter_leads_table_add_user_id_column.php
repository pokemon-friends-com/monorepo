<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterLeadsTableAddUserIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_lead_id_foreign');
            $table->dropColumn('lead_id');
        });
        Schema::table('leads', function (Blueprint $table) {
            $table->unsignedInteger('user_id')->nullable(true)->after('id')->index();
            $table
                ->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onUpdate('no action')
                ->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('leads', function (Blueprint $table) {
            $table->dropForeign('leads_user_id_foreign');
            $table->dropColumn('user_id');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('lead_id')->nullable(true)->after('uniqid')->index();
            $table
                ->foreign('lead_id')
                ->references('id')
                ->on('leads')
                ->onUpdate('no action')
                ->onDelete('no action');
        });
    }
}
