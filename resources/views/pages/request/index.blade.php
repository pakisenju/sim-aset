@extends('layouts.dashboard-master')
@section('title', 'Permintaan Restock')
@section('style')
@endsection

@section('container')
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Restock Request</h1>
        </div>

        <div class="card shadow mt-4">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h6 class="m-0 font-weight-bold text-primary">Permintaan Restock</h6>
                @role('karyawan')
                    <a href="#" class="btn btn-success" id="createButton">
                        <i class="fas fa-fw fa-plus"></i>
                        Ajukan Restock
                    </a>
                @endrole
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center px-2">No</th>
                                <th class="text-center px-2">Barang</th>
                                <th class="text-center px-2">Supplier</th>
                                <th class="text-center px-2">Keterangan</th>
                                <th class="text-center px-2">Bukti</th>
                                <th class="text-center px-2">Status</th>
                                <th class="text-center px-2">Tanggal</th>
                                @role(['kepala_toko', 'supplier'])
                                    <th class="text-center px-2">Actions</th>
                                @endrole
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($requests as $index => $item)
                                <tr>
                                    <td class="text-center px-2">{{ $index + 1 }}</td>
                                    <td class="text-center px-2">
                                        {{ $item->asset->product_name }}
                                        -
                                        {{ $item->asset->brand_name }}
                                    </td>
                                    <td class="text-center px-2">{{ $item->asset->supplier->name }}</td>
                                    <td class="text-center px-2">{{ $item->description }}</td>
                                    <td class="text-center px-2">
                                        <div class="d-flex flex-column align-items-center">
                                            <img src="{{ asset('/storage/' . $item->evidance) }}" alt="Bukti Pengajuan"
                                                width="150" class="mb-2">
                                            <a href="{{ asset('/storage/' . $item->evidance) }}" target="_blank">
                                                Lihat Gambar
                                            </a>
                                        </div>
                                    </td>
                                    <td class="text-center px-2">
                                        @php
                                            $statusLabels = ['Proses', 'Tolak', 'Terima', 'Selesai'];
                                            $statusClasses = [
                                                'bg-warning', // Proses
                                                'bg-danger', // Tolak
                                                'bg-primary', // Terima
                                                'bg-success', // Selesai
                                            ];
                                        @endphp

                                        @if (isset($statusLabels[$item->status]))
                                            <span
                                                class="badge {{ $statusClasses[$item->status] }} text-white w-100">{{ $statusLabels[$item->status] }}</span>
                                        @else
                                            <span class="badge bg-secondary text-white w-100">Status Tidak Dikenal</span>
                                        @endif
                                    </td>
                                    <td class="text-center px-2">{{ $item->created_at->format('d M Y H:i') }}</td>
                                    @role('kepala_toko')
                                        @if ($item->status !== '0')
                                            <td class="text-center px-2">
                                                <i class="fas fa-fw fa-minus"></i>
                                            </td>
                                        @else
                                            <td class="text-center px-2">
                                                <button type="button"
                                                    class="my-1 btn btn-sm rounded btn-outline-warning acceptButton"
                                                    value="{{ $item->id }}" data-toggle="tooltip" data-placement="bottom"
                                                    title="Terima">
                                                    <i class="fas fa-fw fa-check"></i>
                                                </button>
                                                <button type="button"
                                                    class="my-1 btn btn-sm rounded btn-outline-danger rejectButton"
                                                    value="{{ $item->id }}" data-toggle="tooltip" data-placement="bottom"
                                                    title="Tolak">
                                                    <i class="fas fa-fw fa-times"></i>
                                                </button>
                                            </td>
                                        @endif
                                    @endrole
                                    @role('supplier')
                                        @if ($item->status !== '2')
                                            <td class="text-center px-2">
                                                <i class="fas fa-fw fa-minus"></i>
                                            </td>
                                        @else
                                            <td class="text-center px-2">
                                                <button type="button"
                                                    class="my-1 btn btn-sm rounded btn-outline-warning restockButton"
                                                    value="{{ $item->asset->id }}" data-toggle="tooltip"
                                                    data-placement="bottom" title="Restock">
                                                    <i class="fas fa-fw fa-cart-plus"></i>
                                                </button>
                                            </td>
                                        @endif
                                    @endrole
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('pages.request.modal-add')
    @include('pages.request.modal-restock')

    <div class="modal fade" id="actionModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">&times;</button>
                </div>
                <form id="actionForm" method="POST">
                    <div class="modal-body">
                        <p id="modalMessage"></p>
                    </div>
                    <div class="modal-footer">
                        @csrf
                        <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn" id="actionButton"></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#createButton").on("click", function() {
            $("#createModal").modal();

            var select = $('#assets_id');
            select.empty();
            select.append('<option value="">-- Pilih Barang --</option>');

            @foreach ($assets as $asset)
                select.append(
                    '<option value="{{ $asset->id }}">{{ $asset->product_name }} - {{ $asset->brand_name }}</option>'
                );
            @endforeach
        });

        $("#requestForm").on('submit', function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: '/request-restock/' + $('#assets_id').val(),
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    $('#createModal').modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    $('#createModal').modal('hide');
                    toastr.error(xhr.responseJSON ? xhr.responseJSON.message :
                        'Terjadi kesalahan pada server. Silakan coba lagi.',
                        'Error!', {
                            progressBar: true,
                            closeButton: true,
                            timeOut: 5000,
                            extendedTimeOut: 1000
                        });
                }
            });
        });

        $(document).ready(function() {
            $('.acceptButton, .rejectButton').on('click', function() {
                var itemId = $(this).val();
                var action = $(this).hasClass('acceptButton') ? 'accept' : 'reject';
                var title = action === 'accept' ? 'Terima Data' : 'Tolak Data';
                var message = action === 'accept' ? 'Apakah Anda yakin ingin menerima data ini?' :
                    'Apakah Anda yakin ingin menolak data ini?';
                var url = action === 'accept' ? '/request-accept/' + itemId : '/request-reject/' + itemId;

                $('#modalTitle').text(title);
                $('#modalMessage').text(message);
                $('#actionForm').attr('action', url);
                $('#actionButton').text(action === 'accept' ? 'Terima' : 'Tolak').addClass(action ===
                    'accept' ? 'btn-outline-success' : 'btn-outline-danger');
                $('#actionModal').modal('show');

                $('#actionForm').off('submit').on('submit', function(e) {
                    e.preventDefault();

                    $.post($(this).attr('action'), $(this).serialize())
                        .done(function(response) {
                            $('#actionModal').modal('hide');
                            location.reload();
                        })
                        .fail(function() {
                            showToast('Terjadi kesalahan, silakan coba lagi.', 'bg-danger');
                        });
                });
            });
        });

        $(".restockButton").on("click", function() {
            const id = $(this).val();
            const url = "{{ url('/show-asset/') }}/" + id;

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    console.log(data);
                    $("#edit_id").val(data.id);
                    $("#prevQuantity").val(data.quantity);
                    $("#quantity").val(data.quantity);
                    $("#restockForm").attr("action", "{{ url('/restock-asset/') }}/" + id);
                    $("#restockModal").modal();
                },
                error: function(xhr) {
                    console.error(xhr);
                    alert('Terjadi kesalahan saat mengambil data.');
                }
            });
        });

        $(document).on("submit", "#restockForm", function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            var previousQuantity = $("#prevQuantity").val();
            var newQuantity = $("#quantity").val();

            if (previousQuantity >= newQuantity) {
                if ($("#error-message").length === 0) {
                    $(".modal-body").append(
                        '<div id="error-message" class="text-danger">Mohon melakukan restock data</div>');
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
                    $("#restockModal").modal('hide');
                    location.reload();
                },
                error: function(xhr) {
                    console.error(xhr);
                    alert('Terjadi kesalahan saat menyimpan data: ' + xhr.responseText);
                }
            });
        });
    </script>

@endsection
