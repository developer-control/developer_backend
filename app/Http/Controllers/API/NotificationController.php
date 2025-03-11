<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\NotificationResource;
use App\Models\User;
use App\Notifications\AppNotification;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationService;
    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Send Notification User from Auth.
     * 
     * api for send test notification user
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendNotificationUser(Request $request)
    {
        $user = $request->user();
        // dd($user);
        $user->notify(new AppNotification());
        return ApiResponse::success(null, 'notification has been sended');
    }

    /**
     * Send Notification Topic.
     * 
     * api for send test notification topic
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendNotificationChannel(Request $request)
    {
        $request->validate([
            'token' => 'string|nullable',
            'title' => 'string|nullable',
            'msg' => 'string|nullable'
        ]);
        $token = $request->token ?? 'all';
        $title = $request->title ?? 'Info Notification';
        $body = $request->msg ?? 'Info pemberitahuan kepada seluruh user';
        $payload = [
            'message' => [
                'token' => $token,
                'notification' => [
                    'title' => $title,
                    'body' => $body,
                ],
                'android' => [
                    'priority' => 'high',
                ],
                'apns' => [
                    'headers' => [
                        'apns-priority' => '10',
                    ],
                ],
            ],
        ];
        $this->notificationService->sendNotification($payload);
        return ApiResponse::success(null, 'notification has been sended');
    }

    /**
     * Get Type Notifications.
     * 
     * api for get type of notifications from database
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function indexType(Request $request)
    {
        $user_id = @$request->user()->id;
        $user = User::find($user_id);
        $notificationTypes = $user->notifications()
            ->select('type')
            ->distinct()
            ->pluck('type');
        return ApiResponse::success($notificationTypes->all(), 'Get notification type success');
    }

    /**
     * Get Notifications.
     * 
     * api for get notifications from database
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $request->validate([
            'search' => 'string|nullable',
            'limit' => 'int|nullable',
            /**
             * type
             * 
             * @example all, type-notification
             */
            'type' => 'string|nullable',
            /**
             * Page number
             * 
             * @example 1
             */
            'page' => 'int|nullable',
        ]);
        $limit = $request->limit ?? 10;
        $user_id = @$request->user()->id;
        $user = User::find($user_id);
        $notifications = @$user->notifications()->select('id', 'type', 'data', 'created_at');

        if (@$request->type && $request->type != 'all') {
            $notifications->where('type', $request->type);
        }
        if ($request->search) {
            $notifications->whereRaw("MATCH(content) AGAINST(? IN BOOLEAN MODE)", [$request->search]);
            // $notifications->where('data->msg', "like", "%$request->search%");
        }
        $notifications = $notifications->paginate($limit);
        return ApiResponse::success(NotificationResource::collection($notifications), 'get notifications success');
    }
}
