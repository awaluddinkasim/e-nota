<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    public function nota()
    {
        return $this->hasMany(Nota::class, 'customer_id');
    }

    public function pedagang()
    {
        return $this->belongsTo(User::class, 'registered_by');
    }

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'toko_id');
    }
}
