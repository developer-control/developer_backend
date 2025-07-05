<?php

namespace App\Http\Controllers\API\Posts;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ArticleQuery;
use App\Http\Requests\Api\TagQuery;
use App\Http\Resources\Api\ArticleResource;
use App\Http\Resources\Api\TagResource;
use App\Models\Article;
use App\Models\Tag;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Get Articles.
     * 
     * api for get article from database
     * 
     * @unauthenticated
     * @param  \App\Http\Requests\Api\ArticleQuery  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ArticleQuery $request)
    {
        $limit = $request->limit ?? 10;
        $developer = $request->developer;
        $articles = Article::with(['createdBy:id,name', 'tags:id,name']);
        if ($request->search) {
            $articles->where('title', 'LIKE', '%' . $request->search . '%');
        }

        $articles->where(function ($q) use ($developer) {
            $q->whereNull('developer_id')->orWhere('developer_id', $developer->id);
        });

        if ($request->tag_id) {
            $articles->whereHas('tags', function ($query) use ($request) {
                $query->where('tags.id', $request->tag_id);
            });
        }
        $results = $articles->paginate($limit);
        return ApiResponse::success(ArticleResource::collection($results), 'Get articles success.');
    }

    /**
     * Get List Tags.
     * 
     * api get tags for article from database
     * 
     * @unauthenticated
     * @param  \App\Http\Requests\Api\TagQuery  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexTag(TagQuery $request)
    {
        $developer = $request->developer;
        $tags = Tag::has('articles');
        $tags->whereHas('articles', function ($q) use ($developer) {
            $q->whereNull('developer_id')->orWhere('developer_id', $developer->id);
        });

        if ($request->search) {
            $tags->where('name', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->limit) {
            $tags->limit($request->limit);
        }

        $results = $tags->get();
        return ApiResponse::success(TagResource::collection($results), 'Get Tag success.');
    }

    /**
     * Detail Articles.
     * 
     * api for get detail article from database
     * 
     * @unauthenticated
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $slug, string $id)
    {
        $article = Article::with(['createdBy:id,name'])->find($id);
        if (!$article) {
            return ApiResponse::success(null, 'article not found', 200);
        }
        return ApiResponse::success(new ArticleResource($article), 'get detail article success');
    }
}
