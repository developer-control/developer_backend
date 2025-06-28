<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class Developer extends Model
{
    use SoftDeletes;
    use HasRoles;
    protected $guard_name = 'web'; // atau 'developer', tergantung konfigurasimu
    protected $guarded = [];
    public function users()
    {
        return $this->hasMany(User::class);
    }
    // public function developerSubscriptions()
    // {
    //     return $this->hasMany(DeveloperSubscription::class, 'developer_id');
    // }
    // public function activeSubscriptions()
    // {
    //     return $this->hasMany(DeveloperSubscription::class)->where('status', 'active');
    // }
    // public function subscriptions()
    // {
    //     return $this->belongsToMany(
    //         Subscription::class,
    //         'developer_subscriptions',
    //         'developer_id', // Foreign key di tabel pivot yang mengacu ke Developer
    //         'subscription_id', // Foreign key di tabel pivot yang mengacu ke Subscription
    //     );
    // }
    // public function features()
    // {
    //     return $this->subscriptions()
    //         ->with('features') // Ambil fitur dari tiap subscription yang aktif
    //         ->get()
    //         ->pluck('features')
    //         ->flatten()
    //         ->unique('id');
    // }

}
