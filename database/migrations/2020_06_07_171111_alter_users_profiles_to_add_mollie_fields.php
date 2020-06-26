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
            $table->string('mollie_mandate_id')->nullable();
            $table->decimal('tax_percentage', 6, 4)->default(0);
            $table->dateTime('trial_ends_at')->nullable();
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
            $table->dropColumn('mollie_mandate_id');
            $table->dropColumn('tax_percentage');
            $table->dropColumn('trial_ends_at');
            $table->dropColumn('extra_billing_information');
        });
    }
}
