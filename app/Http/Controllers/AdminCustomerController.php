<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminCustomerController extends Controller
{
    /**
     * Tampilkan daftar akun customer
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $customers = User::where('is_admin', false)
            ->withCount('orders')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $totalCustomers = User::where('is_admin', false)->count();

        return view('admin.customers.index', compact('customers', 'search', 'totalCustomers'));
    }

    /**
     * Form edit akun customer
     */
    public function edit(int $id)
    {
        $customer = User::where('is_admin', false)
            ->with(['orders' => function ($q) {
                $q->latest()->take(5);
            }])
            ->findOrFail($id);

        return view('admin.customers.edit', compact('customer'));
    }

    /**
     * Update data akun customer
     */
    public function update(Request $request, int $id)
    {
        $customer = User::where('is_admin', false)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $customer->id,
            'phone' => 'nullable|string|max:25',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'postal_code' => 'nullable|string|max:10',
            'new_password' => 'nullable|string|min:6',
        ], [
            'name.required' => 'Nama customer wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.unique' => 'Email ini sudah dipakai oleh akun lain.',
            'new_password.min' => 'Password baru minimal 6 karakter.',
        ]);

        $data = [
            'name' => $request->input('name'),
            'email' => strtolower(trim($request->input('email'))),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
            'city' => $request->input('city'),
            'postal_code' => $request->input('postal_code'),
        ];

        if ($request->filled('new_password')) {
            $data['password'] = Hash::make($request->input('new_password'));
        }

        $customer->update($data);

        return redirect()->route('admin.customers.index')->with('success', "Data customer '{$customer->name}' berhasil diperbarui!");
    }

    /**
     * Hapus akun customer
     */
    public function destroy(int $id)
    {
        $customer = User::where('is_admin', false)->findOrFail($id);
        $name = $customer->name;

        $customer->delete();

        return redirect()->route('admin.customers.index')->with('success', "Akun customer '{$name}' berhasil dihapus.");
    }
}

