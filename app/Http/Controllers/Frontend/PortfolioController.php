<?php

namespace App\Http\Controllers\Frontend;

// php artisan make:controller Frontend/PortfolioController

use App\Http\Controllers\Controller;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function index(Request $request)
    {
        $portfolios = Portfolio::where('status', true)
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->orderBy('order')
            ->get();

        $types = Portfolio::where('status', true)
            ->select('type')
            ->distinct()
            ->pluck('type');

        return view('frontend.portfolio', compact('portfolios', 'types'));
    }
}
