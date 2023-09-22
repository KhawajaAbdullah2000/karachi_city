<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rats\Zkteco\Lib\ZKTeco;
use App\Models\ZktecoDevice;
use App\Models\Branches;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Validation\Rule;


class ZktecoController extends Controller
{
    public function showDevices(){
        $devices = ZktecoDevice::leftjoin('branches','branches.id','=','zkteco_devices.branch_id')->get();
        return view('admin.showDevices',['devices' => $devices]);
    }
    public function manshowDevice($id){
        $device = ZktecoDevice::leftjoin('branches','branches.id','=','zkteco_devices.branch_id')->where('branch_id',$id)->first();
        return view('emp.manager_devices',['device'=>$device]);
    }


    public function createdevice(){
        return view('emp.addDevice',['branches'=>Branches::all()]);
    }

    public function storeDevice(Request $request,$b_id){
        $request->validate([
            'ip' => ['required',Rule::unique('zkteco_devices')],
            'model_name' => ['required']
               ]);
        $device = new ZktecoDevice;
        $device->ip = $request->ip;
        $device->model_name = $request->model_name;
        $device->branch_id = $b_id;
        $device->port = 4370;
        $device->status = 0;
        $device->save();

        return redirect()->route('emp.showDevices',['id'=>$b_id]);
    }
    public function connect($id){
        $device = ZktecoDevice::where('id',$id)->first();
        $zk = new ZKTeco($device->ip);
        if($zk->connect()){
            $device->status=1;
            $device->save();
            return redirect()->route('emp.showDevices',['id'=>$device->branch_id]);
        }else{
            return redirect()->route('emp.showDevices')->withFailure('unable to Connect Device');
        }
    }
    public function disconnect($id){
        $device = ZktecoDevice::where('id',$id)->first();
        $zk = new ZKTeco($device->ip);
        $zk->connect();
        if($zk->disconnect()){
            $device->status=0;
            $device->save();
            return redirect()->route('emp.showDevices',['id'=>$device->branch_id]);
        }
    }
    
    public function addStudents($id){
       $device = ZktecoDevice::where('id',$id)->first();
       $zk = new ZKTeco($device->ip);
       $zk->connect();
       $deviceUsers = collect($zk->getUser())->pluck('uid');

       $students = Student::select('id','first_name')->whereNotIn('id',$deviceUsers)->where('admission',1)->get();
       
       foreach($students as $student) {
           $zk->setUser($student->id, $student->id, $student->first_name, '', '0', '0');
       }
       //flash()->success('Success', 'All enrolled students added to Biometric device successfully! please set fingerprint on device');

       return redirect()->route('emp.showDevices',['id'=>$device->branch_id])->withSuccess('All enrolled students added to Biometric device successfully! please set fingerprint on device');

    }

    public function addAttendanceLogs($id){
        $device = ZktecoDevice::where('id',$id)->first();
        $zk = new ZKTeco($device->ip);
        $date = now()->format('Y-m-d');
        $zk->connect();
        $data = $zk->getAttendance();
        foreach($data as $key=>$value){
            if($value['type']==0){
                if($student = Student::where('id',$value['id'])->first()){
                    if($date==date('Y-m-d', strtotime($value['timestamp']))){#only putting the same days attendance data inside the database
                        $entry = Attendance::where('Attendance_date',date('Y-m-d', strtotime($value['timestamp'])))
                        ->where('student_id',$value['id'])
                        ->first();
                        if(!isset($entry)){#checking to see if student hasnt already marked his attendance for the day
                            $attendance = new Attendance;
                            $attendance->student_id = $value['id'];
                            $attendance->Attendance_date=date('Y-m-d', strtotime($value['timestamp']));
                            $attendance->Attendance_time=date('H:i:s', strtotime($value['timestamp']));
                            $attendance->type = $value['type'];
                            $attendance->status=$value['state'];
                            $attendance->branch_id=$device->branch_id;
                            $attendance->save();
                        }elseif($entry->Attendance_time < date('H:i:s', strtotime($value['timestamp']))){
                            $attendance = new Attendance;
                            $attendance->student_id = $value['id'];
                            $attendance->Attendance_date=date('Y-m-d', strtotime($value['timestamp']));
                            $attendance->Attendance_time=date('H:i:s', strtotime($value['timestamp']));
                            $attendance->type = $value['type'];
                            $attendance->status=$value['state'];
                            $attendance->branch_id=$device->branch_id;
                            $attendance->checked_in=0;
                            $attendance->save();
                        }
                    }
                }
            }
        }
        
        return redirect()->route('emp.showDevices',["id"=>$device->branch_id])->withSuccess("Attendance Log Updated SuccessFully");
    
    }

    public function test($id){
       $device = ZktecoDevice::where('id',$id)->first();
       $zk = new ZKTeco($device->ip);
       if($zk->connect()){
        $zk->testVoice();
       }
       return redirect()->route('emp.showDevices',['id'=>$device->branch_id]);
    }
}
