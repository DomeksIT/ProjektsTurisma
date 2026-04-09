<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
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
// public function apply(Request $bookings, $id)
// {
// $bookings->validate([
// 'name' => ['required','string','min:3','max:30','regex:/^[A-Za-zĀ-ž\s]+$/u'],
// 'email' => 'required|email',
// 'phone' => ['required','regex:/^\+?[0-9]{8,15}$/']
// ]);
// $token = Str::random(40);
// $bookingsId = DB::table('bookings')->insertGetId([
// 'tour_id'=>$id,
// 'name'=>$bookings->name,
// 'email'=>$bookings->email,
// 'phone'=>$bookings->phone,
// 'status'=>'Jauns',
// 'token'=>$token,
// 'created_at'=>now(),
// 'updated_at'=>now()
// ]);
// DB::table('messages')->insert([
// 'request_id' => $bookingsId,
// 'email' => $bookings->email,
// 'message' => 'Gaidām jūsu jautājumu!',
// 'sender' => 'admin',
// 'type' => 'booking',
// 'created_at' => now(),
// 'updated_at' => now()
// ]);
// $link = url('/chat/' . $token);
// Mail::raw(
// "Jūsu pieteikums ir veiksmīgi saņemts!
// Mēs ar jums sazināsimies.
// Ja jums ir papildus jautājumi, izmantojiet čatu:
// $link",
// function ($message) use ($bookings) {
// $message->to($bookings->email)
// ->subject('Pieteikuma apstiprinājums');
// }
// );
// return redirect()->back()->with('success','Pieteikums veiksmīgi nosūtīts!');
// }
// public function apply(Request $bookings, $id)
// {
//     $bookings->validate([
//         'name' => ['required','string','min:3','max:30','regex:/^[A-Za-zĀ-ž\s]+$/u'],
//         'email' => 'required|email',
//         'phone' => ['required','regex:/^\+?[0-9]{8,15}$/']
//     ]);
//     $token = Str::random(40);
//     $bookingsId = DB::table('bookings')->insertGetId([
//         'tour_id' => $id,
//         'name' => $bookings->name,
//         'email' => $bookings->email,
//         'phone' => $bookings->phone,
//         'status' => 'Jauns',
//         'token' => $token,
//         'created_at' => now(),
//         'updated_at' => now()
//     ]);
//     $exists = DB::table('messages')
//         ->where('request_id', $bookingsId)
//         ->where('type', 'booking')
//         ->where('message', 'Gaidām jūsu jautājumu!')
//         ->exists();
//     if (!$exists) {
//         DB::table('messages')->insert([
//             'request_id' => $bookingsId,
//             'email' => $bookings->email,
//             'message' => 'Gaidām jūsu jautājumu!',
//             'sender' => 'admin',
//             'type' => 'booking',
//             'created_at' => now(),
//             'updated_at' => now()
//         ]);
//     }
//     $link = url('/chat/' . $token);
//     Mail::raw(
//         "Jūsu pieteikums ir veiksmīgi saņemts!
// Mēs ar jums sazināsimies.
// Ja jums ir papildus jautājumi, izmantojiet čatu:
// $link",
//         function ($message) use ($bookings) {
//             $message->to($bookings->email)
//                     ->subject('Pieteikuma apstiprinājums');
//         }
//     );
//     return redirect()->back()->with('success', 'Pieteikums veiksmīgi nosūtīts!');

// }

 public function apply(Request $bookings, $id)

