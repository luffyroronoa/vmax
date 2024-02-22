<?php

namespace App\Http\Controllers;

use App\Models\Time;
use App\Models\Register;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    //
    public function index() {
   $promos = Time::all();

    return view('index', ['promos' => $promos]);
    }



    public function data() {
        $data = Register::latest()->paginate(20);
        return view('admin.datacs', compact('data'))->with('i', (request()->input('page', 1) - 1) * 20);
    }



    public function store(Request $request)
    {
    $request->validate([
        'name' => 'required',
        'wanumber' => 'required',
    ]);

    Register::create($request->all());

    // Redirect to a different route after saving the data
   return redirect()->route('register.index')->with(['success' => 'Anda Telah Berhasil Register! ']);

    }


    public function update(Request $request, Register $register) {
        // $request->validate([
        //     'name'=>'required',
        //     'wanumber'=>'required'
        // ]);
        // $register->update($request->all());
        // return redirect()->route('register.data')->with('success');

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'wanumber' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $register->update([
            'name' => $request->name,
            'wanumber' => $request->wanumber
        ]);

        return response()->json([
            'success' => true,
            'massage' => 'Data Berhasil Edit',
            'data' => $register
        ]);
    }

    public function destroy ( Register $register) {
        $register->delete();
        return redirect()->route('register.data')->with('success','Product updated successfully');
    }


}