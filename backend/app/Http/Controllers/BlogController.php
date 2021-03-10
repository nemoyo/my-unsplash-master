<?php

namespace App\Http\Controllers;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /**
     * ブログを表示する
     * @return json
     */
    public function index() {

        $blogs = Blog::all();
        return $blogs;
    }

    /**
     * ブログを登録する
     * 
     */
    public function exeStore(Request $request){
        
        DB::beginTransaction();
        try {
            //登録処理
            $blog = new Blog;
            $blog->label = $request->label;
            $filePath = $request->image->store('public');
            $blog->file_path = $filePath;
            $blog->save();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            abort(500);
        }
        return redirect()->route('blogs');
    }
}