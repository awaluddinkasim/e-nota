<?php

use App\Models\Nota;
use App\Models\Toko;

function getNomorNota($tokoID)
{
    $toko = Toko::find($tokoID);
    $nomor = Nota::where('toko_id', $toko->id)->whereMonth('created_at', date('m'))->get()->count() + 1;

    return sprintf("%04s", $nomor) . '/' . $toko->kode . '/' . date('m') . '/' . date('Y');
}
