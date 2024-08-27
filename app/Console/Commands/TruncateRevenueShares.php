<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TruncateRevenueShares extends Command
{
    protected $signature = 'revenue:truncate';

    protected $description = 'Truncate the revenue_shares table';

    public function handle()
    {
        DB::table('revenue_shares')->truncate();
        $this->info('revenue_shares table has been truncated.');
    }
}
