<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Report;
use App\Models\RestockRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AssetController extends Controller
{
    public function index()
    {
        $data = Asset::all();
        return response()->json($data);
    }

    public function show($id)
    {
        $data = Asset::find($id);
        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required',
            'product_name' => 'required|string',
            'brand_name' => 'required|string',
            'thumbnail' => 'required|file|mimes:jpeg,png,jpg',
            'quantity' => 'required',
        ], [
            'supplier_id.required' => 'Supplier harus diisi.',
            'product_name.required' => 'Nama Produk harus diisi.',
            'brand_name.required' => 'Nama Brand harus diisi.',
            'thumbnail.required' => 'Thumbnail harus diunggah.',
            'quantity.required' => 'Jumlah barang harus diisi.',
        ]);

        try {
            $file = $request->file('thumbnail');
            $fileName = $file->getClientOriginalName();
            $filePathThumnbnail = $file->storeAs('thumbnails', $fileName, 'public');

            Asset::create([
                'supplier_id' => $request->supplier_id,
                'product_name' => $request->product_name,
                'brand_name' => $request->brand_name,
                'thumbnail' => $filePathThumnbnail,
                'quantity' => $request->quantity,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('ERROR', 'Gagal menambahkan data. Kesalahan: ' . $e->getMessage());
        }

        return redirect()->back()->with('SUCCESS', 'Berhasil menambahkan data.');
    }

    public function update(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        try {
            $asset->supplier_id = $request->supplier_id;
            $asset->product_name = $request->product_name;
            $asset->brand_name = $request->brand_name;
            $asset->quantity = $request->quantity;
            if ($request->hasFile('thumbnail')) {
                if ($asset->thumbnail) {
                    Storage::disk('public')->delete($asset->thumbnail);
                }
                $file = $request->file('thumbnail');
                $fileName = $file->getClientOriginalName();
                $filePathThumnbnail = $file->storeAs('thumbnails', $fileName, 'public');
                $asset->thumbnail = $filePathThumnbnail;
            }
            $asset->save();

            session()->flash('SUCCESS', 'Data berhasil diperbarui!');
            return response()->json(['message' => 'Data berhasil diperbarui!']);
        } catch (\Exception $e) {
            session()->flash('ERROR', 'Data gagal diperbarui!');
            return response()->json(['message' => 'Gagal memperbarui data!']);
        }
    }

    public function restock(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);
        $restockData = RestockRequest::where('assets_id', $asset->id)->latest()->first();

        try {
            $asset->quantity = $request->quantity;
            $asset->save();

            $restockData->status = array_search('Selesai', RestockRequest::getStatusOptions());
            $restockData->save();

            Report::create([
                'created_by' => auth()->id(),
                'product_report' => $asset->product_name,
                'brand_report' => $asset->brand_name,
                'quantity_report' => $asset->quantity,
                'date_report' => Carbon::now(),
                'description' => 'Barang masuk',
            ]);

            session()->flash('SUCCESS', 'Data berhasil diperbarui!');
            return response()->json(['message' => 'Data berhasil diperbarui!']);
        } catch (\Exception) {
            session()->flash('ERROR', 'Data gagal diperbarui!');
            return response()->json(['message' => 'Gagal memperbarui data!']);
        }
    }

    public function deplete(Request $request, $id)
    {
        $asset = Asset::findOrFail($id);

        try {
            $asset->quantity = $request->quantity;
            $asset->save();

            Report::create([
                'created_by' => auth()->id(),
                'product_report' => $asset->product_name,
                'brand_report' => $asset->brand_name,
                'quantity_report' => $asset->quantity,
                'date_report' => Carbon::now(),
                'description' => 'Barang keluar',
            ]);

            session()->flash('SUCCESS', 'Data berhasil diperbarui!');
            return response()->json(['message' => 'Data berhasil diperbarui!']);
        } catch (\Exception) {
            session()->flash('ERROR', 'Data gagal diperbarui!');
            return response()->json(['message' => 'Gagal memperbarui data!']);
        }
    }

    public function destroy($id)
    {
        try {
            $asset = Asset::find($id);

            if (!$asset) {
                session()->flash('ERROR', 'Asset tidak ditemukan');
                return response()->json([
                    'error' => true,
                    'message' => 'Asset tidak ditemukan',
                    'redirectUrl' => url()->previous(),
                ], 404);
            }

            $asset->restockRequests()->delete();
            $asset->delete();

            session()->flash('SUCCESS', 'Data Berhasil Dihapus');
            return response()->json([
                'success' => true,
                'redirectUrl' => url()->previous(),
            ], 200);
        } catch (\Exception) {
            session()->flash('ERROR', 'Data Gagal Dihapus');
            return response()->json([
                'error' => true,
                'message' => 'Data Gagal Dihapus',
                'redirectUrl' => url()->previous(),
            ], 500);
        }
    }
}
