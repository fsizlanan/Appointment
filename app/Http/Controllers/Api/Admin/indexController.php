<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppoIntment;
use App\Models\AppointmentNte;
use App\Models\WorkingHours;
use Illuminate\Http\Request;


class indexController extends Controller
{
    public function detailStore(Request $request)
    {
        $returnArray = [];
        $all = $request->except('token');
        $create = AppointmentNte::create([
            'appointmentId' => $all['id'],
            'text' => $all['text']

        ]);
        if ($create) {
            $returnArray['status'] = true;
        } else {
            $returnArray['status'] = false;
        }

        return response()->json($returnArray);
    }
    public function detail($id)
    {
        $returnArray = [];
        $data = AppoIntment::where('id', $id)->get();
        $data[0]['working'] = WorkingHours::getString($data[0]['workingHour']);
        $data[0]['notification'] = ($data[0]['notificationType'] == NOTIFICATION_EMAİL) ? 'Email' : 'Sms';
        $returnArray['data'] = $data[0];
        $returnArray['comment']=AppointmentNte::where('appointmentId',$id)->orderBy('id','desc')->get();

        return response()->json($returnArray);
    }
    public function all()
    {
        $returnArray = [];

        // Waiting
        $returnArray['waiting'] = AppoIntment::where('isActive', 0)->orderBy('workingHour', 'asc')->paginate(9);
        $returnArray['waiting']->getCollection()->transform(function ($value) {
            $value['working'] = WorkingHours::getString($value['workingHour']);
            return $value;
        });

        //Cancel
        $returnArray['cancel'] = AppoIntment::where('isActive', 2)->orderBy('workingHour', 'asc')->paginate(9);
        $returnArray['cancel']->getCollection()->transform(function ($value) {
            $value['working'] = WorkingHours::getString($value['workingHour']);
            return $value;
        });

        //List
        $returnArray['list'] = AppoIntment::where('isActive', 1)->where('date', '>', date('Y-m-d'))->orderBy('workingHour', 'asc')->paginate(9);
        $returnArray['list']->getCollection()->transform(function ($value) {
            $value['working'] = WorkingHours::getString($value['workingHour']);
            return $value;
        });

        //Last List
        $returnArray['last_list'] = AppoIntment::where('date', '<', date('Y-m-d'))->orderBy('workingHour', 'asc')->paginate(9);
        $returnArray['last_list']->getCollection()->transform(function ($value) {
            $value['working'] = WorkingHours::getString($value['workingHour']);
            return $value;
        });

        //Today List
        $returnArray['today_list'] = AppoIntment::where('isActive', 1)->where('date', date('Y-m-d'))->orderBy('workingHour', 'asc')->paginate(9);
        $returnArray['today_list']->getCollection()->transform(function ($value) {
            $value['working'] = WorkingHours::getString($value['workingHour']);
            return $value;
        });

        return response()->json($returnArray);
    }

    public function process(Request $request)
    {
        $all = $request->except('token');
        AppoIntment::where('id', $all['id'])->update(['isActive' => $all['type']]);
        return response()->json(['status' => true]);
    }

    public function getWaitingList()
    {
        $data = AppoIntment::where('isActive', 0)->orderBy('workingHour', 'asc')->paginate(9);

        $data->getCollection()->transform(function ($value) {
            $value['working'] = WorkingHours::getString($value['workingHour']);

            return $value;
        });

        return response()->json($data);
    }

    public function getCancelList()
    {
        $data = AppoIntment::where('isActive', 2)->orderBy('workingHour', 'asc')->paginate(9);

        $data->getCollection()->transform(function ($value) {
            $value['working'] = WorkingHours::getString($value['workingHour']);

            return $value;
        });

        return response()->json($data);
    }

    public function getList()
    {
        $data = AppoIntment::where('isActive', 1)->where('date', '>', date('Y-m-d'))->orderBy('workingHour', 'asc')->paginate(9);

        $data->getCollection()->transform(function ($value) {
            $value['working'] = WorkingHours::getString($value['workingHour']);

            return $value;
        });

        return response()->json($data);
    }

    public function getLastList()
    {
        $data = AppoIntment::where('date', '<', date('Y-m-d'))->orderBy('workingHour', 'asc')->paginate(9);

        $data->getCollection()->transform(function ($value) {
            $value['working'] = WorkingHours::getString($value['workingHour']);

            return $value;
        });

        return response()->json($data);
    }

    public function getTodayList()
    {
        $data = AppoIntment::where('isActive', 1)->where('date', date('Y-m-d'))->orderBy('workingHour', 'asc')->paginate(9);

        $data->getCollection()->transform(function ($value) {
            $value['working'] = WorkingHours::getString($value['workingHour']);

            return $value;
        });

        return response()->json($data);
    }
}
