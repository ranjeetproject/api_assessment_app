<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;

class DeleteOldRecords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'delete:old-records';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes records older than 30 days';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = now()->subDays(30); // Calculate the date 30 days ago
        Task::where('created_at', '<=', $date)->delete();

        $this->info('Old records deleted successfully!');
    }
}