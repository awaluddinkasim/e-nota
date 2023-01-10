<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Nota extends Model
{
    use HasFactory;

    protected $table = "nota";
    protected $with = ['customer', 'gabah', 'items'];
    protected $appends = ['tanggal', 'total_harga'];

    public function toko()
    {
        return $this->belongsTo(Toko::class, 'toko_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function gabah()
    {
        return $this->belongsTo(Gabah::class, 'gabah_id');
    }

    public function items()
    {
        return $this->hasMany(NotaItem::class, 'nota_id');
    }

    public function totalHarga(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->items->sum('harga'),
        );
    }

    public function tanggal(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->created_at)->isoFormat('D MMMM YYYY'),
        );
    }

    public function year(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->created_at)->year,
        );
    }
}
