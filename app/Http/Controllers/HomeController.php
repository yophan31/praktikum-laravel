<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        // Redirect ke transactions
        return redirect()->route('app.transactions');
    }

    public function todoDetail()
    {
        return view('pages.app.todos.detail');
    }
}