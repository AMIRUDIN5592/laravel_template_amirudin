<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $data = [
            'jumlah_product' => Product::count(),
        ];

        return view('dashboard', compact('data'));
    }
}
