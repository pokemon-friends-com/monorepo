<?php

use Illuminate\Database\Migrations\Migration;

/**
 * Class AlterSettingsTable
 */
class AlterSettingsTableRenameValueColumn extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function ($table) {
            $table->renameColumn('value', 'setting_value');
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
            $table->renameColumn('setting_value', 'value');
        });
    }
}
