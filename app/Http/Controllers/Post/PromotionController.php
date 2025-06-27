<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\PromotionRequest;
use App\Models\Media;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PromotionController extends Controller
{
    const ROUTE = 'promotion.';
    const PERMISSION = 'promotion>';
    public function __construct()
    {
        $this->middleware(['auth']);
        view()->share('this_route', self::ROUTE);
        view()->share('this_perm', self::PERMISSION);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 8;
        $developer_id = $request->user()->hasRole('superadmin') ? null : $request->user()->developer_id;
        $keyword = $request->input('keyword'); // Mengambil input keyword dari request
        $promotions = Promotion::where(function ($q) use ($keyword) {
            $q->where('title', 'LIKE', "%{$keyword}%")
                ->orWhere('content', 'LIKE', "%{$keyword}%");
        });
        if ($developer_id) {
            $promotions->where('developer_id', $developer_id);
        }
        // $tes = Str::limit('As Uber works through a huge amount of internal management turmoil.', 7, '...');
        $promotions = $promotions->paginate($limit);
        return view('pages.promotions.index', compact('promotions', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.promotions.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  PromotionRequest $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(PromotionRequest $request)
    {
        DB::beginTransaction();
        $developer_id = $request->user()->hasRole('superadmin') ? null : $request->user()->developer_id;
        $promtion = Promotion::create([
            'developer_id' => @$developer_id,
            'title' => $request->title,
            'image' => $request->image,
            'content' => $request->content,
            'created_by' => $request->user()->id,
            'is_active' => $request->is_active ? 1 : 0
        ]);
        //get media
        $image = Media::where('url', $request->image)->first();
        if ($image) {
            $promtion->media()->attach($image, ['type' => 'image']);
        }
        DB::commit();
        toast('New Promotion has been created', 'success');
        return redirect()->route(self::ROUTE . 'index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $promotion = Promotion::find($id);
        return view('pages.promotions.edit', compact('promotion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PromotionRequest $request, string $id)
    {
        $promotion = Promotion::find($id);
        $old_image = $promotion->image;
        if ($old_image != $request->image) {
            remove_file($old_image, $promotion);
            $image = Media::where('url', $request->image)->first();
            if ($image) {
                $promotion->media()->attach($image, ['type' => 'image']);
            }
        }
        $promotion->title = $request->title;
        $promotion->image = $request->image;
        $promotion->content = $request->content;
        $promotion->is_active = $request->is_active ? 1 : 0;
        $promotion->save();
        toast('Promotion has been updated', 'success');
        return redirect()->route(self::ROUTE . 'index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $promotion = Promotion::find($id);
        if ($promotion->image) {
            remove_file($promotion->image, $promotion);
        }
        Promotion::destroy($id);
        toast('Promotion has been deleted', 'success');
        return back();
    }
}
