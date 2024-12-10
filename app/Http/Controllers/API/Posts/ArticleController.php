<?php

namespace App\Http\Controllers\API\Posts;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ArticleQuery;
use App\Http\Resources\Api\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Get Articles.
     * 
     * api for get article from database
     * 
     *@unauthenticated
     * @param  \App\Http\Requests\Api\ArticleQuery  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ArticleQuery $request)
    {
        $limit = $request->limit ?? 10;
        $articles = Article::with(['createdBy:id, name']);
        if ($request->search) {
            $articles->where('name', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->developer_id) {
            $articles->where('developer_id', $request->developer_id);
        }
        $results = $articles->paginate($limit);
        return ApiResponse::success(ArticleResource::collection($results), 'Get articles success.');
    }



    /**
     * Detail Articles.
     * 
     * api for get detail article from database
     * 
     *@unauthenticated
     * @param  string  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(string $id)
    {
        $article = Article::with(['createdBy:id, name'])->find($id);
        if (!$article) {
            return ApiResponse::success(null, 'article not found', 200);
        }
        return ApiResponse::success(new ArticleResource($article), 'get detail article success');
    }
}
