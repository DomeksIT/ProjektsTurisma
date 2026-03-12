<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Tour;

class TourController extends Controller
{

public function index()
{
$tours = Tour::all();
return view('tours.index', [
'tours' => $tours
]);
}

public function show($id)
{
$tour = Tour::findOrFail($id);

return view('tours.show', [
'tour'=> $tour
]);
}

public function apply(Request $request, $id)
{

$request->validate([
'name'=>'required|min:3',
'email'=>'required|email',
'phone'=>'required'
]);

DB::table('bookings')->insert([
'tour_id'=>$id,
'name'=>$request->name,
'email'=>$request->email,
'phone'=>$request->phone,
'status'=>'Jauns',
'created_at'=>now(),
'updated_at'=>now()
]);

return redirect('/tours')
->with('success','Pieteikums veiksmīgi nosūtīts!');

}

public function bookings()
{

$bookings = DB::table('bookings')
->join('tours', 'bookings.tour_id', '=', 'tours.id')
->select('bookings.*', 'tours.title as tour_title')
->orderBy('bookings.created_at', 'desc')
->get();

return view('admin.bookings', [
'bookings'=>$bookings
]);

}

public function done($id)
{
DB::table('bookings')
->where('id',$id)
->update(['status'=>'done']);

return redirect('/admin/bookings');
}

public function cancel($id)
{
DB::table('bookings')
->where('id',$id)
->update(['status'=>'canceled']);

return redirect('/admin/bookings');
}

}