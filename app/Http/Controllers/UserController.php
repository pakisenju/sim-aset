<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function show($id)
    {
        $data = User::find($id);
        return response()->json($data);
    }

    public function supplierStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username' => $request->username,
                'password' => Hash::make($request->password),
            ]);

            $user->assignRole('supplier');

            return redirect()->back()->with('SUCCESS', 'Berhasil menambahkan data.');
        } catch (\Exception $e) {
            return redirect()->back()->with('ERROR', 'Gagal menambahkan data. Kesalahan: ' . $e->getMessage());
        }
    }

    public function supplierUpdate(Request $request, $id)
    {
        $user = User::findOrFail($id);

        try {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->username = $request->username;
            $user->password = $request->password;
            $user->save();

            session()->flash('SUCCESS', 'Data berhasil diperbarui!');
            return response()->json(['message' => 'Data berhasil diperbarui!']);
        } catch (\Exception) {
            session()->flash('ERROR', 'Data gagal diperbarui!');
            return response()->json(['message' => 'Gagal memperbarui data!']);
        }
    }

    public function supplierDestroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            session()->flash('ERROR', 'User tidak ditemukan');
            return response()->json([
                'error' => true,
                'message' => 'User tidak ditemukan',
                'redirectUrl' => url()->previous(),
            ], 404);
        }

        $assets = $user->assets;

        try {
            if ($assets->isNotEmpty()) {
                foreach ($assets as $asset) {
                    Report::create([
                        'created_by' => auth()->id(),
                        'product_report' => $asset->product_name,
                        'brand_report' => $asset->brand_name,
                        'quantity_report' => $asset->quantity,
                        'date_report' => Carbon::now(),
                        'description' => 'Supplier dihapus',
                    ]);
                }

                $user->assets()->delete();
            }

            $user->delete();

            session()->flash('SUCCESS', 'Data Berhasil Dihapus');
            return response()->json([
                'success' => true,
                'redirectUrl' => url()->previous(),
            ], 200);
        } catch (\Exception $e) {
            session()->flash('ERROR', 'Data Gagal Dihapus: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => 'Data Gagal Dihapus',
                'redirectUrl' => url()->previous(),
            ], 500);
        }
    }
}
