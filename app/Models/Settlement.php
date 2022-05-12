<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    protected $table = 'settlements';
    protected $primaryKey = 'id';
    protected $fillable = ['key', 'name', 'zone_type','locality_id', 'settlement_type_id'];
    protected $hidden = ['id', 'locality_id', 'settlement_type_id', 'created_at', 'updated_at'];

    public function settlement_type()
    {
        return $this->belongsTo(SettlementType::class, 'settlement_type_id', 'id');
    }

    public function locality()
    {
        return $this->belongsTo(Locality::class, 'locality_id', 'id');
    }
}
