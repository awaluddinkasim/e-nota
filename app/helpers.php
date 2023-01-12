<?php

use App\Models\Nota;
use App\Models\Toko;

function getNomorNota($tokoID)
{
    $toko = Toko::find($tokoID);
    $nota = Nota::where('toko_id', $toko->id)->whereMonth('created_at', date('m'))->orderBy('created_at', 'DESC')->first();
    if ($nota) {
        $nomor = explode("/", $nota->nomor)[0] + 1;
    } else {
        $nomor = 1;
    }

    return sprintf("%04s", $nomor) . '/' . $toko->kode . '/' . date('m') . '/' . date('Y');
}
