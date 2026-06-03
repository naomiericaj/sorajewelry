<?php

namespace App\Console\Commands;

use App\Mail\EventNotificationMail;
use App\Models\Event;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendEventNotifications extends Command
{
    protected $signature = 'events:send-notifications';

    protected $description = 'Send scheduled event notifications to customers';

    public function handle()
    {
        $events = Event::where('is_active', true)
            ->where('email_sent', false)
            ->where('start_date', '<=', now())
            ->get();

        foreach ($events as $event) {

            $users = User::where('role', 'customer')->get();

            foreach ($users as $user) {

                Mail::to($user->email)
                    ->send(new EventNotificationMail($event));

                $this->info("Email sent to {$user->email}");
            }

            $event->update([
                'email_sent' => true
            ]);

            $this->info("Event {$event->title} completed");
        }

        return Command::SUCCESS;
    }
}