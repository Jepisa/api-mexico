<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettlementType extends Model
{
    protected $table = 'settlement_types';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];
    protected $hidden = ['id'];

    public function settlements()
    {
        return $this->hasMany(Settlement::class, 'settlement_type_id', 'id');
    }
}
