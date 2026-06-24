<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        DB::statement('CREATE INDEX user_login_histories_user_session_idx ON user_login_histories (user_id, session_id(191))');
        DB::statement('CREATE INDEX user_login_histories_user_created_idx ON user_login_histories (user_id, created_at)');
    }

    public function down()
    {
        DB::statement('DROP INDEX user_login_histories_user_session_idx ON user_login_histories');
        DB::statement('DROP INDEX user_login_histories_user_created_idx ON user_login_histories');
    }
};
