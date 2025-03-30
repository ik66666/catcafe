<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;
use App\Models\Category;
use App\Models\Blog;
use App\Models\Cat;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;


class AdminBlogController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $blogs = Blog::latest('updated_at')->simplePaginate(10);
        return view('admin.blogs.index', compact('blogs','user'));
    }

    public function create()
    {
        return view('admin.blogs.create');
    }

    public function store(StoreBlogRequest $request)
    {
        $saveImagePath = $request->file('image')->store('blogs', 'public');
        $blog = new Blog($request->validated());
        $blog->image = $saveImagePath;
        $blog->save();

        return to_route('admin.blogs.index')->with('success', 'ブログを投稿しました');
    }

    public function edit(Blog $blog)
    {
        $user = Auth::user();
        $categories = Category::all();
        $cats = Cat::all();
        return view('admin.blogs.edit',compact('blog','categories','cats','user'));
    }

    public function update(UpdateBlogRequest $request,String $id)
    {
        $blog = Blog::findORFail($id);
        $updateData = $request->validated();

        if($request->has('image')){
            Storage::disk('public')->delete($blog->image);
            $updateData['image'] = $request->file('image')->store('blogs', 'public');
        }
        $blog->category()->associate($updateData['category_id']);
        $blog->update($updateData);
         if (isset($updateData['cats'])) {
            $blog->cats()->sync($updateData['cats']); // `sync()` で関連を更新
        } else {
            $blog->cats()->sync([]); // `cats` が空なら関連を削除
        }


        return to_route('admin.blogs.index')->with('success','ブログを更新しました');

    }

    public function destroy(String $id)
    {
        $blog = Blog::findOrFail($id);
        $blog->delete();
        Storage::disk('public')->delete($blog->image);
        return to_route('admin.blogs.index')->with('success','ブログを削除しました');
    }

}
