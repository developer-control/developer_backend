<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriptionRequest;
use App\Models\Feature;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SubscriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pages.subscriptions.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function datatable(Request $request)
    {
        $subscriptions = Subscription::query();
        return DataTables::of($subscriptions)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $data = $row->setVisible(['name', 'price', 'duration', 'description'])->toArray();
                return view('datatables.subscriptions.action', compact('row', 'data'))->render();
            })
            ->editColumn('price', function ($row) {
                return 'Rp. ' . number_format(@$row->price);
            })
            ->editColumn('duration', function ($row) {
                return $row->duration . ' bulan';
            })
            ->toJson();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubscriptionRequest $request)
    {
        $input = $request->validated();

        $subscription = Subscription::create($input);
        $features = Feature::where('type', 'free')->pluck('id');
        $subscription->features()->attach($features->all());
        toast('New Subscription has been created', 'success');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $subscription = Subscription::findOrFail($id);
        $featSubs = $subscription->features()->pluck('id')->all() ?? [];
        $features = Feature::all();
        return view('pages.subscriptions.detail', compact('subscription', 'featSubs', 'features'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function subscribeFeature(Request $request, string $id)
    {
        $subscription = Subscription::find($id);
        $subscription->features()->sync($request->features);
        toast('Features has been assign to subscription', 'success');
        return back();
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(SubscriptionRequest $request, string $id)
    {
        $subscription = Subscription::findOrFail($id);
        $input = $request->validated();

        $subscription->update($input);
        toast('Subscription has been updated', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Subscription::destroy($id);
        toast('Subcription has been deleted', 'success');
        return back();
    }
}
