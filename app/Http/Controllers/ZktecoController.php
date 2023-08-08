<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rats\Zkteco\Lib\ZKTeco;
use App\Models\ZktecoDevice;
use App\Models\Branches;
use Illuminate\Validation\Rule;


class ZktecoController extends Controller
{
    public function showDevices(){
        $devices = ZktecoDevice::leftjoin('branches','branches.id','=','zkteco_devices.branch_id')->get();
        return view('admin.showDevices',['devices' => $devices]);
    }

    public function createdevice(){
        return view('admin.addDevice',['branches'=>Branches::all()]);
    }

    public function storeDevice(Request $request){
        $request->validate([
            'ip' => ['required',Rule::unique('zkteco_devices')],
            'model_name' => ['required'],
            'branch_id' => ['required']
               ]);
        $device = new ZktecoDevice;
        $device->ip = $request->ip;
        $device->model_name = $request->model_name;
        $device->branch_id = $request->branch_id;
        $device->port = 4370;
        $device->status = 0;
        $device->save();

        return redirect()->route('showDevices');
    }
    public function connect($id){
        $device = ZktecoDevice::where('id',$id)->first();
        $zk = new ZKTeco($device->ip);
        if($zk->connect()){
            $device->status=1;
            $device->save();
            return redirect()->route('showDevices');
        }else{
            return redirect()->route('admin_home')->withFailure('unable to Connect Device');
        }
    }

    public function test($id){
       $device = ZktecoDevice::where('id',$id)->first();
       $zk = new ZKTeco($device->ip);
       if($zk->connect()){
        $zk->testVoice();
       }
       return redirect()->route('showDevices');
    }
}
