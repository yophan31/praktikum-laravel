<form wire:submit.prevent="addTransaction">
    <div class="modal fade" tabindex="-1" id="addTransactionModal" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">➕ Tambah Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipe Transaksi <span class="text-danger">*</span></label>
                            <select class="form-select" wire:model="addType">
                                <option value="">Pilih Tipe</option>
                                <option value="income">💵 Pemasukan</option>
                                <option value="expense">💸 Pengeluaran</option>
                            </select>
                            @error('addType')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal Transaksi <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" wire:model="addTransactionDate">
                            @error('addTransactionDate')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Judul <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" wire:model="addTitle" 
                               placeholder="Contoh: Gaji Bulanan, Belanja Bulanan">
                        @error('addTitle')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" wire:model="addCategory" 
                                   placeholder="Contoh: Gaji, Makanan, Transport">
                            @error('addCategory')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nominal (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" wire:model="addAmount" 
                                   placeholder="Contoh: 500000" step="0.01" min="0">
                            @error('addAmount')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                        <textarea class="form-control" rows="4" wire:model="addDescription" 
                                  placeholder="Tuliskan deskripsi transaksi..."></textarea>
                        @error('addDescription')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">💾 Simpan</button>
                </div>
            </div>
        </div>
    </div>
</form>