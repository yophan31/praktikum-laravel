<div class="mt-3">
    <div class="card">
        <div class="card-header">
            <a href="{{ route('app.transactions') }}" class="text-decoration-none">
                <small class="text-muted">← Kembali ke Daftar Transaksi</small>
            </a>
            <div class="d-flex align-items-center mt-2">
                <div class="flex-fill">
                    <h3>
                        {{ $transaction->title }}
                        @if ($transaction->type === 'income')
                            <span class="badge bg-success">💵 Pemasukan</span>
                        @else
                            <span class="badge bg-danger">💸 Pengeluaran</span>
                        @endif
                    </h3>
                </div>
                <div>
                    @if ($transaction->receipt)
                        <button class="btn btn-danger btn-sm me-2" wire:click="deleteReceipt" 
                                onclick="return confirm('Hapus bukti transaksi?')">
                            🗑️ Hapus Bukti
                        </button>
                    @endif
                    <button class="btn btn-warning" data-bs-target="#editReceiptModal" data-bs-toggle="modal">
                        📸 {{ $transaction->receipt ? 'Ubah' : 'Upload' }} Bukti
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            {{-- Receipt Image --}}
            @if ($transaction->receipt)
                <div class="mb-4">
                    <h5>📸 Bukti Transaksi</h5>
                    <img src="{{ asset('storage/' . $transaction->receipt) }}" 
                         alt="Receipt" 
                         class="img-fluid rounded shadow"
                         style="max-width: 100%; max-height: 500px;">
                </div>
                <hr>
            @endif

            {{-- Transaction Details --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5>📋 Detail Transaksi</h5>
                    <table class="table table-borderless">
                        <tr>
                            <td width="150"><strong>Tanggal</strong></td>
                            <td>: {{ $transaction->transaction_date->format('d F Y') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Kategori</strong></td>
                            <td>: <span class="badge bg-secondary">{{ $transaction->category }}</span></td>
                        </tr>
                        <tr>
                            <td><strong>Tipe</strong></td>
                            <td>: 
                                @if ($transaction->type === 'income')
                                    <span class="badge bg-success">Pemasukan</span>
                                @else
                                    <span class="badge bg-danger">Pengeluaran</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Nominal</strong></td>
                            <td>: 
                                <span class="fs-4 {{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                                    <strong>
                                        {{ $transaction->type === 'income' ? '+' : '-' }} 
                                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </strong>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Dibuat pada</strong></td>
                            <td>: {{ $transaction->created_at->format('d F Y, H:i') }} WIB</td>
                        </tr>
                        
                    </table>
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <h5>📝 Deskripsi</h5>
                <div class="p-3 bg-light rounded">
                    <p class="mb-0" style="font-size: 16px; white-space: pre-line;">{{ $transaction->description }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Modals --}}
    @include('components.modals.transactions.edit-receipt')
</div>