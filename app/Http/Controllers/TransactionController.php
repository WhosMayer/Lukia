<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $request->user()->transactions()->create($this->validatedData($request));

        return redirect('/panel?month='.substr((string) $request->string('date'), 0, 7))
            ->with('status', 'Movimiento registrado.');
    }

    public function edit(Request $request, int $id): View
    {
        $transaction = $this->ownedTransaction($request, $id);
        $categories = $request->user()->categories()->orderBy('name')->get();

        return view('edit', compact('transaction', 'categories'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $transaction = $this->ownedTransaction($request, $id);
        $transaction->update($this->validatedData($request));

        return redirect('/panel?month='.substr((string) $request->string('date'), 0, 7))
            ->with('status', 'Movimiento actualizado.');
    }

    public function destroy(Request $request, int $id): RedirectResponse
    {
        $this->ownedTransaction($request, $id)->delete();

        return back()->with('status', 'Movimiento eliminado.');
    }

    private function ownedTransaction(Request $request, int $id): Transaction
    {
        return $request->user()->transactions()->findOrFail($id);
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        $data = $request->validate([
            'type' => ['required', Rule::in(['income', 'expense'])],
            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')->where('user_id', $request->user()->id),
            ],
            'amount' => ['required', 'regex:/^\d{1,9}(\.\d{1,2})?$/', 'numeric', 'min:0.01'],
            'date' => ['required', 'date_format:Y-m-d'],
            'description' => ['nullable', 'string', 'max:200'],
        ]);

        [$whole, $fraction] = array_pad(explode('.', (string) $data['amount']), 2, '');
        $data['amount_cents'] = ((int) $whole) * 100 + (int) str_pad($fraction, 2, '0');
        unset($data['amount']);

        return $data;
    }
}
