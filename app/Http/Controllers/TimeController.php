<?php

namespace App\Http\Controllers;

use App\Models\Time;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TimeController extends Controller
{
    //
    public function index() {
        $time = Time::latest()->paginate(10);
        return view('admin.datapromo', compact('time'));
    }

    public function create() {
        return view('admin.createpromo');
    }

    public function store(Request $request) {
        $request->validate([
            'content'=> 'required',
            'promotitle'=> 'required',
            'images'=> 'required',
            'starttime'=> 'required',
            'endtime'=> 'required',
            'tiktok'=> 'required',
        ]);

        $images = $request->file('images');
        $imageName = $images->hashName();

        $images->storeAs('public/file', $imageName);

        Time::create([
            'content' => $request->content,
            'promotitle' => $request->promotitle,
            'images' => $imageName, 
            'starttime' => $request->starttime,
            'endtime' => $request->endtime,
            'tiktok' => $request->tiktok,
        ]);

        return redirect()->route('time.index');
    }

    public function edit(string $id)
    {
        $time = Time::findOrFail($id);
        return view('admin.editpromo', compact('time'));
    }

    public function update(Request $request, $id)
    {
        //
         $this->validate($request,[
            'content'=> 'required',
            'promotitle'=> 'required',
            'images'=> 'required',
            'starttime'=> 'required',
            'endtime'=> 'required',
            'tiktok'=> 'required',
        ]);

        $time = Time::findOrFail($id);

        if($request->hasFile('images')) {

        $images = $request->file('images');
        $images->storeAs('public/file', $images->hashName());
        $imageName = $images->hashName();


        $time->update([
            'content' => $request->content,
            'promotitle' => $request->promotitle,
            'images' => $images->hashName(), 
            'starttime' => $request->starttime,
            'endtime' => $request->endtime,
            'tiktok' => $request->tiktok,
        ]);
    } else {
        $time->update([
            'content' => $request->content,
            'promotitle' => $request->promotitle,
            'starttime' => $request->starttime,
            'endtime' => $request->endtime,
            'tiktok' => $request->tiktok,
        ]);
    }
    return redirect()->route('time.index')->with(['success' => 'Data Berhasil Diubah!']);
        
    }

   public function destroy(Time $time)
    {
        Storage::delete('public/file/' . $time->images);
        $time->delete();
        
        return redirect()->route('time.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }

    public function data() {
    $promo = Time::latest()->get();
     
    return view('index', compact('promo'));
    }

    public function editTiktok(string $id)
    {
        $time = Time::findOrFail($id);
        return view('admin.editTiktok', compact('time'));
    }

    public function updateTiktok(Request $request, $id)
    {
        $this->validate($request, [
            'tiktok' => 'required',
        ]);

        $time = Time::findOrFail($id);
        $time->update([
            'tiktok' => $request->tiktok,
        ]);

        return redirect()->route('time.index')->with(['success' => 'Tiktok Link Berhasil Diubah!']);
    }

}