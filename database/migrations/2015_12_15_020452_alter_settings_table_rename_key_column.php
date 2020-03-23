<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Class AlterSettingsTable
 */
class AlterSettingsTableRenameKeyColumn extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function ($table) {
            $table->renameColumn('key', 'setting_key');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function ($table) {
            $table->renameColumn('setting_key', 'key');
        });
    }
}
