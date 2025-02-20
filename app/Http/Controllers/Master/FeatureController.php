<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\FeatureRequest;
use App\Models\Feature;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class FeatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.features.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function dataTable(Request $request)
    {
        $features = Feature::query();
        return DataTables::of($features)
            ->addIndexColumn()
            ->addColumn('action', function ($feat) {
                $data = $feat->setVisible(['key', 'name', 'description', 'type', 'group'])->toArray();
                return view('datatables.features.action', compact('feat', 'data'))->render();
            })
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FeatureRequest $request)
    {
        $input = $request->validated();
        $feature = Feature::create($input);
        if ($feature->type == 'free') {
            $subscriptions = Subscription::pluck('id')->all();
            if (count($subscriptions)) {
                $feature->subscriptions()->attach($subscriptions);
            }
        }
        toast('New Feature has been created', 'success');
        return back();
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(FeatureRequest $request, string $id)
    {
        $feature = Feature::findOrFail($id);
        $oldType = $feature->type;
        $input = $request->validated();
        $feature->update($input);
        if ($oldType <> $feature->type && $feature->type == 'free') {
            $subscriptions = Subscription::pluck('id')->all();
            if (count($subscriptions)) {
                $feature->subscriptions()->syncWithoutDetaching($subscriptions);
            }
        }
        toast('Feature has been updated', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Feature::destroy($id);
        toast('Feature has been deleted', 'success');
        return back();
    }
}
