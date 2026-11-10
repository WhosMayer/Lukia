<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => [
                'required',
                'string',
                'max:80',
                Rule::unique('categories')->where('user_id', $request->user()->id),
            ],
        ]);

        $request->user()->categories()->create($data);

        return back()->with('status', 'Categoría creada.');
    }
}
