@extends('layouts.app')

@section('content')
<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0"><i class="fas fa-file-excel me-2"></i>Import Presensi</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-warning">
            <strong>Perhatian:</strong> Pastikan file Excel sesuai format (Nama, Tanggal, Jam Mulai, Jam Selesai). Sistem hanya memproses data yang sudah disetujui Kabag.
        </div>
        <form action="{{ route('lembur.import') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="form-label">Pilih File Excel (.xlsx)</label>
                <input type="file" name="file_excel" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Mulai Sinkronisasi</button>
            <a href="{{ route('rekap_presensi') }}" class="btn btn-light border">Batal</a>
        </form>
    </div>
</div>
@endsection
