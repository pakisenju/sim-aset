<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Report;
use App\Models\RestockRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagesController extends Controller
{
    public function loginPage()
    {
        return view('pages.auth.login');
    }

    public function dashboardPage()
    {
        // Get the logged-in user
        $data['user'] = Auth::user();

        // Fetch total item types (distinct items in the assets table)
        $data['totalItemTypes'] = Asset::count();

        // Fetch total pending restocks (with status 'pending' in the restock_requests table)
        $data['pendingRestocks'] = RestockRequest::where('status', 'pending')->count();

        // Fetch total stock by summing the quantities in the assets table
        $data['totalStock'] = Asset::sum('quantity');

        // Fetch data for the chart
        $data['items'] = Asset::select('product_name', 'quantity')->get();

        return view('pages.dashboard.index', $data);
    }

    public function assetPage(Request $request)
    {
        $data['user'] = Auth::user();
        $assetQuery = Asset::with('supplier');
        $data['allProductNames'] = Asset::distinct()->pluck('product_name');
        $data['allBrandNames'] = Asset::distinct()->pluck('brand_name');
        $data['allSupplierNames'] = User::query()->role('supplier')->get();

        if ($request->filled('product_name')) {
            $assetQuery->where('product_name', $request->product_name);
        }

        if ($request->filled('brand_name')) {
            $assetQuery->where('brand_name', $request->brand_name);
        }

        $data['assets'] = $assetQuery->get();

        return view('pages.assets.index', $data);
    }

    public function detailAssetPage($id)
    {
        $user = Auth::user();
        $assets = Asset::findOrFail($id);

        $data = compact('assets', 'user');

        return view('pages.assets.detail', $data);
    }

    public function reportPage()
    {
        $data['user'] = Auth::user();

        $data['reports'] = Report::all();

        return view('pages.report.index', $data);
    }

    public function requestPage(Request $request)
    {
        $data['user'] = Auth::user();
        $roles = Auth::user()->roles->pluck('name');

        $data['assets'] = Asset::all();

        $requestQuery = RestockRequest::with('asset');
        $data['allStatus'] = RestockRequest::distinct()->pluck('status');

        if ($request->filled('status')) {
            $requestQuery->where('status', $request->status);
        }

        if ($roles->contains('supplier')) {
            $data['requests'] = $requestQuery->where('status', '2')
                ->whereHas('asset', function ($query) {
                    $query->where('supplier_id', Auth::user()->id);
                })
                ->get();
        } else {
            $data['requests'] = $requestQuery->get();
        }

        return view('pages.request.index', $data);
    }

    public function supplierPage(Request $request)
    {
        $data['user'] = Auth::user();
        $supplierQuery = User::query();
        $data['allNames'] = $supplierQuery->role('supplier')->distinct()->pluck('name');

        if ($request->filled('name')) {
            $supplierQuery->where('name', $request->name);
        }

        $data['suppliers'] = $supplierQuery->role('supplier')->get();

        return view('pages.supplier.index', $data);
    }
}
