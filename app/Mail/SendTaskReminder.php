<?php

namespace App\Mail;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendTaskReminder extends Mailable
{
    use Queueable, SerializesModels;

    public Task $task;

    /**
     * Create a new message instance.
     */
    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this
            ->subject('Reminder: Task due tomorrow — ' . $this->task->title)
            ->view('emails.task_reminder')
            ->with([
                'task' => $this->task,
                'user' => $this->task->user,
            ]);
    }
}