<?php

namespace App\Livewire;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class TransactionLivewire extends Component
{
    use WithFileUploads, WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $auth;
    
    // Filter & Search
    public $search = '';
    public $filterType = '';
    public $filterCategory = '';
    public $filterDateFrom = '';
    public $filterDateTo = '';

    // Add Transaction
    public $addType;
    public $addTitle;
    public $addDescription;
    public $addAmount;
    public $addCategory;
    public $addTransactionDate;

    // Edit Transaction
    public $editTransactionId;
    public $editType;
    public $editTitle;
    public $editDescription;
    public $editAmount;
    public $editCategory;
    public $editTransactionDate;

    // Delete Transaction
    public $deleteTransactionId;
    public $deleteTransactionTitle;
    public $deleteTransactionConfirmTitle;

    public function mount()
    {
        $this->auth = Auth::user();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilterType()
    {
        $this->resetPage();
    }

    public function updatingFilterCategory()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Transaction::where('user_id', $this->auth->id);

        // Apply search
        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%')
                  ->orWhere('category', 'like', '%' . $this->search . '%');
            });
        }

        // Apply filters
        if ($this->filterType) {
            $query->where('type', $this->filterType);
        }

        if ($this->filterCategory) {
            $query->where('category', $this->filterCategory);
        }

        if ($this->filterDateFrom) {
            $query->whereDate('transaction_date', '>=', $this->filterDateFrom);
        }

        if ($this->filterDateTo) {
            $query->whereDate('transaction_date', '<=', $this->filterDateTo);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')
                             ->orderBy('created_at', 'desc')
                             ->paginate(20);

        // Get unique categories for filter
        $categories = Transaction::where('user_id', $this->auth->id)
                                ->distinct()
                                ->pluck('category');

        $data = [
            'transactions' => $transactions,
            'categories' => $categories
        ];

        return view('livewire.transaction-livewire', $data);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'filterType', 'filterCategory', 'filterDateFrom', 'filterDateTo']);
        $this->resetPage();
    }

    public function addTransaction()
    {
        $this->validate([
            'addType' => 'required|in:income,expense',
            'addTitle' => 'required|string|max:255',
            'addDescription' => 'required|string',
            'addAmount' => 'required|numeric|min:0',
            'addCategory' => 'required|string|max:255',
            'addTransactionDate' => 'required|date',
        ]);

        Transaction::create([
            'user_id' => $this->auth->id,
            'type' => $this->addType,
            'title' => $this->addTitle,
            'description' => $this->addDescription,
            'amount' => $this->addAmount,
            'category' => $this->addCategory,
            'transaction_date' => $this->addTransactionDate,
        ]);

        $this->reset(['addType', 'addTitle', 'addDescription', 'addAmount', 'addCategory', 'addTransactionDate']);
        $this->dispatch('closeModal', id: 'addTransactionModal');
        $this->dispatch('showAlert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Transaksi berhasil ditambahkan.'
        ]);
    }

    public function prepareEditTransaction($id)
    {
        $transaction = Transaction::where('id', $id)
                                  ->where('user_id', $this->auth->id)
                                  ->first();
        
        if (!$transaction) {
            $this->dispatch('showAlert', [
                'icon' => 'error',
                'title' => 'Gagal!',
                'text' => 'Data transaksi tidak ditemukan.'
            ]);
            return;
        }

        $this->editTransactionId = $transaction->id;
        $this->editType = $transaction->type;
        $this->editTitle = $transaction->title;
        $this->editDescription = $transaction->description;
        $this->editAmount = $transaction->amount;
        $this->editCategory = $transaction->category;
        $this->editTransactionDate = $transaction->transaction_date->format('Y-m-d');

        $this->dispatch('showModal', id: 'editTransactionModal');
    }

    public function editTransaction()
    {
        $this->validate([
            'editType' => 'required|in:income,expense',
            'editTitle' => 'required|string|max:255',
            'editDescription' => 'required|string',
            'editAmount' => 'required|numeric|min:0',
            'editCategory' => 'required|string|max:255',
            'editTransactionDate' => 'required|date',
        ]);

        $transaction = Transaction::where('id', $this->editTransactionId)
                                  ->where('user_id', $this->auth->id)
                                  ->first();

        if (!$transaction) {
            $this->dispatch('showAlert', [
                'icon' => 'error',
                'title' => 'Gagal!',
                'text' => 'Data transaksi tidak ditemukan.'
            ]);
            return;
        }

        $transaction->update([
            'type' => $this->editType,
            'title' => $this->editTitle,
            'description' => $this->editDescription,
            'amount' => $this->editAmount,
            'category' => $this->editCategory,
            'transaction_date' => $this->editTransactionDate,
        ]);

        $this->reset(['editTransactionId', 'editType', 'editTitle', 'editDescription', 'editAmount', 'editCategory', 'editTransactionDate']);
        $this->dispatch('closeModal', id: 'editTransactionModal');
        $this->dispatch('showAlert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Transaksi berhasil diubah.'
        ]);
    }

    public function prepareDeleteTransaction($id)
    {
        $transaction = Transaction::where('id', $id)
                                  ->where('user_id', $this->auth->id)
                                  ->first();

        if (!$transaction) {
            $this->dispatch('showAlert', [
                'icon' => 'error',
                'title' => 'Gagal!',
                'text' => 'Data transaksi tidak ditemukan.'
            ]);
            return;
        }

        $this->deleteTransactionId = $transaction->id;
        $this->deleteTransactionTitle = $transaction->title;
        $this->dispatch('showModal', id: 'deleteTransactionModal');
    }

    public function deleteTransaction()
    {
        if ($this->deleteTransactionConfirmTitle !== $this->deleteTransactionTitle) {
            $this->addError('deleteTransactionConfirmTitle', 'Judul konfirmasi tidak sesuai.');
            return;
        }

        $transaction = Transaction::where('id', $this->deleteTransactionId)
                                  ->where('user_id', $this->auth->id)
                                  ->first();

        if ($transaction) {
            // Hapus receipt jika ada
            if ($transaction->receipt && Storage::disk('public')->exists($transaction->receipt)) {
                Storage::disk('public')->delete($transaction->receipt);
            }
            $transaction->delete();
        }

        $this->reset(['deleteTransactionId', 'deleteTransactionTitle', 'deleteTransactionConfirmTitle']);
        $this->dispatch('closeModal', id: 'deleteTransactionModal');
        $this->dispatch('showAlert', [
            'icon' => 'success',
            'title' => 'Berhasil!',
            'text' => 'Transaksi berhasil dihapus.'
        ]);
    }
}