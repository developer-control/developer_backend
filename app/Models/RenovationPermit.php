<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RenovationPermit extends Model
{
    protected $fillable = [
        'user_id',
        'project_unit_id',
        'developer_id',
        'title',
        'id_card_photo',
        'unit_layout',
        'neighborhood_certificate',
        'power_of_attorney',
        'permit_letter',
        'deposit_statement',
        'neighbor_information',
        'status',
        'notes'
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function projectUnit()
    {
        return $this->belongsTo(ProjectUnit::class, 'project_unit_id');
    }
    public function developer()
    {
        return $this->belongsTo(Developer::class, 'developer_id');
    }
}
