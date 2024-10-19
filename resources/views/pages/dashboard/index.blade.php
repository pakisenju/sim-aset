@extends('layouts.dashboard-master')
@section('title', 'Dashboard')
@section('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.css"
        integrity="sha512-hq+LhNbxhvUilU5czhrXFN8XZZg3ahbNiVXI2wCDpoFP9M0oG3KhMyUn4LZyD5pjICu76S3YoFZBGwnRzSpq3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('container')
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>

        <!-- Content Row -->
        <div class="row">
            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Jenis Barang
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalItemTypes }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-box fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Stok Barang
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalStock }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-cubes fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Pengajuan Restock
                                    Pending</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingRestocks }}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-inbox fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Jumlah Stok Barang per Jenis</h6>
                    </div>
                    <div class="card-body">
                        <canvas id="itemChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Data Table Row -->
        <div class="card shadow mt-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Barang</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered m-0" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th class="text-center">Nama Barang</th>
                                <th class="text-center">Jumlah Stok</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($items as $index => $item)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td class="text-center">{{ $item->product_name }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"
        integrity="sha512-QSkVNOCYLtjEUTdw5L9Gr5p6Vhs5O9ZLrf0UuDk/AVUFhwhcGqlZkpAXCDTmZfD5tX3Z5i9uI5r6U/W8n2U2w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure data is properly formatted before use in Chart.js
            const itemNames = @json($items->pluck('product_name')->toArray());
            const itemQuantities = @json($items->pluck('quantity')->toArray());

            // Check if data is correctly loaded
            console.log("Item Names:", itemNames);
            console.log("Item Quantities:", itemQuantities);

            // Initialize Chart.js
            const ctx = document.getElementById('itemChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: itemNames,
                    datasets: [{
                        label: 'Jumlah Stok',
                        data: itemQuantities,
                        backgroundColor: 'rgba(54, 162, 235, 0.6)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Jumlah Stok'
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Nama Barang'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection
