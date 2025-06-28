<?php

namespace App\Http\Controllers\Setting;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\TermConditionRequest;
use App\Http\Resources\Api\TermConditionResource;
use App\Models\TermCondition;
use Illuminate\Http\Request;

class TermConditionController extends Controller
{
    const ROUTE = 'term-condition.';
    const PERMISSION = 'term-condition>';
    public function __construct()
    {
        $this->middleware(['auth']);
        view()->share('this_route', self::ROUTE);
        view()->share('this_perm', self::PERMISSION);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $term = TermCondition::first();
        return view('pages.term_conditions.index', compact('term'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.term_conditions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TermConditionRequest $request)
    {
        // Mengambil data yang sudah divalidasi
        $validatedData = $request->validated();
        TermCondition::create($validatedData);
        toast('New Term Condition has been created', 'success');
        return redirect()->route(self::ROUTE . 'index');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $term = TermCondition::find($id);
        return view('pages.term_conditions.edit', compact('term'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TermConditionRequest $request, string $id)
    {
        $term = TermCondition::findOrFail($id);

        // Mengambil data yang sudah divalidasi
        $validatedData = $request->validated();

        // Mengupdate data term
        $term->update($validatedData);
        toast('Term Condition has been updated', 'success');
        return redirect()->route(self::ROUTE . 'index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        TermCondition::destroy($id);
        toast('Term Condition has been deleted', 'success');
        return back();
    }
}
