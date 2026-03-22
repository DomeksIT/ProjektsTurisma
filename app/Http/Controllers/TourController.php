<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Tour;

class TourController extends Controller
{
public function index()
{
$tours = DB::table('tours')
->leftJoin('categories','tours.category_id','=','categories.id')
->select('tours.*','categories.name as category')
->paginate(10);
return view('tours.index',[
'tours' => $tours
]);

}
public function show($id)
{
$tour = DB::table('tours')
->leftJoin('categories','tours.category_id','=','categories.id')
->select('tours.*','categories.name as category')
->where('tours.id',$id)
->first();
return view('tours.show',[
'tour'=>$tour
]);
}
public function apply(Request $request, $id)
{
   $request->validate([
       'name' => ['required','min:3','regex:/^[A-Za-zĀ-ž\s]+$/u'],
       'email' => 'required|email',
       'phone' => ['required','regex:/^\+?[0-9]{8,15}$/']
   ], [
       'name.required' => 'Ievadiet vārdu un uzvārdu',
       'name.min' => 'Vārdam jābūt vismaz 3 simboliem',
       'name.regex' => 'Vārdā drīkst būt tikai burti',
       'email.required' => 'Ievadiet e-pastu',
       'email.email' => 'Nepareizs e-pasts',
       'phone.required' => 'Ievadiet telefonu',
       'phone.regex' => 'Ievadiet derīgu telefona numuru (8-15 cipari)'
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
   return back()->with('ok','Pieteikums veiksmīgi nosūtīts!');
}
public function bookings()
{
   $bookings = DB::table('bookings')
       ->join('tours', 'bookings.tour_id', '=', 'tours.id')
       ->select('bookings.*', 'tours.title as tour_title')
       ->orderBy('bookings.created_at', 'desc')
       ->get();
   $requests = DB::table('requests')
       ->orderBy('created_at', 'desc')
       ->get();
   return view('admin.bookings', [
       'bookings' => $bookings,
       'requests' => $requests
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
public function request(Request $request)
{
   $request->validate([
       'name' => ['required','min:3','regex:/^[A-Za-zĀ-ž\s]+$/u'],
       'destination' => ['required','min:2'],
       'description' => ['required','min:5'],
       'dates' => ['required'],
       'phone' => ['required','regex:/^\+?[0-9\s\-\(\)]{8,20}$/']
   ],[
       'name.required' => 'Ievadiet vārdu un uzvārdu',
       'name.min' => 'Vārdam jābūt vismaz 3 simboliem',
       'name.regex' => 'Drīkst izmantot tikai burtus',
       'destination.required' => 'Ievadiet galamērķi',
       'description.required' => 'Ievadiet aprakstu',
       'description.min' => 'Aprakstam jābūt vismaz 5 simboliem',
       'dates.required' => 'Izvēlieties datumus',
       'phone.required' => 'Ievadiet telefona numuru',
       'phone.regex' => 'Var izmantot +, ciparus un atstarpes (8-20 simboli)'
   ]);
   DB::table('requests')->insert([
       'name' => $request->name,
       'destination' => $request->destination,
       'description' => $request->description,
       'dates' => $request->dates,
       'phone' => $request->phone,
       'status' => 'Jauns',
       'created_at' => now(),
       'updated_at' => now()
   ]);
   return back()->with('success', 'Pieprasījums nosūtīts!');
}
public function requestDone($id)
{
   DB::table('requests')
       ->where('id', $id)
       ->update(['status' => 'done']);
   return back();
}
public function requestCancel($id)
{
   DB::table('requests')
       ->where('id', $id)
       ->update(['status' => 'canceled']);
   return back();
}
}
