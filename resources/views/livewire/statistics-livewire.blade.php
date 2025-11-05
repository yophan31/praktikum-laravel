<div class="mt-3">
    <div class="card mb-3">
        <div class="card-header">
            <a href="{{ route('app.transactions') }}" class="text-decoration-none">
                <small class="text-muted">← Kembali ke Daftar Transaksi</small>
            </a>
            <h3 class="mt-2">📊 Statistik Keuangan</h3>
        </div>
        <div class="card-body">
            {{-- Filter Bulan & Tahun --}}
            <div class="row mb-4">
                <div class="col-md-3">
                    <label class="form-label">Bulan</label>
                    <select class="form-select" wire:model.live="filterMonth">
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tahun</label>
                    <select class="form-select" wire:model.live="filterYear">
                        @for ($year = date('Y'); $year >= date('Y') - 5; $year--)
                            <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h6 class="card-title">💵 Total Pemasukan</h6>
                            <h3 class="mb-0">Rp {{ number_format($totalIncome, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-danger text-white">
                        <div class="card-body">
                            <h6 class="card-title">💸 Total Pengeluaran</h6>
                            <h3 class="mb-0">Rp {{ number_format($totalExpense, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card {{ $balance >= 0 ? 'bg-primary' : 'bg-warning' }} text-white">
                        <div class="card-body">
                            <h6 class="card-title">💰 Saldo</h6>
                            <h3 class="mb-0">Rp {{ number_format($balance, 0, ',', '.') }}</h3>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Charts --}}
            <div class="row mb-4">
                {{-- Pie Chart - Category --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5>📈 Transaksi per Kategori</h5>
                            <div id="categoryChart"></div>
                        </div>
                    </div>
                </div>

                {{-- Bar Chart - Monthly Trend --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5>📊 Tren Bulanan (12 Bulan Terakhir)</h5>
                            <div id="monthlyChart"></div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Recent Transactions --}}
            <div class="card">
                <div class="card-body">
                    <h5>🕐 Transaksi Terbaru</h5>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Tipe</th>
                                    <th class="text-end">Nominal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentTransactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->transaction_date->format('d M Y') }}</td>
                                        <td>{{ $transaction->title }}</td>
                                        <td><span class="badge bg-secondary">{{ $transaction->category }}</span></td>
                                        <td>
                                            @if ($transaction->type === 'income')
                                                <span class="badge bg-success">Pemasukan</span>
                                            @else
                                                <span class="badge bg-danger">Pengeluaran</span>
                                            @endif
                                        </td>
                                        <td class="text-end">
                                            <strong class="{{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                                                {{ $transaction->type === 'income' ? '+' : '-' }}
                                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                            </strong>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Belum ada data transaksi</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('livewire:init', () => {
        Livewire.hook('morph.updated', () => {
            renderCharts();
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        renderCharts();
    });

    function renderCharts() {
        // Category Pie Chart
        const categoryData = @json($categoryData);
        const categories = categoryData.map(item => item.category + ' (' + item.type + ')');
        const amounts = categoryData.map(item => parseFloat(item.total));

        const categoryOptions = {
            series: amounts,
            chart: {
                type: 'pie',
                height: 350
            },
            labels: categories,
            colors: ['#28a745', '#dc3545', '#ffc107', '#17a2b8', '#6610f2', '#fd7e14'],
            legend: {
                position: 'bottom'
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 300
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        document.getElementById('categoryChart').innerHTML = '';
        const categoryChart = new ApexCharts(document.querySelector("#categoryChart"), categoryOptions);
        categoryChart.render();

        // Monthly Trend Bar Chart
        const monthlyTrend = @json($monthlyTrend);
        const months = monthlyTrend.map(item => item.month);
        const incomes = monthlyTrend.map(item => parseFloat(item.income));
        const expenses = monthlyTrend.map(item => parseFloat(item.expense));

        const monthlyOptions = {
            series: [{
                name: 'Pemasukan',
                data: incomes
            }, {
                name: 'Pengeluaran',
                data: expenses
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                }
            },
            colors: ['#28a745', '#dc3545'],
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: months
            },
            yaxis: {
                title: {
                    text: 'Nominal (Rp)'
                }
            },
            legend: {
                position: 'top'
            }
        };

        document.getElementById('monthlyChart').innerHTML = '';
        const monthlyChart = new ApexCharts(document.querySelector("#monthlyChart"), monthlyOptions);
        monthlyChart.render();
    }
</script>
@endpush