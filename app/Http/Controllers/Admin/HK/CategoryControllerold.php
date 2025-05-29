<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;


class CategoryController extends Controller
{
    public function category()
    {
        $categories = Category::all();
        return view('category.category_list', [
            'categories' => $categories,
        ]);
    }
    public function categoryStore(Request $request)
    {
        $request->validate([
            'name_english' => 'required',
            'name_bangla' => 'required',
        ]);

        $logo = $request->logo;
        $extension = $logo->extension();
        $file_name = Str::lower(str_replace(' ', '-', $request->name_english)) . '.' . $extension;
        Image::make($logo)->save(public_path('uploads/category/') . $file_name);

        Category::insert([
            'name_english' => $request->name_english,
            'name_bangla' => $request->name_bangla,
            'logo' => $file_name,
            'meta_title' => $request->meta_title,
            'meta_des' => $request->meta_des,
            'parent_category' => $request->parent_category,
            'status' => $request->status,
            'created_at' => Carbon::now(),
        ]);
        $notification = array('messege' => 'Category Added Successfuly', 'alert-type' => 'success');

        return redirect()->back()->with($notification);
    }
    public function categoryEdit($id)
    {
        $categories = Category::find($id);
        return view('category.edit', [
            'categories' => $categories,
        ]);
    }

    public function categoryUpdate(Request $request, $id)
    {
        $cat_info = Category::find($id);
        if ($request->logo == '') {
            Category::find($id)->update([
                'name_english' => $request->name_english,
                'name_bangla' => $request->name_bangla,
                'meta_title' => $request->meta_title,
                'meta_des' => $request->meta_des,
                'parent_category' => $request->parent_category,
                'status' => $request->status,
                'updated_at' => Carbon::now(),
            ]);
            $notification = array('messege' => 'Category Updated Successfuly', 'alert-type' => 'success');

            return redirect()->route('category.list')->with($notification);
        } else {
            $delete_photo = public_path('uploads/category/' . $cat_info->logo);
            unlink($delete_photo);

            $logo = $request->logo;
            $extension = $logo->extension();
            $file_name = Str::lower(str_replace(' ', '-', $request->name_english)) . '.' . $extension;
            Image::make($logo)->save(public_path('uploads/category/') . $file_name);

            Category::find($id)->update([
                'name_english' => $request->name_english,
                'name_bangla' => $request->name_bangla,
                'logo' => $file_name,
                'meta_title' => $request->meta_title,
                'meta_des' => $request->meta_des,
                'parent_category' => $request->parent_category,
                'status' => $request->status,
                'updated_at' => Carbon::now(),
            ]);
            $notification = array('messege' => 'Category Updated Successfuly', 'alert-type' => 'success');

            return redirect()->route('category.list')->with($notification);
        }
    }
    public function categoryDelete($id)
    {
        $logo = Category::find($id);
        $delete = public_path('uploads/category/' . $logo->logo);
        unlink($delete);
        Category::find($id)->delete();

        $notification = array('messege' => 'Category Deleted Successfully', 'alert-type' => 'warning');

        return redirect()->back()->with($notification);
    }
}
