@extends('layouts.dashboard-master')
@section('title', 'Detail Data')
@section('style')
@endsection

@section('container')
    <div class="container-fluid">
        {{-- <div class="row">
    </div> --}}
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <a href="{{ route('asset') }}" class="text-secondary">Asset Data</a> / Detail
            </h1>
        </div>

        <div class="card shadow mt-4">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{ $assets->product_name }}</h6>
            </div>
            <div class="card mb-4">
                <div class="card-body">
                    <div class="w-100 d-flex flex-column align-items-center mt-2">
                        <img src="{{ asset('/storage/' . $assets->thumbnail) }}" alt="thumbnail" class="text-center"
                            style="width: 60%; height: auto; object-fit: cover" />
                        <a href="{{ asset('/storage/' . $assets->thumbnail) }}" target="_blank" class="btn btn-success mt-2">
                            Lihat gambar
                        </a>
                    </div>
                    <h5 class="card-action-title mt-3 mb-0">
                        <strong>Data Barang</strong>
                    </h5>
                    <ul class="list-unstyled mt-3">
                        <li class="d-flex align-items-center mb-2">
                            <i data-feather="check-square"></i>
                            <strong class="fw-medium text-heading">Nama Barang :</strong>
                            <span class="pl-1">{{ $assets->product_name }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <i data-feather="check-square"></i>
                            <strong class="fw-medium text-heading">Nama Merk :</strong>
                            <span class="pl-1">{{ $assets->brand_name }}</span>
                        </li>
                        <li class="d-flex align-items-center mb-2">
                            <i data-feather="check-square"></i>
                            <strong class="fw-medium text-heading">Jumlah Stok :</strong>
                            <span class="pl-1">{{ $assets->quantity }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <!--/ About User -->
        </div>
    </div>

    {{-- @include('pages.assets.modal-add') --}}
@endsection

@section('script')
    <script>
        $("#createButton").on("click", function() {
            $("#createModal").modal();
        });
    </script>
@endsection
