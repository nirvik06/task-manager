<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Task Reminder</title>
</head>
<body>
  <div style="font-family: sans-serif; line-height: 1.6; color: #111;">
    <h2>Reminder: "{{ $task->title }}"</h2>

    <p>Hello {{ $user->name }},</p>

    <p>This is a reminder that the following task is due tomorrow ({{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') }}):</p>

    <p>
      <strong>{{ $task->title }}</strong><br>
      {{ $task->description ?? 'No description provided.' }}
    </p>

    <p>
      <strong>Due:</strong> {{ \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') }}<br>
      <strong>Status:</strong> {{ ucfirst($task->status) }}
    </p>

    <p>
      If you’ve already completed this task, you can ignore this reminder.
    </p>

    <p>Thanks,<br/>{{ config('app.name') }}</p>
  </div>
</body>
</html>