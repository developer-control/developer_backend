<?php

namespace App\Http\Controllers\API\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\UserResource;
use App\Models\Media;
use App\Models\User;
use App\Traits\UploadMedia;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Detail user.
     * 
     * api auth for getting detail of user
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
        $user = User::find(@$request->user()->id);
        if (!$user) {
            return ApiResponse::error('User not found', 404);
        }
        return ApiResponse::success(new UserResource($user), 'get detail user success');
    }

    /**
     * Update detail user.
     * 
     * api for update profile user to database
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $user = User::find(@$request->user()->id);
        if (!$user) {
            return ApiResponse::error('User not found', 404);
        }
        $request->validate([
            'name' => 'required',
            'identity_number' => 'string',
            /**
             * url from image id_card
             * 
             * @example contents/image/..sds.png
             */
            'id_card_image' => 'string',
            /**
             * date of birth user format date
             * 
             * @example Y-m-d
             */
            'date_of_birth' => 'string',
            'phone_number' => 'string',
            /**
             * url from image profile image
             * 
             * @example contents/image/..sds.png
             */
            'image' => 'string',
        ]);
        $user->name = $request->name;
        $user->identity_number = $request->identity_number;
        $user->date_of_birth = $request->date_of_birth;
        $user->phone_number = $request->phone_number;
        $user->image = $request->image;

        if ($request->id_card_image) {
            remove_file($user->id_card_image, $user);
            $user->id_card_image = $request->id_card_image;
            $id_card = Media::where('url', $request->id_card_image)->first();
            if (@$id_card) {
                $user->media()->attach($id_card, ['type' => 'image']);
            }
        }
        if ($request->image) {
            remove_file($user->image, $user);
            $user->image = $request->image;
            $image = Media::where('url', $request->image)->first();
            if (@$image) {
                $user->media()->attach($image, ['type' => 'image']);
            }
        }
        $user->save();
        return ApiResponse::success(new UserResource($user), 'Updated request complain succes', 200);
    }

    /**
     * Delete User Account.
     * 
     * api for remove user account from database
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeUser(Request $request)
    {
        $user = User::find(@$request->user()->id);
        if (!$user) {
            return ApiResponse::error('User not found', 404);
        }
        remove_file($user->id_card_image, $user);
        remove_file($user->image, $user);
        if ($request->device_token) {
            try {
                $model = $request->user()->devices()->firstWhere('token', $request->device_token);
                optional($model)->delete();
            } catch (\Throwable $th) {
                return ApiResponse::error('Logout failed, please check your connection', 409);
            }
        }

        $request
            ->user()
            ->currentAccessToken()
            ->delete();
        $user->delete();
        return ApiResponse::success(null, 'Remove User Account success.', 200);
    }

    public function changePassword(Request $request)
    {
        $user = User::find(@$request->user()->id);
        if (!$user) {
            return ApiResponse::error('User not found', 404);
        }
        $request->validate([
            'otp' => 'required',
            'email' => 'required|email',
            'password' => ['required', 'confirmed']
        ]);
        $user->password = bcrypt($request->password);
        $user->save();
        return ApiResponse::success(null, 'Remove User Account success.', 200);
    }
}
