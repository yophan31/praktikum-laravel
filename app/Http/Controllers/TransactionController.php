<?php

namespace App\Http\Controllers;

class TransactionController extends Controller
{
    public function index()
    {
        return view('pages.app.transactions.index');
    }

    public function detail()
    {
        return view('pages.app.transactions.detail');
    }

    public function statistics()
    {
        return view('pages.app.transactions.statistics');
    }
}