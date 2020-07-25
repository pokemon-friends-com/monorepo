<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterUsersProfilesToAddMollieFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users_profiles', function (Blueprint $table) {
            $table->string('mollie_customer_id')->nullable();
        });
        Schema::table('users_profiles', function (Blueprint $table) {
            $table->string('mollie_mandate_id')->nullable();
        });
        Schema::table('users_profiles', function (Blueprint $table) {
            $table->decimal('tax_percentage', 6, 4)->default(0);
        });
        Schema::table('users_profiles', function (Blueprint $table) {
            $table->dateTime('trial_ends_at')->nullable();
        });
        Schema::table('users_profiles', function (Blueprint $table) {
            $table->text('extra_billing_information')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users_profiles', function (Blueprint $table) {
            $table->dropColumn('mollie_customer_id');
        });
        Schema::table('users_profiles', function (Blueprint $table) {
            $table->dropColumn('mollie_mandate_id');
        });
        Schema::table('users_profiles', function (Blueprint $table) {
            $table->dropColumn('tax_percentage');
        });
        Schema::table('users_profiles', function (Blueprint $table) {
            $table->dropColumn('trial_ends_at');
        });
        Schema::table('users_profiles', function (Blueprint $table) {
            $table->dropColumn('extra_billing_information');
        });
    }
}
