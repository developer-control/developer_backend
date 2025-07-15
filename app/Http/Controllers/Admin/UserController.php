<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Mail\VerificationCodeMail;
use App\Models\Media;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    const ROUTE = 'user.';
    const PERMISSION = 'user>';
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

        return view('pages.users.index', compact('request'));
    }
    /**
     * get datatable resource for role access master.
     */
    public function userDatatable(Request $request)
    {

        $users = User::select('users.*');

        if (!$request->user()->hasRole('superadmin')) {
            $users->where('developer_id', $request->user()->developer_id);
        }
        return DataTables::eloquent($users)

            ->editColumn('email_verified_at', function ($obj) {
                return $obj->email_verified_at ? $obj->email_verified_at->toDateTimeString() : null;
            })
            ->addColumn('action', function ($obj) {
                $btn = view('datatables.users.action', compact('obj'))->render();
                return $btn;
            })
            ->addIndexColumn()
            ->toJson();
    }
    public function create()
    {
        return view('pages.users.upsert', ['obj' => null]);
    }
    public function store(UserRequest $request)
    {
        try {
            DB::beginTransaction();
            $user = User::create([
                'developer_id' => $request->developer_id ?? $request->user()->developer_id,
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'identity_number' => $request->identity_number,
                'id_card_image' => $request->id_card_image,
                'phone_number' => $request->phone_number,
                'date_of_birth' => $request->date_of_birth,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
            ]);
            //get media
            $image = Media::where('url', $request->id_card_image)->first();
            if ($image) {
                $user->media()->attach($image, ['type' => 'id_card']);
            }
            $user->assignRole($request->role);
            $user->generateVerificationCode();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            toast($th->getMessage(), 'error');
            return back()->withInput()->withErrors($th);
        }

        // Kirim email dengan kode verifikasi
        Mail::to($user->email)->send(new VerificationCodeMail($user));
        toast('New User has been created', 'success');
        return redirect()->route(self::ROUTE . 'index');
    }
    public function edit($id)
    {
        $user = User::find($id);
        return view('pages.users.upsert', ['obj' => $user]);
    }
    public function update($id, UserRequest $request)
    {
        $user = User::find($id);
        try {
            DB::beginTransaction();
            $old_id_card = $user->id_card_image;
            if ($old_id_card != $request->id_card_image) {
                remove_file($old_id_card, $user);
                $image = Media::where('url', $request->id_card_image)->first();
                if ($image) {
                    $user->media()->attach($image, ['type' => 'id_card']);
                }
            }
            $user->update([
                'developer_id' => $request->developer_id ?? $request->user()->developer_id,
                'name' => $request->name,
                'email' => $request->email,
                'identity_number' => $request->identity_number,
                'id_card_image' => $request->id_card_image,
                'phone_number' => $request->phone_number,
                'date_of_birth' => $request->date_of_birth,
                'phone_number' => $request->phone_number,
                'address' => $request->address,
            ]);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            toast($th->getMessage(), 'error');
            return back()->withInput()->withErrors($th);
        }
        toast('User has been updated', 'success');
        return redirect()->route(self::ROUTE . 'index');
    }

    public function destroy($id)
    {
        $user = User::find($id);
        try {
            DB::beginTransaction();
            remove_file($user->id_card_image, $user);
            remove_file($user->image, $user);
            $user->devices()->delete();
            $user->currentAccseeToken()->delete();
            $user->delete();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            toast($th->getMessage(), 'error');
            return back()->withInput()->withErrors($th);
        }
        toast('User has been deleted', 'success');
        return back();
    }
}
