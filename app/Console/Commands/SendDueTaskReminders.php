<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Task;
use Illuminate\Console\Command;
use App\Jobs\SendTaskReminderJob;

class SendDueTaskReminders extends Command
{
    protected $signature = 'tasks:send-due-reminders';
    protected $description = 'Find tasks due tomorrow and dispatch reminder emails (queued).';

    public function handle()
    {
        $tomorrow = Carbon::tomorrow()->toDateString();

        $this->info("Finding tasks due on: {$tomorrow}");

        // Fetch tasks with a due_date equal to tomorrow (only pending/in_progress/done as needed)
        $tasks = Task::whereDate('due_date', $tomorrow)
            ->whereNotNull('due_date')
            ->get();

        $this->info('Tasks found: '.$tasks->count());

        foreach ($tasks as $task) {
            // dispatch a job per task
            SendTaskReminderJob::dispatch($task);
            $this->info("Dispatched reminder job for task #{$task->id} ({$task->title})");
        }

        $this->info('All reminder jobs dispatched.');

        return 0;
    }
}