<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeveloperBankRequest;
use App\Models\DeveloperBank;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class DeveloperBankController extends Controller
{
    const ROUTE = 'developer.bank.';
    const PERMISSION = 'developer>bank>';
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
        return view('pages.master.developer_banks.index');
    }

    public function dataTable(Request $request)
    {
        $developer_id = $request->user()->hasRole('superadmin') ? null : $request->user()->developer_id;
        $banks = DeveloperBank::query();
        if ($developer_id) {
            $banks->where('developer_id', $developer_id);
        }
        return DataTables::of($banks)
            ->addColumn('action', function ($row) {
                $btn = view('datatables.developer_banks.action', compact('row'))->render();
                return $btn;
            })
            ->addColumn('name_view', function ($row) {
                return view('datatables.developer_banks.title', compact('row'))->render();
            })
            ->rawColumns(['action', 'name_view'])
            ->addIndexColumn()
            ->toJson();
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.master.developer_banks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DeveloperBankRequest $request)
    {
        try {
            DB::beginTransaction();
            $bank = DeveloperBank::create($request->all());
            //get media
            $image = Media::where('url', $request->image)->first();
            if ($image) {
                $bank->media()->attach($image, ['type' => 'image']);
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::commit();
            toast($th->getMessage(), 'error');
            return back();
        }
        toast('New bank has been created', 'success');
        return redirect()->route(self::ROUTE . 'index');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bank = DeveloperBank::find($id);
        return view('pages.master.developer_banks.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DeveloperBankRequest $request, string $id)
    {
        $bank = DeveloperBank::find($id);
        $old_image = $bank->image;
        if ($old_image != $request->image) {
            remove_file($old_image, $bank);
            $image = Media::where('url', $request->image)->first();
            if ($image) {
                $bank->media()->attach($image, ['type' => 'image']);
            }
        }
        $bank->update($request->all());
        toast('Bank has been updated', 'success');
        return redirect()->route(self::ROUTE . 'index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bank = DeveloperBank::find($id);
        if ($bank->image) {
            remove_file($bank->image, $bank);
        }
        DeveloperBank::destroy($id);
        toast('Bank has been deleted', 'success');
        return back();
    }
}
