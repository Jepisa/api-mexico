<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $table = 'municipalities';
    protected $primaryKey = 'key';
    public $incrementing = false;
    protected $fillable = ['key', 'name'];


    public function localities()
    {
        return $this->hasMany(Locality::class, 'municipality_id', 'key');
    }
}
