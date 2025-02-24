<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class NotificationService
{

    public static function getAccessToken()
    {
        $client = new Client();
        $client->setAuthConfig(storage_path(config('fcm.service_account'))); // Path JSON
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');
        $client->refreshTokenWithAssertion();
        return $client->getAccessToken()['access_token'];
    }

    public static function sendNotification($data)
    {
        $url = 'https://fcm.googleapis.com/v1/projects/' . config('fcm.project') . '/messages:send';
        $accessToken = self::getAccessToken();
        try {
            Http::accept('application/json')
                ->withToken($accessToken)
                ->post($url, $data);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
