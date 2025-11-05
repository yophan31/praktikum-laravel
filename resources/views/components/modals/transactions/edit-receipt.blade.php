<form wire:submit.prevent="editReceipt">
    <div class="modal fade" tabindex="-1" id="editReceiptModal" wire:ignore.self>
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">📸 Upload Bukti Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih Foto Bukti Transaksi</label>
                        <input type="file" class="form-control" wire:model="editReceiptFile" accept="image/*">
                        @error('editReceiptFile')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                        <small class="text-muted">Format: JPG, PNG, JPEG. Maksimal 2MB</small>
                    </div>

                    {{-- Preview --}}
                    @if ($editReceiptFile)
                        <div class="mt-3">
                            <label class="form-label">Preview:</label>
                            <div class="text-center">
                                <img src="{{ $editReceiptFile->temporaryUrl() }}" 
                                     class="img-fluid rounded shadow" 
                                     style="max-height: 300px;">
                            </div>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" @if (!$editReceiptFile) disabled @endif>
                        💾 Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>