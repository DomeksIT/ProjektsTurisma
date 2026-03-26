<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
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
if (Auth::attempt([
   'email' => $request->email,
   'password' => $request->password
])) {
   return redirect('/admin/bookings');
} else {
   return back()->with('error', 'Nepareizs e-pasts vai parole!');
}
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
$data = [
'title'=>$request->title,
'price'=>$request->price,
'start_date'=>$request->start_date,
'end_date'=>$request->end_date,
'description'=>$request->description,
'category_id'=>$request->category_id
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
public function categories()
{
    $categories = DB::table('categories')->get();

    return view('admin.categories', [
        'categories' => $categories
    ]);
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

    return view('admin.edit-category', [
        'category' => $category
    ]);
}
Public function updateCategory(Request $request, $id)
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
}