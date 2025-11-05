<?php

namespace App\Livewire;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class HomeLivewire extends Component
{
    use WithPagination;

    public $auth;
    public $search = '';

    public function mount()
    {
        $this->auth = Auth::user();
    }

    public function render()
    {
        $transactions = Transaction::where('user_id', $this->auth->id)
            ->where('title', 'like', '%' . $this->search . '%')
            ->orderBy('date', 'desc')
            ->paginate(20);

        return view('livewire.home-livewire', [
            'transactions' => $transactions
        ]);
    }

    // ---------------------------
    // Tambah Data
    public $addTitle, $addAmount, $addType, $addDate, $addDescription;

    public function addTransaction()
    {
        $this->validate([
            'addTitle' => 'required|string|max:255',
            'addType' => 'required|in:income,expense',
            'addAmount' => 'required|numeric',
            'addDate' => 'required|date',
        ]);

        Transaction::create([
            'user_id' => $this->auth->id,
            'title' => $this->addTitle,
            'type' => $this->addType,
            'amount' => $this->addAmount,
            'date' => $this->addDate,
            'description' => $this->addDescription,
        ]);

        $this->reset(['addTitle', 'addType', 'addAmount', 'addDate', 'addDescription']);
        $this->dispatch('closeModal', id: 'addTransactionModal');
    }

    // ---------------------------
    // Edit Data
    public $editId, $editTitle, $editType, $editAmount, $editDate, $editDescription;

    public function prepareEditTransaction($id)
    {
        $tx = Transaction::find($id);
        if (!$tx) return;

        $this->editId = $tx->id;
        $this->editTitle = $tx->title;
        $this->editType = $tx->type;
        $this->editAmount = $tx->amount;
        $this->editDate = $tx->date;
        $this->editDescription = $tx->description;

        $this->dispatch('showModal', id: 'editTransactionModal');
    }

    public function editTransaction()
    {
        $this->validate([
            'editTitle' => 'required|string|max:255',
            'editType' => 'required|in:income,expense',
            'editAmount' => 'required|numeric',
            'editDate' => 'required|date',
        ]);

        $tx = Transaction::find($this->editId);
        if (!$tx) return;

        $tx->update([
            'title' => $this->editTitle,
            'type' => $this->editType,
            'amount' => $this->editAmount,
            'date' => $this->editDate,
            'description' => $this->editDescription,
        ]);

        $this->reset(['editId', 'editTitle', 'editType', 'editAmount', 'editDate', 'editDescription']);
        $this->dispatch('closeModal', id: 'editTransactionModal');
    }

    // ---------------------------
    // Hapus Data
    public $deleteId, $deleteTitle, $deleteConfirmTitle;

    public function prepareDeleteTransaction($id)
    {
        $tx = Transaction::find($id);
        if (!$tx) return;

        $this->deleteId = $tx->id;
        $this->deleteTitle = $tx->title;
        $this->dispatch('showModal', id: 'deleteTransactionModal');
    }

    public function deleteTransaction()
    {
        if ($this->deleteConfirmTitle !== $this->deleteTitle) {
            $this->addError('deleteConfirmTitle', 'Judul tidak cocok untuk konfirmasi.');
            return;
        }

        Transaction::destroy($this->deleteId);
        $this->reset(['deleteId', 'deleteTitle', 'deleteConfirmTitle']);
        $this->dispatch('closeModal', id: 'deleteTransactionModal');
    }
}
