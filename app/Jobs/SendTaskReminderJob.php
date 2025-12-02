<?php

namespace App\Jobs;

use App\Models\Task;
use App\Mail\SendTaskReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendTaskReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Task $task;

    /**
     * Create a new job instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Safety checks
        $user = $this->task->user;
        if (! $user || ! $user->email) {
            return;
        }

        Mail::to($user->email)->send(new SendTaskReminder($this->task));
    }
}
