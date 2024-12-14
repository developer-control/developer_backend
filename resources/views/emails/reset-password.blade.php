<!DOCTYPE html>
<html>

<head>
    <title>Reset Password</title>
</head>

<body>
    <p>{{ Lang::get('You are receiving this email because we received a password reset request for your account.') }}
    </p>
    <p style="padding: 10px 20px; background-color: #cdcdcd; color: rgb(15, 15, 15); border-radius: 5px;">
        {{ $token }}
    </p>
    <p>{{ Lang::get('This password reset link will expire in :count minutes.', ['count' => config('auth.passwords.' . config('auth.defaults.passwords') . '.expire')]) }}
    </p>
    <p>{{ Lang::get('If you did not request a password reset, no further action is required.') }}</p>

</body>

</html>
