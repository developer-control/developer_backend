<?php

namespace App\Http\Controllers\API;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
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
}
