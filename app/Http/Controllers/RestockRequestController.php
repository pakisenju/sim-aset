<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Report;
use App\Models\RestockRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RestockRequestController extends Controller
{
    public function show($id)
    {
        $data = RestockRequest::find($id);
        return response()->json($data);
    }

    public function store(Request $request, $id)
    {
        $asset = Asset::find($id);

        $request->validate([
            'description' => 'required|string',
            'evidance' => 'required|file|mimes:jpeg,png,jpg',
        ], [
            'description.required' => 'Nama Produk harus diisi.',
            'evidance.required' => 'Bukti harus diunggah.',
        ]);

        $existingRequest = RestockRequest::where('assets_id', $asset->id)
            ->whereIn('status', [
                array_search('Proses', RestockRequest::getStatusOptions()),
                array_search('Terima', RestockRequest::getStatusOptions())
            ])
            ->first();

        if ($existingRequest) {
            session()->flash('ERROR', 'Gagal menerima pengajuan!');
            return response()->json(['message' => 'Restock barang sudah diajukan dan sedang dalam proses.'], 400);
        }

        try {
            $file = $request->file('evidance');
            $fileName = $file->getClientOriginalName();
            $filePathEvidance = $file->storeAs('evidances', $fileName, 'public');

            RestockRequest::create([
                'assets_id' => $asset->id,
                'description' => $request->description,
                'evidance' => $filePathEvidance,
                'status' => array_search('Proses', RestockRequest::getStatusOptions()),
            ]);

            session()->flash('SUCCESS', 'Berhasil mengajukan restock barang.');
            return response()->json(['message' => 'Berhasil mengajukan restock barang.']);
        } catch (\Exception $e) {
            session()->flash('ERROR', 'Gagal mengajukan restock barang. Kesalahan: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal mengajukan restock barang. Kesalahan: ' . $e->getMessage()], 500);
        }
    }

    public function accept($id)
    {
        $restockData = RestockRequest::find($id);
        $assetData = Asset::find($restockData->assets_id);

        if (!$restockData || !$assetData) {
            session()->flash('ERROR', 'Data tidak ditemukan!');
            return response()->json(['message' => 'Data tidak ditemukan!']);
        }

        try {
            $restockData->status = array_search('Terima', RestockRequest::getStatusOptions());
            $restockData->save();

            session()->flash('SUCCESS', 'Pengajuan berhasil diterima!');
            return response()->json(['message' => 'Pengajuan berhasil diterima!']);
        } catch (\Exception) {
            session()->flash('ERROR', 'Gagal menerima pengajuan!');
            return response()->json(['message' => 'Gagal menerima pengajuan!']);
        }
    }

    public function reject($id)
    {
        $restockData = RestockRequest::find($id);
        $assetData = Asset::find($restockData->assets_id);

        if (!$restockData || !$assetData) {
            session()->flash('ERROR', 'Data tidak ditemukan!');
            return response()->json(['message' => 'Data tidak ditemukan!']);
        }

        try {
            $restockData->status = array_search('Tolak', RestockRequest::getStatusOptions());
            $restockData->save();

            session()->flash('SUCCESS', 'Pengajuan berhasil ditolak!');
            return response()->json(['message' => 'Pengajuan berhasil ditolak!']);
        } catch (\Exception) {
            session()->flash('ERROR', 'Gagal menolak pengajuan!');
            return response()->json(['message' => 'Gagal menolak pengajuan!']);
        }
    }
}
