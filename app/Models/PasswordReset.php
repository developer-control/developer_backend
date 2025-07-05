<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PasswordReset extends Model
{
    protected $table = 'password_reset_tokens';
    protected $guarded = [];
    public $timestamps = false;
    public function developer()
    {
        return $this->belongsTo(Developer::class, 'developer_id');
    }
}
