<div class="mt-3">
    <div class="card">
        <div class="card-header d-flex align-items-center">
            <div class="flex-fill">
                <h3>💰 Catatan Keuangan</h3>
                <small class="text-muted">Halo, {{ $auth->name }}!</small>
            </div>
            <div>
                <a href="{{ route('app.statistics') }}" class="btn btn-info me-2">📊 Statistik</a>
                <a href="{{ route('auth.logout') }}" class="btn btn-warning">Keluar</a>
            </div>
        </div>
        <div class="card-body">
            {{-- Search & Filter Section --}}
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="🔍 Cari transaksi..." wire:model.live.debounce.300ms="search">
                </div>
                <div class="col-md-2">
                    <select class="form-select" wire:model.live="filterType">
                        <option value="">Semua Tipe</option>
                        <option value="income">Pemasukan</option>
                        <option value="expense">Pengeluaran</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <select class="form-select" wire:model.live="filterCategory">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" placeholder="Dari Tanggal" wire:model.live="filterDateFrom">
                </div>
                <div class="col-md-2">
                    <input type="date" class="form-control" placeholder="Sampai Tanggal" wire:model.live="filterDateTo">
                </div>
                <div class="col-md-1">
                    <button class="btn btn-secondary w-100" wire:click="resetFilters" title="Reset Filter">🔄</button>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="d-flex mb-3">
                <div class="flex-fill">
                    <h5>Daftar Transaksi</h5>
                </div>
                <div>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addTransactionModal">
                        ➕ Tambah Transaksi
                    </button>
                </div>
            </div>

            {{-- Transactions Table --}}
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Judul</th>
                            <th>Kategori</th>
                            <th>Tipe</th>
                            <th class="text-end">Nominal</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($transactions as $key => $transaction)
                            <tr>
                                <td>{{ $transactions->firstItem() + $key }}</td>
                                <td>{{ $transaction->transaction_date->format('d M Y') }}</td>
                                <td>{{ $transaction->title }}</td>
                                <td><span class="badge bg-secondary">{{ $transaction->category }}</span></td>
                                <td>
                                    @if ($transaction->type === 'income')
                                        <span class="badge bg-success">💵 Pemasukan</span>
                                    @else
                                        <span class="badge bg-danger">💸 Pengeluaran</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <strong class="{{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                                        {{ $transaction->type === 'income' ? '+' : '-' }} 
                                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </strong>
                                </td>
                                <td>
                                    <a href="{{ route('app.transactions.detail', ['transaction_id' => $transaction->id]) }}"
                                        class="btn btn-sm btn-info">
                                        📄 Detail
                                    </a>
                                    <button wire:click="prepareEditTransaction({{ $transaction->id }})"
                                        class="btn btn-sm btn-warning">
                                        ✏️ Edit
                                    </button>
                                    <button wire:click="prepareDeleteTransaction({{ $transaction->id }})"
                                        class="btn btn-sm btn-danger">
                                        🗑️ Hapus
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <p class="text-muted mb-0">📭 Belum ada data transaksi yang tersedia.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-3">
                {{ $transactions->links() }}
            </div>
        </div>
    </div>

    {{-- Modals --}}
    @include('components.modals.transactions.add')
    @include('components.modals.transactions.edit')
    @include('components.modals.transactions.delete')
</div>