{
    $bookings->validate([
        'name' => ['required','string','min:3','max:30','regex:/^[A-Za-zĀ-ž\s]+$/u'],
        'email' => 'required|email',
        'phone' => ['required','regex:/^\+?[0-9]{8,15}$/']

    ]);
    $token = Str::random(40);
    $bookingId = DB::table('bookings')->insertGetId([
        'tour_id' => $id,
        'name' => $bookings->name,
        'email' => $bookings->email,
        'phone' => $bookings->phone,
        'status' => 'Jauns',
        'token' => $token,
        'created_at' => now(),
        'updated_at' => now()

    ]);
    $exists = DB::table('messages')
        ->where('request_id', $bookingId)
        ->where('type', 'booking')
        ->where('message', 'Gaidām jūsu jautājumu!')
        ->exists();
    if (!$exists) {
        DB::table('messages')->insert([
            'request_id' => $bookingId,
            'email' => $bookings->email,
            'message' => 'Gaidām jūsu jautājumu!',
            'sender' => 'admin',
            'type' => 'booking',
            'created_at' => now(),
            'updated_at' => now()
        ]);

    }
    $link = url('/chat/' . $token);
    try {
        Mail::raw(
            "Jūsu pieteikums ir veiksmīgi saņemts!
Mēs ar jums sazināsimies.
Ja jums ir papildu jautājumi, izmantojiet čatu:
$link",
            function ($message) use ($bookings) {
                $message->to($bookings->email)
                    ->subject('Pieteikuma apstiprinājums');
            }
        );
    } catch (\Exception $e) {
        \Log::error('Mail error: ' . $e->getMessage());
    }
    return back()->with('success', 'Pieteikums veiksmīgi nosūtīts!');
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
public function requestDone($id)
{
DB::table('requests')
->where('id',$id)
->update(['status'=>'done']);
return redirect('/admin/bookings');
}
public function requestCancel($id)
{
   DB::table('requests')
       ->where('id', $id)
       ->update(['status' => 'canceled']);
   return redirect('/admin/bookings');
}

public function request(Request $request)

{

    $request->validate([
        'name' => ['required','min:3','max:50','regex:/^[A-Za-zĀ-ž\s]+$/u'],
        'phone' => ['required','regex:/^\+?[0-9]{8,15}$/'],
        'email' => 'required|email',
        'destination' => ['required','min:2'],
        'description' => ['required','min:5','max:400'],
        'dates' => ['required']
    ]);
    $token = Str::random(40);
    $requestId = DB::table('requests')->insertGetId([
        'name' => $request->name,
        'phone' => $request->phone,
        'email' => $request->email,
        'destination' => $request->destination,
        'description' => $request->description,
        'dates' => $request->dates,
        'status' => 'Jauns',
        'token' => $token,
        'created_at' => now(),
        'updated_at' => now()
    ]);
    $exists = DB::table('messages')
        ->where('request_id', $requestId)
        ->where('type', 'request')
        ->where('message', 'Gaidām jūsu jautājumu!')
        ->exists();
    if (!$exists) {
        DB::table('messages')->insert([
            'request_id' => $requestId,
            'email' => $request->email,
        'message' => 'Gaidām jūsu jautājumu!',
            'sender' => 'admin',
            'type' => 'request',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
    $link = url('/chat/' . $token);
    Mail::raw(
        "Jūsu pieprasījums ir veiksmīgi saņemts!
Mēs ar jums sazināsimies.
Ja jums ir papildu jautājumi, izmantojiet čatu:
$link",
        function ($message) use ($request) {
            $message->to($request->email)
                ->subject('Pieteikuma apstiprinājums');
        }
    );
    return back()->with('success', 'Pieprasījums veiksmīgi nosūtīts!');
}
 
// public function request(Request $request)
// {
// $request->validate([
// 'name' => ['required','min:3','max:50','regex:/^[A-Za-zĀ-ž\s]+$/u'],
// 'phone' => ['required','regex:/^\+?[0-9]{8,15}$/'],
// 'email' => 'required|email',
// 'destination' => ['required','min:2'],
// 'description' => ['required','min:5', 'max:400'],
// 'dates' => ['required']
// ]);
// $token = Str::random(40);
// $requestId = DB::table('requests')->insertGetId([
// 'name' => $request->name,
// 'phone' => $request->phone,
// 'email'=> $request->email,
// 'destination' => $request->destination,
// 'description' => $request->description,
// 'dates' => $request->dates,
// 'status' => 'Jauns',
// 'token'=> $token,
// 'created_at' => now(),
// 'updated_at' => now()
// ]);
// DB::table('messages')->insert([
// 'request_id' => $requestId,
// 'email' => $request->email,
// 'message' => 'Gaidām jūsu jautājumu!',
// 'sender' => 'admin',
// 'type' => 'request',
// 'created_at' => now(),
// 'updated_at' => now()
// ]);
// $link = url('/chat/' . $token);
// Mail::raw(
// "Jūsu pieprasījums ir veiksmīgi saņemts!
// Mēs ar jums sazināsimies.
// Ja jums ir papildus jautājumi, izmantojiet čatu:
// $link",
// function ($message) use ($request) {
// $message->to($request->email)
// ->subject('Pieteikuma apstiprinājums');
// }
// );
// return back()->with('success','Pieprasījums veiksmīgi nosūtīts!');
// }
public function clientChat($token)
{

   $request = DB::table('requests')->where('token', $token)->first();
   if ($request) {
       $messages = DB::table('messages')
           ->where('request_id', $request->id)
           ->where('type', 'request') 
           ->orderBy('created_at')
           ->get();
       return view('chat.client', [
           'messages' => $messages,
           'requestData' => $request,
           'type' => 'request'
       ]);
   }
  
   $booking = DB::table('bookings')->where('token', $token)->first();
   if ($booking) {
       $messages = DB::table('messages')
           ->where('request_id', $booking->id)
           ->where('type', 'booking') 
           ->orderBy('created_at')
           ->get();
       return view('chat.client', [
           'messages' => $messages,
           'requestData' => $booking,
           'type' => 'booking'
       ]);
   }
   abort(404);
}
// public function clientChat($token)
// {
//    $request = DB::table('requests')->where('token', $token)->first();
//    if ($request) {
//        $messages = DB::table('messages')
//            ->where('request_id', $request->id)
//            ->where('type','!=','email')
//            ->orderBy('created_at')
//            ->get();
//        return view('chat.client', [
//            'messages' => $messages,
//            'requestData' => $request
//        ]);
//    }
//    $booking = DB::table('bookings')->where('token', $token)->first();
//    if ($booking) {
//        $messages = DB::table('messages')
//            ->where('request_id', $booking->id)
//            ->where('type','!=','email')
//            ->orderBy('created_at')
//            ->get();
//        return view('chat.client', [
//            'messages' => $messages,
//            'requestData' => $booking
//        ]);
//    }
//    return view('chat.client', [
//        'messages' => [],
//        'requestData' => null
//    ]);
// }
// public function clientSend(Request $req, $token)
// {
//    $request = DB::table('requests')->where('token', $token)->first();
//    if ($request) {
//        DB::table('messages')->insert([
//            'request_id' => $request->id,
//            'email' => $request->email,
//            'message' => $req->message,
//            'sender' => 'client',
//            'type' => 'chat', 
//            'is_read' => 0,
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//        return back();
//    }
//    $booking = DB::table('bookings')->where('token', $token)->first();
//    if ($booking) {
//        DB::table('messages')->insert([
//            'request_id' => $booking->id,
//            'email' => $booking->email,
//            'message' => $req->message,
//            'sender' => 'client',
//            'type' => 'chat', 
//            'is_read' => 0,
//            'created_at' => now(),
//            'updated_at' => now()
//        ]);
//    }
//    return back();
// }
public function clientSend(Request $req, $token)
{
   // request
   $request = DB::table('requests')->where('token', $token)->first();
   if ($request) {
       DB::table('messages')->insert([
           'request_id' => $request->id,
           'email' => $request->email,
           'message' => $req->message,
           'sender' => 'client',
           'type' => 'request', 
           'created_at' => now(),
           'updated_at' => now()
       ]);
       return back();
   }
   // booking
   $booking = DB::table('bookings')->where('token', $token)->first();
   if ($booking) {
       DB::table('messages')->insert([
           'request_id' => $booking->id,
           'email' => $booking->email,
           'message' => $req->message,
           'sender' => 'client',
           'type' => 'booking',
           'created_at' => now(),
           'updated_at' => now()
       ]);
       return back();
   }
   abort(404);
}
}
