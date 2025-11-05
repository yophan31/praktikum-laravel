<form wire:submit.prevent="deleteTransaction">
    <div class="modal fade" tabindex="-1" id="deleteTransactionModal" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title">🗑️ Hapus Transaksi</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <strong>⚠️ Peringatan!</strong><br>
                        Apakah Anda yakin ingin menghapus transaksi dengan judul <strong>"{{ $deleteTransactionTitle }}"</strong>?
                        <br><br>
                        <small>Data yang sudah dihapus tidak dapat dikembalikan.</small>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi dengan mengetik ulang judul transaksi</label>
                        <input type="text" class="form-control" wire:model="deleteTransactionConfirmTitle" 
                               placeholder="Ketik ulang judul transaksi">
                        @error('deleteTransactionConfirmTitle')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">🗑️ Ya, Hapus Transaksi</button>
                </div>
            </div>
        </div>
    </div>
</form>