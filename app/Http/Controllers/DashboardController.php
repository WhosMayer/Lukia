<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $request->validate(['month' => ['nullable', 'date_format:Y-m']]);

        $month = $request->input('month') ?: now()->format('Y-m');
        $start = Carbon::createFromFormat('!Y-m', $month);
        $end = $start->copy()->endOfMonth();

        $query = Transaction::query()
            ->whereBelongsTo($request->user())
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()]);

        $income = (int) (clone $query)->where('type', 'income')->sum('amount_cents');
        $expense = (int) (clone $query)->where('type', 'expense')->sum('amount_cents');

        $transactions = (clone $query)
            ->with('category')
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $categories = $request->user()
            ->categories()
            ->orderBy('name')
            ->get();

        return view('panel', compact(
            'month',
            'income',
            'expense',
            'transactions',
            'categories',
        ));
    }
}
