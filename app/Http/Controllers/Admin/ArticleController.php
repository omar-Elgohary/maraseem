<?php
namespace App\Http\Controllers\Admin;
use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::paginate(10);
        return view('admin.articles.index', get_defined_vars());
    }


    public function create()
    {
        return view('admin.articles.create');
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|min:20',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('articles'), $imageName);

        $article = new Article();
        $article->title = $validatedData['title'];
        $article->content = $validatedData['content'];
        $article->image = $imageName ?? null;
        $article->save();

        return redirect()->route('admin.articles.index')->with('success', 'تم إضافة المقالة بنجاح');
    }


    public function edit(Article $article)
    {
        $article = Article::find($article->id);
        return view('admin.articles.edit', get_defined_vars());
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $article = Article::findOrFail($id);

        $article->title = $request->title;
        $article->content = $request->content;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time().'.'.$image->getClientOriginalExtension();
            $image->move(public_path('articles'), $imageName);
            $article->image = $imageName;
        }
        $article->save();

        return redirect()->route('admin.articles.index')->with('success', 'تم تحديث المقال بنجاح');
    }


    public function show(Article $article)
    {
        $article = Article::find($article->id);
        return view('admin.articles.show', get_defined_vars());
    }


    public function destroy(Article $article)
    {
        $article->delete();
        return redirect()->route('admin.articles.index')->with('success', 'تم حذف المقالة بنجاح');
    }
}

