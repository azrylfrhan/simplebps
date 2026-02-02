<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Konfigurasi;

class KonfigurasiController extends Controller
{
    public function index() {
        $config = Konfigurasi::pluck('value', 'key')->toArray();
        return view('konfigurasi.index', compact('config'));
    }

    public function update(Request $request) {
        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            Konfigurasi::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'Pengaturan tanda tangan berhasil diperbarui.');
    }
}
