@extends('layouts.dashboard-master')
@section('title', 'Supplier')
@section('style')
@endsection

@section('container')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Supplier</h1>
        </div>

        <div class="card shadow mt-4">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Supplier</h6>
                @role('kepala_toko')
                    <a href="#" class="btn btn-success" id="createButton">
                        <i class="fas fa-fw fa-plus"></i>
                        Tambah Data
                    </a>
                @endrole
            </div>
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <form method="GET" action="{{ route('supplier') }}" class="d-flex" style="width: 100%">
                    <select name="name" id="name" class="form-control mr-3">
                        <option value="">Nama Supplier</option>
                        @foreach ($allNames as $name)
                            <option value="{{ $name }}" {{ request('name') == $name ? 'selected' : '' }}>
                                {{ $name }}
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
                                <th class="text-center px-2">Nama Pemasok</th>
                                <th class="text-center px-2">Email</th>
                                <th class="text-center px-2">Username</th>
                                @role('kepala_toko')
                                    <th class="text-center px-2" style="width: 15%">Actions</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers as $index => $item)
                                <tr class="align-items-center">
                                    <td class="text-center px-2">{{ $index + 1 }}</td>
                                    <td class="text-center px-2">{{ $item->name }}</td>
                                    <td class="text-center px-2">{{ $item->email }}</td>
                                    <td class="text-center px-2">{{ $item->username }}</td>
                                    @role('kepala_toko')
                                        <td class="text-center px-2">
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('pages.supplier.modal-add')
    @include('pages.supplier.modal-edit')
    @include('pages.supplier.modal-delete')
@endsection

@section('script')
    <script>
        $("#createButton").on("click", function() {
            $("#createModal").modal();
        });

        $(document).on("click", "#editButton", function() {
            const id = $(this).val();
            const url = "{{ url('/show-supplier/') }}/" + id;

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    console.log(data);
                    $("#edit_id").val(data.id);
                    $("#supplierName").val(data.name);
                    $("#supplierEmail").val(data.email);
                    $("#supplierUsername").val(data.username);
                    $("#editForm").attr("action", "{{ url('/update-supplier/') }}/" + id);
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

        $(document).on("click", "#deleteButton", function() {
            let id = $(this).val();
            $("#deleteForm").attr("action", "{{ url('/destroy-supplier/') }}/" + id);
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
