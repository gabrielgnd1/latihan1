@extends('layouts.app')

@section('content')
<h1>Dashboard Utama</h1>

<hr>
<h4>1. Top 5 Barang Yang Paling Laku</h4>
    <div class="row">
        <!-- Top 5 Barang -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Top 5 Barang Terlaris</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($topBarangs as $barang)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $barang->nama }}
                                <span class="badge bg-primary rounded-pill">{{ $barang->total_terjual }} terjual</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <hr>
        <h4>2. Top 1 Kategori Paling Laku</h4>
        <!-- Top Kategori -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Kategori Terlaris</h5>
                </div>
                <div class="card-body">
                    @if($topKategori)
                        <div class="d-flex justify-content-between align-items-center">
                            <h3>{{ $topKategori->nama }}</h3>
                            <span class="badge bg-success">{{ $topKategori->total_terjual }} item terjual</span>
                        </div>
                    @else
                        <p>Tidak ada data kategori</p>
                    @endif
                </div>
            </div>
        </div>

        <hr>
        <h4>3. Top 3 Spender (Total Nominal Pembelian Terbanyak)</h4>
        <!-- Top 3 Spenders -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Top 3 Spenders</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        @foreach($topSpenders as $spender)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $spender->nama }}
                                <span class="badge bg-warning text-dark">Rp {{ number_format($spender->total_pembelian, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>

        <hr>
        <h4>4. Top Buyer (Total Item Pembelian Terbanyak)</h4>
        <!-- Top Buyer -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Top Buyer (Jumlah Item)</h5>
                </div>
                <div class="card-body">
                    @if($topBuyer)
                        <div class="d-flex justify-content-between align-items-center">
                            <h3>{{ $topBuyer->nama }}</h3>
                            <span class="badge bg-info">{{ $topBuyer->total_items }} items</span>
                        </div>
                    @else
                        <p>Tidak ada data pembeli</p>
                    @endif
                </div>
            </div>
        </div>

        <hr>
        <h4>6. Rata-rata Total Pembelian 3 Bulan Terakhir</h4>
        <!-- Last 3 Months Average -->
        <div class="col-12 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Rata-rata Pembelian 3 Bulan Terakhir</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Bulan</th>
                                    <th>Rata-rata Pembelian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($averageLastThreeMonths as $month)
                                    <tr>
                                        <td>{{ $month->bulan }}</td>
                                        <td>Rp {{ number_format($month->rata_rata, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <h4>7. Total Pembelian Terbesar dari Pelanggan Wanita</h4>
        <!-- Women Top Buyers -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Top Pembeli Wanita</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Total Pembelian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topWomenBuyers as $buyer)
                                    <tr>
                                        <td>{{ $buyer->nama }}</td>
                                        <td>Rp {{ number_format($buyer->total_pembelian, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <h4>9. Karyawan dengan Rata-rata Penjualan Terbesar per Bulan</h4>
        <!-- Employee Performance -->
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">Karyawan Terbaik per Bulan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Bulan</th>
                                    <th>Nama</th>
                                    <th>Rata-rata Penjualan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topEmployeesByMonth as $employee)
                                    <tr>
                                        <td>{{ $employee->bulan }}</td>
                                        <td>{{ $employee->nama }}</td>
                                        <td>Rp {{ number_format($employee->rata_rata_penjualan, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <hr>
        <h4>10. Daftar Karyawan yang Berhak Menerima Bonus Tahunan</h4>
        <!-- Employee Bonuses -->
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Bonus Karyawan</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Bonus Bulanan</th>
                                    <th>Bonus Kinerja</th>
                                    <th>Total Bonus</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employeeBonuses as $bonus)
                                    <tr>
                                        <td>{{ $bonus->nama }}</td>
                                        <td>Rp {{ number_format($bonus->bonus_bulanan, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($bonus->bonus_kinerja, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($bonus->total_bonus, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection