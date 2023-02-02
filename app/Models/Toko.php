<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Toko extends Model
{
    use HasFactory;
    protected $table = 'toko';

    public function nota()
    {
        return $this->hasMany(Nota::class, 'toko_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin');
    }

    public function pedagang()
    {
        return $this->hasMany(User::class, 'toko_id');
    }
}
