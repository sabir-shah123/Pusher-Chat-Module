<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActiveStatusFieldToUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('active_status')->default(0);
        	$table->string('avatar')->default(config('chat.user_avatar.default'));
  			$table->string('messenger_color')->default('#2180f3');
            $table->boolean('dark_mode')->default(0);

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
            $table->dropColumn('active_status');
            $table->dropColumn('avatar');
            $table->dropColumn('messenger_color');
            $table->dropColumn('dark_mode');
			$table->dropColumn('bio');
  		  });
    }
}
