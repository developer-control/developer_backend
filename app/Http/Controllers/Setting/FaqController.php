<?php

namespace App\Http\Controllers\Setting;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\FaqRequest;
use App\Http\Resources\Api\FaqResource;
use App\Models\Faq;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class FaqController extends Controller
{
    /**
     * Get Faqs.
     * 
     * api for get faqs from database
     * @unauthenticated
     * @param  \use Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        return  view('pages.faqs.index');
    }

    public function faqDatatable(Request $request)
    {
        $faqs = Faq::query();

        return DataTables::eloquent($faqs)
            ->addColumn('action', function (Faq $faq) {
                $btn = view('datatables.faqs.action', compact('faq'))->render();
                return $btn;
            })
            ->editColumn('description', function (Faq $faq) {
                return str($faq->description)->limit(65);
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->toJson();
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(FaqRequest $request)
    {
        $validatedData = $request->validated();
        Faq::create($validatedData);
        toast('New FAQ has been created', 'success');
        return back();
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $term = Faq::findOrFail($id);

        // Mengambil data yang sudah divalidasi
        $validatedData = $request->validated();

        // Mengupdate data term
        $term->update($validatedData);
        toast('FAQ has been updated', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Faq::destroy($id);
        toast('FAQ has been deleted', 'success');
        return back();
    }
}
