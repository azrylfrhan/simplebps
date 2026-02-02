<?php
namespace App\Http\Controllers;
use App\Models\Tim;
use Illuminate\Http\Request;

class TimController extends Controller
{
    public function index() {
        $tim = Tim::with('pegawai')->orderBy('nama_tim')->get();
        return view('tim.index', compact('tim'));
    }

    public function store(Request $request) {
        $request->validate([
            'nama_tim' => 'required|unique:tim,nama_tim|max:100',
            'ketua_tim' => 'nullable|max:100'
        ]);

        Tim::create($request->all());
        return back()->with('success', "Tim '{$request->nama_tim}' berhasil ditambahkan.");
    }

    public function update(Request $request, $id) {
        $tim = Tim::findOrFail($id);
        $request->validate([
            'nama_tim' => 'required|max:100|unique:tim,nama_tim,'.$id,
            'ketua_tim' => 'nullable|max:100'
        ]);

        $tim->update($request->all());
        return back()->with('success', 'Data tim diperbarui.');
    }

    public function destroy($id) {
        try {
            Tim::destroy($id);
            return back()->with('success', 'Tim berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus. Mungkin ada pegawai/user di tim ini.');
        }
    }
}
