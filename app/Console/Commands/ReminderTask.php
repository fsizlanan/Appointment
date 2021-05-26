<?php

namespace App\Console\Commands;

use tidy;
use App\Models\AppoIntment;
use App\Models\WorkingHours;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ReminderTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Reminder:Start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $date = date('Y-m-d');
        $nextDate = date('Y-m-d', strtotime("+1 day", time()));
        $list = AppoIntment::whereIn('date', [$date, $nextDate])
            ->where('isActive', APPOINTMENT_SUCCESS)
            ->where('isSend', REMINDER_DEFAULT)
            ->get();

        foreach ($list as $key => $value) {
            if ($value['notificationType'] == NOTIFICATION_EMAİL) {
                $data = [
                    'name' => $value['fullName'],
                    'email' => $value['email'],
                    'date' => $value['date'],
                    'time' => WorkingHours::getString($value['workingHour']),
                    'code' => $value['code']
                ];
                try {
                    Mail::send('email', $data, function ($message) use ($data) {
                        $message->to($data['email'], $data['name'])
                            ->subject('Randevu Hatırlatma');
                        $message->from('developerferman@gmail.com', 'Developer Ferman');
                    });
                    AppoIntment::where('id', $value['id'])->update(['isSend' => REMINDER_SUCCESS]);
                } catch (\Throwable $th) {
                }
            }
            // if($value['notificationType' == NOTIFICATION_SMS]) {

            // }
        }

        dd($list);
        return 0;
    }
}
