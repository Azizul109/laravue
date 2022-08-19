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
        return view('admin.category.index');
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
}
