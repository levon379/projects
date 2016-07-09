<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCronColumnToPiwikSite extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('piwik_site', 'cron'))
        {
            DB::statement("ALTER TABLE `piwik_site` ADD COLUMN `cron` int(11) NULL DEFAULT 0 AFTER `user_id`;");
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('piwik_site', 'cron'))
        {
            DB::statement("ALTER TABLE `piwik_site` DROP COLUMN `cron`;");
        }
    }

}
