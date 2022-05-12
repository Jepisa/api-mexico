<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locality extends Model
{
    protected $table = 'localities';
    protected $primaryKey = 'id';
    protected $fillable = ['zip_code', 'locality', 'federal_entity_id', 'municipality_id'];
    protected $hidden = ['id', 'federal_entity_id', 'municipality_id', 'created_at', 'updated_at', ];

    public function federal_entity()
    {
        return $this->belongsTo(FederalEntity::class, 'federal_entity_id', 'key');
    }

    public function settlements()
    {
        return $this->hasMany(Settlement::class, 'locality_id', 'id')->orderBy('key');
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class, 'municipality_id', 'id');
    }
}
