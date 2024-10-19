@extends('layouts.dashboard-master')
@section('title', 'Asset Data')
@section('style')
@endsection

@section('container')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Asset Data</h1>
        </div>

        <div class="card shadow mt-4">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Data Barang</h6>
                @role('kepala_toko')
                    <a href="#" class="btn btn-success" id="createButton">
                        <i class="fas fa-fw fa-plus"></i>
                        Tambah Data
                    </a>
                @endrole
            </div>
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <form method="GET" action="{{ route('asset') }}" class="d-flex" style="width: 100%">
                    <select name="product_name" id="product_name" class="form-control mr-3">
                        <option value="">Barang</option>
                        @foreach ($allProductNames as $productName)
                            <option value="{{ $productName }}"
                                {{ request('product_name') == $productName ? 'selected' : '' }}>
                                {{ $productName }}
                            </option>
                        @endforeach
                    </select>

                    <select name="brand_name" id="brand_name" class="form-control mr-3">
                        <option value="">Merk</option>
                        @foreach ($allBrandNames as $brandName)
                            <option value="{{ $brandName }}" {{ request('brand_name') == $brandName ? 'selected' : '' }}>
                                {{ $brandName }}
                            </option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-outline-primary" style="width: 20%">
                        <i class="fas fa-fw fa-search"></i>
                        Cari
                    </button>
                </form>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center px-2">No</th>
                                <th class="text-center px-2">Pemasok</th>
                                <th class="text-center px-2">Nama Barang</th>
                                <th class="text-center px-2">Merk</th>
                                <th class="text-center px-2">Gambar</th>
                                <th class="text-center px-2">Jumlah Stok</th>
                                <th class="text-center px-2" style="width: 15%">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assets as $index => $item)
                                <tr class="align-items-center">
                                    <td class="text-center px-2">{{ $index + 1 }}</td>
                                    <td class="text-center px-2">
                                        {{ $item->supplier ? $item->supplier->name : 'Tanpa Nama' }}</td>
                                    <td class="text-center px-2">{{ $item->product_name }}</td>
                                    <td class="text-center px-2">{{ $item->brand_name }}</td>
                                    <td class="text-center px-2">
                                        <img src="{{ asset('/storage/' . $item->thumbnail) }}"
                                            alt="{{ $item->product_name }}" width="150">
                                    </td>
                                    <td class="text-center px-2">{{ $item->quantity }}</td>
                                    @role('kepala_toko')
                                        <td class="text-center px-2">
                                            <a href="{{ route('detail.asset', ['id' => $item->id]) }}"
                                                class="my-1 btn btn-sm rounded btn-outline-primary">
                                                <i class="fas fa-fw fa-search"></i>
                                            </a>
                                            <button type="button" class="my-1 btn btn-sm rounded btn-outline-warning"
                                                value="{{ $item->id }}" id="editButton" data-toggle="tooltip"
                                                data-placement="bottom" title="Edit">
                                                <i class="fas fa-fw fa-pen"></i>
                                            </button>
                                            <button type="button" class="my-1 btn btn-sm rounded btn-outline-danger"
                                                value="{{ $item->id }}" id="deleteButton" data-toggle="tooltip"
                                                data-placement="bottom" title="Hapus">
                                                <i class="fas fa-fw fa-trash"></i>
                                            </button>
                                        </td>
                                    @endrole
                                    @role('karyawan')
                                        <td class="text-center px-2">
                                            <button type="button"
                                                class="my-1 btn btn-sm rounded btn-outline-warning depleteButton"
                                                value="{{ $item->id }}" data-toggle="tooltip" data-placement="bottom"
                                                title="Deplete">
                                                <i class="fas fa-fw fa-cart-arrow-down"></i>
                                            </button>
                                        </td>
                                    @endrole
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('pages.assets.modal-add')
    @include('pages.assets.modal-edit')
    @include('pages.assets.modal-delete')
    @include('pages.assets.modal-deplete')
@endsection

@section('script')
    <script>
        $("#createButton").on("click", function() {
            $("#createModal").modal();
        });

        $(document).on("click", "#editButton", function() {
            const id = $(this).val();
            const url = "{{ url('/show-asset/') }}/" + id;

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    console.log(data);
                    $("#edit_id").val(data.id);
                    $("#supplierid").val(data.supplier_id);
                    $("#productName").val(data.product_name);
                    $("#brandName").val(data.brand_name);
                    $("#quantity").val(data.quantity);

                    if (data.thumbnail) {
                        $("#photoPreview").attr("src", "{{ asset('/storage') }}/" + data.thumbnail)
                            .show();
                    } else {
                        $("#photoPreview").hide();
                    }
                    $("#editForm").attr("action", "{{ url('/update-asset/') }}/" + id);
                    $("#editModal").modal();
                },
                error: function(xhr) {
                    console.error(xhr);
                    alert('Terjadi kesalahan saat mengambil data.');
                }
            });
        });

        $(document).on("submit", "#editForm", function(e) {
            e.preventDefault();
            var formData = new FormData(this);

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#editModal").modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    console.error(xhr);
                    alert('Terjadi kesalahan saat menyimpan data: ' + xhr.responseText);
                }
            });
        });

        $(".depleteButton").on("click", function() {
            const id = $(this).val();
            const url = "{{ url('/show-asset/') }}/" + id;

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    console.log(data);
                    $("#edit_id").val(data.id);
                    $("#prevQuantity").val(data.quantity);
                    $("#depleteQuantity").val(data.quantity);
                    $("#depleteForm").attr("action", "{{ url('/deplete-asset/') }}/" + id);
                    $("#depleteModal").modal();
                },
                error: function(xhr) {
                    console.error(xhr);
                    alert('Terjadi kesalahan saat mengambil data.');
                }
            });
        });

        $(document).on("submit", "#depleteForm", function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var previousQuantity = $("#prevQuantity").val();
            var newQuantity = $("#depleteQuantity").val();

            if (previousQuantity < newQuantity) {
                if ($("#error-message").length === 0) {
                    $(".modal-body").append(
                        '<div id="error-message" class="text-danger">Mohon melakukan pengurangan data</div>');
                }
                return;
            } else {
                $("#error-message").remove();
            }

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $("#depleteModal").modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    console.error(xhr);
                    alert('Terjadi kesalahan saat menyimpan data: ' + xhr.responseText);
                }
            });
        });

        $(document).on("click", "#deleteButton", function() {
            let id = $(this).val();
            $("#deleteForm").attr("action", "{{ url('/destroy-asset/') }}/" + id);
            $("#deleteModal").modal();
        });

        $('#deleteForm').on('submit', function(e) {
            e.preventDefault();

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: $(this).serialize(),
                success: function(response) {
                    if (response.success) {
                        window.location.href = response.redirectUrl;
                    } else {
                        alert(response.message);
                    }
                },
                error: function(xhr) {
                    alert('Terjadi kesalahan saat menghapus data. Silakan coba lagi.');
                }
            });
        });
    </script>
@endsection
