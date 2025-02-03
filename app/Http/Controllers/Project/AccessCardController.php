<?php

namespace App\Http\Controllers\Project;

use App\Http\Controllers\Controller;
use App\Models\AccessCard;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AccessCardController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role_or_permission:superadmin|manage access card']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.access_cards.index');
    }

    public function dataTable(Request $request)
    {
        $developer_id = $request->user()->hasRole('superadmin') ? null : $request->user()->developer_id;

        $accessCards = AccessCard::select('access_cards.*')->with([
            'projectunit:name,id',
            'user:id,name'
        ]);
        if ($developer_id) {
            $accessCards->where('developer_id', $developer_id);
        }
        return DataTables::of($accessCards)
            ->addIndexColumn()
            ->editColumn('start_date', function ($row) {
                return $row?->start_date->translatedFormat('d F Y');
            })
            ->editColumn('end_date', function ($row) {
                return $row?->end_date->translatedFormat('d F Y');
            })
            // ->addColumn('action', function ($row) {
            //     $btn = view('datatables.projects.action', compact('row'))->render();
            //     return $btn;
            // })
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
