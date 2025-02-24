<?php

namespace App\Services;

use Google_Client;
use Illuminate\Support\Facades\Http;

class NotificationService
{

    public static function getAccessToken()
    {

        $credentialsPath = storage_path(config('fcm.service_account')); // Path to your service account file
        // dd($credentialsPath);
        $client = new Google_Client();
        $client->setAuthConfig($credentialsPath);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        $token = $client->fetchAccessTokenWithAssertion();

        return $token['access_token'];
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
