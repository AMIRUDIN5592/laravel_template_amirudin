<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    public function about(): View
    {
        $data = [
            'title' => 'About',
            'aplikasi' => config('app.name'),
            'versi' => '1.0.0',
            'pembuat' => 'Your Name',
        ];

        return view('about', compact('data'));
    }
}
