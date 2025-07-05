<?php

namespace App\Http\Controllers\Master;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\DeveloperRequest;
use App\Models\Developer;
use App\Models\DeveloperSubscription;
use App\Models\Subscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DeveloperController extends Controller
{
    const ROUTE = 'developer.';
    const PERMISSION = 'developer>';
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
        return view('pages.master.developers.index');
    }

    /**
     * get datatable resource for role access master.
     */
    public function developerDatatable(Request $request)
    {

        $developers = Developer::query();

        return DataTables::eloquent($developers)

            ->addColumn('action', function (Developer $developer) {
                $btn = view('datatables.developers.action', compact('developer'))->render();
                return $btn;
            })
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * store new developer to database
     * 
     * @param  DeveloperRequest $request
     * @return \Illuminate\Http\Response
     * 
     */
    public function store(DeveloperRequest $request)
    {
        Developer::create([
            'name' => $request->name,
        ]);
        toast('New developer has been created', 'success');
        return back();
    }


    /**
     * Update the specified resource in storage.
     * 
     *  @param  DeveloperRequest $request
     *  @param  string $id
     *  @return \Illuminate\Http\Response
     * 
     */
    public function update(DeveloperRequest $request, string $id)
    {
        $developer = Developer::find($id);
        $developer->name = $request->name;
        $developer->slug = $request->slug;
        $developer->save();

        toast('Developer has been updated', 'success');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     * 
     * @param  string $id
     * @return \Illuminate\Http\Response
     * 
     */
    public function destroy(string $id)
    {
        Developer::destroy($id);
        toast('Developer has been deleted', 'success');
        return back();
    }
    public function optionDeveloper(Request $request)
    {
        $limit = $request->limit ?? 10;
        $developers = Developer::select('id', 'name');
        if ($request->search) {
            $developers->where('name', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->limit) {
            $developers->limit($request->limit);
        }
        $results = $developers->get();
        return ApiResponse::success($results, 'Get developers success.');
    }

    public function showSubscription($id)
    {
        $developer = Developer::findOrFail($id);
        $subscriptions = Subscription::all();
        return view('pages.master.developers.subscription', compact('developer', 'subscriptions'));
    }

    public function dataTableSubscription(string $id, Request $request)
    {
        $subscriptions = DeveloperSubscription::with(['subscription:id,name'])
            ->select('developer_subscriptions.*')
            ->where('developer_id', $id);
        return DataTables::eloquent($subscriptions)
            ->editColumn('status', function ($row) {
                return strtoupper($row->status);
            })->editColumn('expired_at', function ($row) {
                return date_format(date_create($row->expired_at), 'd F Y');
            })
            ->addColumn('action', function ($row) {
                return view('datatables.developers.subscription-action', compact('row'))->render();
            })
            ->addIndexColumn()
            ->rawColumns(['action'])
            ->toJson();
    }
    public function storeSubscription($id, Request $request)
    {
        $developer = Developer::findOrFail($id);
        $subscription = Subscription::findOrFail($request->subscription_id);
        $expired_at = Carbon::now()->addMonths($subscription->duration)->toDateString();
        $developer->developerSubscriptions()->create([
            'subscription_id' => $request->subscription_id,
            'expired_at' => $expired_at,
            'paid_at' => now(),
            'status' => 'active'
        ]);
        toast('new subscription has been added', 'success');
        return back();
    }
    public function destroySubscription($id)
    {
        DeveloperSubscription::destroy($id);
        toast('Subscription has been deleted', 'success');
        return back();
    }
}
