<?php

namespace App\Console\Commands;

use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CleanUpTasks extends Command
{


    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:cleanup';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete tasks that have been in the trash for more than 30 days';


    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get tasks that have been soft deleted for 30 days or more
        $tasks = Task::onlyTrashed()
            ->where('deleted_at', '<', Carbon::now()->subDays(30))
            ->get();

        foreach ($tasks as $task) {
            // Permanently delete the task
            $task->forceDelete();
        }

        $this->info('Tasks older than 30 days have been deleted.');
    }
}
