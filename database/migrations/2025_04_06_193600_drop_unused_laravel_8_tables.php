<?php
require_once base_path('database/migrations/2014_10_12_000000_create_users_table.php');
require_once base_path('database/migrations/2014_10_12_100000_create_password_resets_table.php');
require_once base_path('database/migrations/2019_08_19_000000_create_failed_jobs_table.php');
require_once base_path('database/migrations/2019_12_14_000001_create_personal_access_tokens_table.php');

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        (new CreatePersonalAccessTokensTable)->down();
        (new CreateFailedJobsTable)->down();
        (new CreatePasswordResetsTable)->down();
        (new CreateUsersTable)->down();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        (new CreateUsersTable)->up();
        (new CreatePasswordResetsTable)->up();
        (new CreateFailedJobsTable)->up();
        (new CreatePersonalAccessTokensTable)->up();
    }
};
