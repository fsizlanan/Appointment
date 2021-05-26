<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AppoIntment;
use App\Models\AppointmentNte;
use App\Models\WorkingHours;
use Illuminate\Http\Request;

class indexController extends Controller
{
    public function getWorkingHours($date = '')
    {
        $date = ($date == '') ? date('Y-m-d') : $date;
        $day = date('l', strtotime($date));
        $returnArray = [];
        $hours = WorkingHours::where('day', $day)->get();
        $returnArray['ferman'] = $date;
        foreach ($hours as $key => $value) {

            $control = AppoIntment::where('date', $date)
                ->where('workingHour', $value['id'])
                ->where(function ($control) {
                    $control->orWhere('isActive', APPOINTMENT_DEFAULT);
                    $control->orWhere('isActive', APPOINTMENT_SUCCESS);
                })
                ->count();

                $exp = explode('-',$value['hours']);
                $nowTime = date('H.i');

            $value['isActive'] = ($control == 0 and $exp[0] > $nowTime) ? true : false;
            $returnArray[] = $value;
        }
        return response()->json($returnArray);
    }

    public function appointmentStore(Request $request)
    {
        $returnArray = [];
        $returnArray['status'] = false;
        $all = $request->except('token');
        $control = AppoIntment::where('date', $all['date'])->where('workingHour', $all['workingHour'])->count();

        if ($control != 0) {
            $returnArray['message'] = "Bu Randevu Tarihi Doludur";
            return response()->json($returnArray);
        }

        $all['code'] = substr(md5(uniqid()), 0, 6); // uniqid php ye özgü random bir sayı elde etmek için kullanılan methods
        $create = AppoIntment::create($all);

        if ($create) {
            $returnArray['statur'] = true;
            $returnArray['message'] = 'Randevunuz Başarı ile Alındı';
        } else {
            $returnArray['message'] = 'Veri Eklenemedi, bizimle iletişime geçiniz';
        }
        return response()->json($returnArray);
    }

    public function getWorkingStore(Request $request)
    {
        $all = $request->except('token');
        WorkingHours::query()->truncate();
        foreach ($all as $k => $v) {
            foreach ($v as $key => $value) {
                WorkingHours::create([
                    'day' => $k,
                    'hours' => $value,
                ]);
            }
        }

        return response()->json($all);
    }

    public function getWorkingList()
    {
        $returnArray = [];
        $data = WorkingHours::all();

        foreach ($data as $key => $value) {
            $returnArray[$value['day']][] = $value['hours'];
        }

        return response()->json($returnArray);
    }

    public function appointmentDetail(Request $request){
        $returnArray = [];
        $returnArray['status'] = false;
        $all =  $request->except('token');
        $c = AppoIntment::where('code',$all['code'])->count();
        
        if($all['code']==""){
            $returnArray['message'] = "Lütfen kodu boş bırakmayınız";
            return response()->json($returnArray);
        }
        if($c == 0){
            $returnArray['message'] = 'Bu kod ile bulunan randevu bulunamadı';
            return response()->json($returnArray);
        }

        $info = AppoIntment::where('code',$all['code'])->get();
        $info[0]['working'] = WorkingHours::getString($info[0]['workingHour']);
        $info[0]['notification'] = ($info[0]['notificationType'] == NOTIFICATION_EMAİL) ? 'Email' : 'Sms';
        $returnArray['status'] = true;
        $returnArray['info'] = $info[0];
        $returnArray['note'] = AppointmentNte::where('appointmentId', $info[0]['id'])->get();
        return response()->json($returnArray);

    }
}
