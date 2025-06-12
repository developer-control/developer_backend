<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Requests\BannerRequest;
use App\Models\Banner;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role_or_permission:superadmin|manage banner']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? 8;
        $developer_id = $request->user()->hasRole('superadmin') ? null : $request->user()->developer_id;
        $keyword = $request->input('keyword'); // Mengambil input keyword dari request
        $banners = Banner::where(function ($q) use ($keyword) {
            $q->where('title', 'LIKE', "%{$keyword}%")
                ->orWhere('content', 'LIKE', "%{$keyword}%");
        });
        if ($developer_id) {
            $banners->where('developer_id', $developer_id);
        }
        // $tes = Str::limit('As Uber works through a huge amount of internal management turmoil.', 7, '...');
        $banners = $banners->paginate($limit);
        return view('pages.banners.index', compact('banners', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.banners.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  BannerRequest $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(BannerRequest $request)
    {
        DB::beginTransaction();
        $developer_id = $request->user()->hasRole('superadmin') ? null : $request->user()->developer_id;
        $banner = Banner::create([
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
            $banner->media()->attach($image, ['type' => 'image']);
        }
        DB::commit();
        toast('New Banner has been created', 'success');
        return redirect()->route('menu_banner');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $banner = Banner::find($id);
        return view('pages.banners.edit', compact('banner'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  BannerRequest $request
     * @param  string $id
     * @return \Illuminate\Http\Response
     * 
     */
    public function update(BannerRequest $request, string $id)
    {
        $banner = Banner::find($id);
        $old_image = $banner->image;
        if ($old_image != $request->image) {
            remove_file($old_image, $banner);
            $image = Media::where('url', $request->image)->first();
            if ($image) {
                $banner->media()->attach($image, ['type' => 'image']);
            }
        }
        $banner->title = $request->title;
        $banner->image = $request->image;
        $banner->content = $request->content;
        $banner->is_active = $request->is_active ? 1 : 0;
        $banner->save();
        toast('Banner has been updated', 'success');
        return redirect()->route('menu_banner');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::find($id);
        if ($banner->image) {
            remove_file($banner->image, $banner);
        }
        Banner::destroy($id);
        toast('Banner has been deleted', 'success');
        return back();
    }
}
