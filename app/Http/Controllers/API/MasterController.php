<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\FaqResource;
use App\Http\Resources\Api\TermConditionResource;
use App\Models\Faq;
use App\Models\TermCondition;
use Illuminate\Http\Request;

class MasterController extends Controller
{
    /**
     * Get FAQ.
     * 
     * api for get Faq from database
     * 
     * @unauthenticated
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function faq()
    {
        $faqs = Faq::all();
        return ApiResponse::success(FaqResource::collection($faqs), 'Get faq success.');
    }

    /**
     * Get Term Condition.
     * 
     * api for get Term & Condition from database
     * 
     * @unauthenticated
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function termCondition()
    {
        $term = TermCondition::first();
        if (!$term) {
            return ApiResponse::success(null, 'Term & Condition not found', 200);
        }
        return ApiResponse::success(new TermConditionResource($term), 'Get term condition success.');
    }
}
