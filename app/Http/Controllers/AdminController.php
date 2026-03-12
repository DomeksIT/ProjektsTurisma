<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{

public function login()
{
    return view('admin.login');
}

public function auth(Request $request)
{
    if($request->username=="admin" && $request->password=="1234"){
        return redirect('/admin/bookings');
    }

    return back()->with('error','Nepareizs lietotājvārds vai parole');
}

public function tours()
{
    $tours = DB::table('tours')->get();
    return view('admin.tours', compact('tours'));
}

public function createTour()
{
    return view('admin.create-tour');
}

public function storeTour(Request $request)
{

    $request->validate([
        'title'=>'required',
        'price'=>'required|numeric',
        'start_date'=>'required',
        'end_date'=>'required',
        'description'=>'required',
        'image'=>'required|image'
    ]);

    $path = $request->file('image')->store('tours','public');

    DB::table('tours')->insert([
        'title'=>$request->title,
        'price'=>$request->price,
        'currency'=>'EUR',
        'start_date'=>$request->start_date,
        'end_date'=>$request->end_date,
        'description'=>$request->description,
        'image'=>$path
    ]);

    return redirect('/admin/tours');
}

public function editTour($id)
{
    $tour = DB::table('tours')->where('id',$id)->first();

    return view('admin.edit-tour',compact('tour'));
}

public function updateTour(Request $request,$id)
{

    $data = [
        'title'=>$request->title,
        'price'=>$request->price,
        'start_date'=>$request->start_date,
        'end_date'=>$request->end_date,
        'description'=>$request->description
    ];

    if($request->hasFile('image')){
        $path = $request->file('image')->store('tours','public');
        $data['image']=$path;
    }

    DB::table('tours')->where('id',$id)->update($data);

    return redirect('/admin/tours');
}

public function deleteTour($id)
{
    DB::table('tours')->where('id',$id)->delete();

    return redirect('/admin/tours');
}

}