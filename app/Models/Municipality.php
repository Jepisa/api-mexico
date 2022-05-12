<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $table = 'municipalities';
    protected $primaryKey = 'id';
    protected $fillable = ['key', 'name'];
    protected $hidden = ['id'];

    public function localities()
    {
        return $this->hasMany(Locality::class, 'municipality_id', 'id');
    }
}
