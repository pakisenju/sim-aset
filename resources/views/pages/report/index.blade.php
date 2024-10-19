@extends('layouts.dashboard-master')
@section('title', 'Laporan Barang')
@section('style')
@endsection

@section('container')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Asset Report</h1>
        </div>

        <div class="card shadow mt-4">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h6 class="m-0 font-weight-bold text-primary">Laporan Data Barang</h6>
                <button class="btn btn-primary" id="exportButton">Export to Excel</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered m-0" id="reportTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center px-2">No</th>
                                <th class="text-center px-2">Nama Barang</th>
                                <th class="text-center px-2">Merk</th>
                                <th class="text-center px-2">Jumlah Stok</th>
                                <th class="text-center px-2">Keterangan</th>
                                <th class="text-center px-2">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $index => $item)
                                <tr>
                                    <td class="text-center px-2">{{ $index + 1 }}</td>
                                    <td class="text-center px-2">{{ $item->product_report }}</td>
                                    <td class="text-center px-2">{{ $item->brand_report }}</td>
                                    <td class="text-center px-2">{{ $item->quantity_report }}</td>
                                    <td class="text-center px-2">{{ $item->description }}</td>
                                    <td class="text-center px-2">{{ $item->date_report }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script>
        document.getElementById('exportButton').addEventListener('click', function() {
            Swal.fire({
                title: 'Export to Excel',
                text: "Apakah Anda ingin export data ke Excel?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4e73df',
                cancelButtonColor: '#e74a3b',
                confirmButtonText: 'Yes!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var table = document.getElementById('reportTable');
                    var workbook = XLSX.utils.table_to_book(table, {
                        sheet: "Laporan Data Barang"
                    });
                    XLSX.writeFile(workbook, 'Laporan_Data_Barang.xlsx');

                    Swal.fire(
                        'Exported!',
                        'Your file has been exported.',
                        'success'
                    );
                }
            });
        });
    </script>
@endsection
