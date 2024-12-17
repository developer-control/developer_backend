<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role_or_permission:superadmin|manage article']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 8;
        $developer_id = $request->user()->hasRole('superadmin') ? null : $request->user()->developer_id;
        $keyword = $request->input('keyword'); // Mengambil input keyword dari request
        $articles = Article::where(function ($q) use ($keyword) {
            $q->where('title', 'LIKE', "%{$keyword}%")
                ->orWhere('short_content', 'LIKE', "%{$keyword}%");
        });
        if ($developer_id) {
            $articles->where('developer_id', $developer_id);
        }
        // $tes = Str::limit('As Uber works through a huge amount of internal management turmoil.', 7, '...');
        $articles = $articles->paginate($limit);
        return view('pages.articles.index', compact('articles', 'request'));
    }

    public function create()
    {
        return view('pages.articles.create');
    }

    /**
     * store new developer to database
     * 
     * @param  ArticleRequest $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(ArticleRequest $request)
    {
        DB::beginTransaction();
        $developer_id = $request->user()->hasRole('superadmin') ? null : $request->user()->developer_id;
        $article = Article::create([
            'developer_id' => @$developer_id,
            'title' => $request->title,
            'short_content' => $request->short_content,
            'image' => $request->image,
            'content' => $request->content,
            'created_by' => Auth::user()->id
        ]);
        //get media
        $image = Media::where('url', $request->image)->first();
        if ($image) {
            $article->media()->attach($image, ['type' => 'image']);
        }
        DB::commit();
        toast('New Article has been created', 'success');
        return redirect()->route('menu_article');
    }


    public function edit(string $id)
    {
        $article = Article::find($id);
        return view('pages.articles.edit', compact('article'));
    }

    public function update(ArticleRequest $request, string $id)
    {
        $article = Article::find($id);
        $old_image = $article->image;
        if ($old_image != $request->image) {
            remove_file($old_image, $article);
            $image = Media::where('url', $request->image)->first();
            if ($image) {
                $article->media()->attach($image, ['type' => 'image']);
            }
        }
        $article->title = $request->title;
        $article->short_content = $request->short_content;
        $article->image = $request->image;
        $article->content = $request->content;
        $article->save();
        toast('Article has been updated', 'success');
        return redirect()->route('menu_article');
    }
    public function destroy(string $id)
    {
        $article = Article::find($id);
        if ($article->image) {
            remove_file($article->image, $article);
        }
        Article::destroy($id);
        toast('Article has been deleted', 'success');
        return back();
    }
}
