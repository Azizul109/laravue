<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function AllCat()
    {
         $categories = Category::latest()->paginate(4);
        // $categories = DB::table('categories')->latest()->get();
        // $categories = DB::table('categories')->latest()->paginate(4);
//        $categories = DB::table('categories')
//            ->join('users', 'users.id', 'categories.user_id')
//            ->select('categories.*', 'users.name')
//            ->latest()->paginate(4);
        return view('admin.category.index', compact('categories'));
    }

    public function AddCat(Request $request)
    {
        $validatedData = $request->validate([
            'category_name' => 'required|unique:categories|max:255'
        ],
            [
                'category_name.required' => 'Please enter some category name',
                'category_name.max' => 'Category name must be below 255 char',
            ]
        );

//        Category::insert([
//            'category_name' => $request->category_name,
//            'user_id' => Auth::user()->id,
//            'created_at' => Carbon::now(),
//        ]);

//        $category = new Category();
//        $category->category_name = $request->category_name;
//        $category->user_id = Auth::user()->id;
//        $category->save();

        $data = array();
        $data['category_name'] = $request->category_name;
        $data['user_id'] = Auth::user()->id;
        $data['created_at'] = now();
        DB::table('categories')->insert($data);

        return Redirect()->back()->with('success', 'Category inserted successfully');
    }

    public function Edit($id){
        // $categories = Category::find($id);
        $categories = DB::table('categories')->where('id',$id)->first();
        return view('admin.category.edit',compact('categories'));

    }

    public function Update(Request $request ,$id){
        $update = Category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id
        ]);
        
        // $data = array();
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // DB::table('categories')->where('id',$id)->update($data);

        return Redirect()->route('all.category')->with('success','Category Updated Successfull');

    }

}
