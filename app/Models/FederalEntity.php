<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FederalEntity extends Model
{
    protected $table = 'federal_entities';
    protected $primaryKey = 'key';
    public $incrementing = false;

    protected $fillable = ['key', 'name', 'code'];

    public function localities()
    {
        return $this->hasMany(Locality::class, 'federal_entity_id', 'key');
    }
}
