<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReminderBooking;

class SendBookingReminder extends Command
{
    protected $signature = 'reminder:booking';
    protected $description = 'Kirim reminder booking H-1';

    public function handle()
    {
        $besok = Carbon::now()->addDay()->toDateString();

        $bookings = Booking::whereDate('tglcekin', $besok)
            ->whereIn('status', ['booking', 'terbooking'])
            ->get();

        foreach ($bookings as $booking) {
            Mail::to($booking->customer->email)
                ->send(new ReminderBooking($booking));

            $this->info('Reminder dikirim ke: ' . $booking->customer->email);
        }
    }
}
