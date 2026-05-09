<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\JpegEncoder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
class AdminController extends Controller
{
public function deleteBooking($id)
{
   DB::table('bookings')->where('id', $id)->delete();
   return redirect()->back();
}
public function deleteRequest($id)
{
   DB::table('requests')->where('id', $id)->delete();
   return redirect()->back();
}
public function login()
{
   return view('admin.login');
}

public function auth(Request $request)
{
   $credentials = [
       'email' => (string)$request->email,
       'password' => (string)$request->password,
   ];
   if (Auth::attempt($credentials)) {
       $user = Auth::user();
       if (!$user || !$user->is_admin) {
           Auth::logout();
           return back()->with('error', 'Nav admin!');
       }
       return redirect('/admin/bookings');
   }
   return back()->with('error', 'Nepareizs e-pasts vai parole!');
}

public function tours()
{
   $tours = DB::table('tours')
       ->leftJoin('categories','tours.category_id','=','categories.id')
       ->select('tours.*','categories.name as category')
       ->get();
   return view('admin.tours', compact('tours'));
}

public function createTour()
{
   $categories = DB::table('categories')->get();
   return view('admin.create-tour', compact('categories'));
}

public function storeTour(Request $request)
{
   $request->validate([
       'title'=>'required|max:50',
       'price'=>'required|numeric',
       'start_date'=>'required',
       'end_date'=>'required',
       'description'=>'required|max:50',
       'image'=>'required|image'
   ],
   [
   'title.required' => 'Nosaukums ir obligāts',
   'price.required' => 'Cena ir obligāta',
   'price.numeric' => 'Cena jābūt skaitlim',
   'start_date.required' => 'Sākuma datums ir obligāts',
   'end_date.required' => 'Beigu datums ir obligāts',
   'description.required' => 'Apraksts ir obligāts',
   'image.required' => 'Attēls ir obligāts',
   'image.image' => 'Fails jābūt attēlam'
]);
$path = null;
if ($request->hasFile('image')) {
$image = $request->file('image');
$filename = time() . '_' . Str::random(5) . '.' . $image->getClientOriginalExtension();
$path = $image->storeAs('tours', $filename, 'public');
$thumbPath = 'tours/thumbs/' . $filename;
$manager = new ImageManager(new Driver());
$img = $manager->read($image->getRealPath());
$img = $img->scale(width: 800);
Storage::disk('public')->put(
$thumbPath,
(string) $img->encode(new JpegEncoder(quality: 90))
);
}
   DB::table('tours')->insert([
       'title'=>$request->title,
       'price'=>$request->price,
       'currency'=>'EUR',
       'start_date'=>$request->start_date,
       'end_date'=>$request->end_date,
       'description'=>$request->description,
       'image'=>$path,
       'category_id'=>$request->category_id
   ]);
   return redirect('/admin/tours');
}

public function editTour($id)
{
   $tour = DB::table('tours')->where('id',$id)->first();
   $categories = DB::table('categories')->get();
   return view('admin.edit-tour', compact('tour','categories'));
}

public function updateTour(Request $request,$id)
{
   $request->validate([
       'title' => 'required|min:3',
       'price' => 'required|numeric',
       'start_date' => 'required',
       'end_date' => 'required',
       'description' => 'required|max:100',
       'category_id' => 'required'
   ],
   [
   'title.required' => 'Nosaukums ir obligāts',
   'price.required' => 'Cena ir obligāta',
   'price.numeric' => 'Cena jābūt skaitlim',
   'start_date.required' => 'Sākuma datums ir obligāts',
   'end_date.required' => 'Beigu datums ir obligāts',
   'description.required' => 'Apraksts ir obligāts',
   'image.required' => 'Attēls ir obligāts',
   'image.image' => 'Fails jābūt attēlam'
]);
   $data = [
       'title'=>$request->title,
       'price'=>$request->price,
       'start_date'=>$request->start_date,
       'end_date'=>$request->end_date,
       'description'=>$request->description,
       'category_id'=>$request->category_id
   ];
if ($request->hasFile('image')) {
$image = $request->file('image');
$filename = time() . '_' . Str::random(5) . '.' . $image->getClientOriginalExtension();
$path = $image->storeAs('tours', $filename, 'public');
$thumbPath = 'tours/thumbs/' . $filename;
$manager = new ImageManager(new Driver());
$img = $manager->read($image->getRealPath());
$img = $img->scale(width: 800);
Storage::disk('public')->put(
$thumbPath,
(string) $img->encode(new JpegEncoder(quality: 90))
);
$data['image'] = $path;
}
   DB::table('tours')->where('id',$id)->update($data);
   return redirect('/admin/tours');
}
public function deleteTour($id)
{
   DB::table('tours')->where('id',$id)->delete();
   return redirect('/admin/tours');
}
public function categories()
{
   $categories = DB::table('categories')->get();
   return view('admin.categories', compact('categories'));
}
public function createCategory()
{
   return view('admin.create-category');
}
public function deleteCategory($id)
{
   DB::table('categories')->where('id',$id)->delete();
   return redirect('/admin/categories');
}
public function editCategory($id)
{
   $category = DB::table('categories')->where('id',$id)->first();
   return view('admin.edit-category', compact('category'));
}
public function updateCategory(Request $request, $id)
{
   DB::table('categories')
       ->where('id',$id)
       ->update([
           'name' => $request->name
       ]);
   return redirect('/admin/categories');
}
public function storeCategory(Request $request)
{
   $request->validate([
       'name' => 'required'
   ]);
   DB::table('categories')->insert([
       'name' => $request->name
   ]);
   return redirect('/admin/categories');
}
public function chatByToken($value)
{
   $request = DB::table('requests')->where('token', $value)->first();
   if (!$request) {
       $request = DB::table('requests')->where('id', $value)->first();
   }
   if ($request) {
       $messages = DB::table('messages')
           ->where('request_id', $request->id)
            ->whereIn('type',['chat','request','booking'])
           ->orderBy('created_at')
           ->get();
       return view('admin.chat', compact('messages', 'request'));
   }
   return "Chat not found";
}
 
public function sendMessage(Request $req, $token)
{
   $requestData = DB::table('requests')->where('token', $token)->first();
   if (!$requestData) {
       $requestData = DB::table('bookings')->where('token', $token)->first();
   }
   if (!$requestData) {
       return back();
   }
   DB::table('messages')->insert([
       'request_id' => $requestData->id,
       'email' => $requestData->email,
       'message' => $req->message,
       'sender' => 'admin',
       'type' => 'chat',        
       'is_read' => 0,       
       'created_at' => now(),
       'updated_at' => now()
   ]);
   return back();
}
public function chats()
{
    $onlyUnread = request('unread');
    $requests = DB::table('requests')
        ->leftJoin('messages', function ($join) {
            $join->on('requests.id', '=', 'messages.request_id')
                 ->where('messages.type', 'request'); 
        })
        ->select(
            'requests.id',
            'requests.email',
            'requests.phone',
            'requests.destination',
            'requests.token',
            DB::raw("'Individuālais' as type"),
            DB::raw("COUNT(CASE
                WHEN messages.sender = 'client'
                AND messages.is_read = 0
                THEN 1 END) as unread")
        )
        ->groupBy(
            'requests.id',
            'requests.email',
            'requests.phone',
            'requests.destination',
            'requests.token'
        );
    $bookings = DB::table('bookings')
        ->join('tours', 'bookings.tour_id', '=', 'tours.id')
        ->leftJoin('messages', function ($join) {
            $join->on('bookings.id', '=', 'messages.request_id')
                 ->where('messages.type', 'booking'); 
        })
        ->select(
            'bookings.id',
            'bookings.email',
            'bookings.phone',
            'tours.title as destination',
            'bookings.token',
            DB::raw("'Rezervācija' as type"),
            DB::raw("COUNT(CASE
                WHEN messages.sender = 'client'
                AND messages.is_read = 0
                THEN 1 END) as unread")
        )
        ->groupBy(
            'bookings.id',
            'bookings.email',
            'bookings.phone',
            'tours.title',
            'bookings.token'
        );
    $chats = $requests->unionAll($bookings);
    $chats = DB::table(DB::raw("({$chats->toSql()}) as combined"))
        ->mergeBindings($chats)
        ->when($onlyUnread, function ($q) {
            $q->where('unread', '>', 0)
              ->orderByRaw('unread DESC');
        })
        ->orderBy('id', 'desc') 
        ->get();
    return view('admin.chats', compact('chats'));
}
 
// public function chats()
// {
//    $chats = DB::table('requests')
//        ->leftJoin('messages', 'requests.id', '=', 'messages.request_id')
//        ->select(
//            'requests.id',
//            'requests.email',
//            'requests.phone',
//            'requests.destination',
//            'requests.token',
//            DB::raw("'Individuālais' as type"),
//            DB::raw("COUNT(CASE WHEN messages.sender = 'client' AND messages.is_read = 0 THEN 1 END) as unread")
//        )
//        ->groupBy('requests.id', 'requests.email', 'requests.phone', 'requests.destination', 'requests.token')
//        ->union(
//            DB::table('bookings')
//                ->join('tours', 'bookings.tour_id', '=', 'tours.id')
//                ->leftJoin('messages', 'bookings.id', '=', 'messages.request_id')
//                ->select(
//                    'bookings.id',
//                    'bookings.email',
//                    'bookings.phone',
//                    'tours.title as destination',
//                    'bookings.token',
//                    DB::raw("'Saņemtais pieteikums' as type"),
//                    DB::raw("COUNT(CASE WHEN messages.sender = 'client' AND messages.is_read = 0 THEN 1 END) as unread")
//                )
//                ->groupBy('bookings.id', 'bookings.email', 'bookings.phone', 'tours.title', 'bookings.token')
//        )
//        ->get();
//    return view('admin.chats', compact('chats'));
// }

// public function liveChat($id)

// {
//     $request = DB::table('requests')->where('id', $id)->first();
//     if ($request) {
//         DB::table('messages')
//             ->where('request_id', $id)
//             ->where('type', 'request') 
//             ->where('sender', 'client')
//             ->update(['is_read' => 1]);
//         $messages = DB::table('messages')
//             ->where('request_id', $id)
//             ->where('type', 'request')
//             ->orderBy('created_at')
//             ->get();
//         return view('admin.livechat', [
//             'messages' => $messages,
//             'request' => $request
//         ]);
//     }
//     $booking = DB::table('bookings')->where('id', $id)->first();
//     if ($booking) {
//         DB::table('messages')
//             ->where('request_id', $id)
//             ->where('type', 'booking') 
//             ->where('sender', 'client')
//             ->update(['is_read' => 1]);
//         $messages = DB::table('messages')
//             ->where('request_id', $id)
//             ->where('type', 'booking') 
//             ->orderBy('created_at')
//             ->get();
//         return view('admin.livechat', [
//             'messages' => $messages,
//             'request' => $booking
//         ]);
//     }
//     abort(404);
// }
public function liveChat($type, $id)
{
   if ($type == 'request') {
       $data = DB::table('requests')->where('id', $id)->first();
   } else {
       $data = DB::table('bookings')->where('id', $id)->first();
   }
   DB::table('messages')
       ->where('request_id', $id)
       ->where('type', $type)
       ->where('sender', 'client')
       ->update(['is_read' => 1]);
   $messages = DB::table('messages')
       ->where('request_id', $id)
       ->where('type', $type)
       ->orderBy('created_at')
       ->get();
   return view('admin.livechat', [
       'messages' => $messages,
       'data' => $data,
       'type' => $type
   ]);
}
 
// public function liveChat($id)
// {
// $request = DB::table('requests')->where('id', $id)->first();

// if ($request) {
// DB::table('messages')
// ->where('request_id', $id)
// ->where('sender', 'client')
// ->update(['is_read' => 1]);
// $messages = DB::table('messages')
// ->where('request_id', $id)
// ->whereIn('type', ['chat', 'request', 'booking']) 
// ->orderBy('created_at')
// ->get();
// return view('admin.livechat', compact('messages', 'request'));
// }
// $booking = DB::table('bookings')->where('id', $id)->first();
// if ($booking) {
// DB::table('messages')
// ->where('request_id', $id)
// ->where('sender', 'client')
// ->update(['is_read' => 1]);
// $messages = DB::table('messages')
// ->where('request_id', $id)
// ->where('type', 'booking')
// ->whereIn('type', ['chat', 'request', 'booking']) 
// ->orderBy('created_at')
// ->get();
// return view('admin.livechat', [
// 'messages' => $messages,
// 'request' => $booking
// ]);
// }
// return "Chat not found";
// }
 

public function email($token)
{
   $data = DB::table('requests')->where('token', $token)->first();
   if (!$data) {
       $data = DB::table('bookings')->where('token', $token)->first();
   }
   if (!$data) {
       return "Not found";
   }
   $type = isset($data->tour_id) ? 'booking_email' : 'request_email';
   $messages = DB::table('messages')
       ->where('request_id', $data->id)
       ->where('type', $type)
       ->where('sender', 'admin')
       ->orderBy('created_at')
       ->get();
   return view('admin.email', [
       'data' => $data,
       'messages' => $messages
   ]);
}

public function sendEmail(Request $req, $token)
{
    $req->validate([
        'message' => 'required',
        'file' => 'nullable|mimes:pdf,doc,docx|max:2048'
    ]);
    $data = DB::table('requests')->where('token', $token)->first();
    if (!$data) {
        $data = DB::table('bookings')->where('token', $token)->first();
    }
    if (!$data) {
        return back();
    }
    $filePath = null;
    if ($req->hasFile('file')) {
        $filePath = $req->file('file')->store('uploads', 'public');
    }
    Mail::send([], [], function ($message) use ($data, $req, $filePath) {
        $message->to($data->email)
                ->subject('Atbilde no administrācijas')
                ->setBody($req->message);
        if ($filePath) {
       $message->attach(storage_path('app/public/' . $filePath));
     }
    });
    $type = isset($data->tour_id) ? 'booking_email' : 'request_email';
    DB::table('messages')->insert([
        'request_id' => $data->id,
        'email' => $data->email,
        'message' => $req->message,
        'file' => $filePath, 
        'sender' => 'admin',
        'type' => $type,
        'created_at' => now(),
    'updated_at' => now()
    ]);
    return back()->with('success', 'Nosūtīts!');
}
 




//    $data = DB::table('requests')->where('token', $token)->first();
//    if (!$data) {
//        $data = DB::table('bookings')->where('token', $token)->first();
//    }
//    if (!$data) {
//        return back();
//    }
//    Mail::raw($req->message, function ($message) use ($data) {
//        $message->to($data->email)
//                ->subject('Atbilde no administrācijas');
//    });
//    DB::table('messages')->insert([
//        'request_id' => $data->id,
//        'email' => $data->email,
//        'message' => $req->message,
//        'sender' => 'admin',
//        'type' => 'email',
//        'created_at' => now(),
//        'updated_at' => now()
//    ]);
//    return back()->with('success', 'Nosūtīts!');
public function liveSend(Request $req, $type, $id)
{
   if ($type == 'request') {
       $data = DB::table('requests')->where('id', $id)->first();
   } else {
       $data = DB::table('bookings')->where('id', $id)->first();
   }
   DB::table('messages')->insert([
       'request_id' => $id,
       'email' => $data->email,
       'message' => $req->message,
       'sender' => 'admin',
       'type' => $type, 
       'is_read' => 0,
       'created_at' => now(),
       'updated_at' => now()
   ]);
   return back();
}

public function bookings()
{
   $search = request('search_main');
   $bookings = DB::table('bookings')
       ->join('tours', 'bookings.tour_id', '=', 'tours.id')
       ->select('bookings.*', 'tours.title as tour_title')
       ->orderBy('bookings.created_at', 'desc');
   if ($search) {
       $bookings->where(function ($q) use ($search) {
           $q->where('bookings.name', 'like', "%$search%")
             ->orWhere('bookings.email', 'like', "%$search%")
             ->orWhere('bookings.phone', 'like', "%$search%")
             ->orWhere('tours.title', 'like', "%$search%");
       });
   }
   $bookings = $bookings->get();
   $search2 = request('search_custom');
   $requests = DB::table('requests')
       ->orderBy('created_at', 'desc');
   if ($search2) {
       $requests->where(function ($q) use ($search2) {
           $q->where('name', 'like', "%$search2%")
             ->orWhere('email', 'like', "%$search2%")
             ->orWhere('phone', 'like', "%$search2%")
             ->orWhere('destination', 'like', "%$search2%")
             ->orWhere('description', 'like', "%$search2%");
       });
   }
   $requests = $requests->get();
   return view('admin.bookings', [
       'bookings' => $bookings,
       'requests' => $requests
   ]);


}
}