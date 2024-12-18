<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];
    /**
     * Interact with the user's first name.
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => $value ? strtolower($value) : null,
        );
    }
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
