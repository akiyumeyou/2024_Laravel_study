<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller ;
use App\Http\Requests\Admin\StoreBlogRequest;
use App\Http\Requests\Admin\UpdateBlogRequest;

use App\Models\Blog;
use Illuminate\Http\Request;
use PHPUnit\TextUI\XmlConfiguration\UpdateSchemaLocation;

class AdminBlogController extends Controller
{
    //ブログ一覧画面
    public function index()
    {
        $blogs = Blog::all(); // または必要なクエリを実行して取得する

        return view('blogs.index', compact('blogs'));
    }

    //ブログ投稿画面
    public function create()
    {
        return view('admin.blogs.create');
    }

   //ブログ投稿処理
   public function store(StoreBlogRequest $request)
   {
       $savedImagePath = $request->file('image')->store('blogs', 'public');
       $blog = new Blog($request->validated());
       $blog->image = $savedImagePath;
       $blog->save();
       
       return redirect()->route('admin.blogs.index')->with('success', 'ブログを投稿しました');

   }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    //指定したIDのブログ編集画面
    public function edit(string $id)
    {
        $blog = Blog::findorFail($id);
        return view('admin.blogs.edit', ['blog' => $blog]);

    }

  //指定したIDブログの更新
  public function update(UpdateBlogRequest $request, string $id)
  {
      $blog = Blog::findOrFail($id);
      $updateData = $request->validated();
  
      // 画像を変更する場合
      if ($request->hasFile('image')) {
          Storage::disk('public')->delete($blog->image); // 
          $updateData['image'] = $request->file('image')->store('blogs', 'public'); // ディレクトリ名を'blogs'に修正
      }
  
      $blog->update($updateData);
  
      return redirect()->route('admin.blogs.index')->with('success', 'ブログを更新しました'); // 'to_route'を'route'に修正
  }
  
  


}
