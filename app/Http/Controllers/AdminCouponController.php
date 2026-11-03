<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;

class AdminCouponController extends Controller
{
    public function index()
    {
        $coupons = Coupon::latest()->paginate(15);
        $totalCoupons = Coupon::count();
        $activeCoupons = Coupon::where('is_active', true)->count();
        $totalUsage = Coupon::sum('usage_count');

        return view('admin.coupons.index', compact('coupons', 'totalCoupons', 'activeCoupons', 'totalUsage'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code',
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'type' => 'required|in:percent,fixed,shipping',
            'value' => 'required|numeric|min:0.01',
            'min_spend' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after_or_equal:starts_at',
            'is_active' => 'nullable|boolean',
            'is_public' => 'nullable|boolean',
        ]);

        Coupon::create([
            'code' => strtoupper(trim($request->input('code'))),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'value' => $request->input('value'),
            'min_spend' => (int) $request->input('min_spend', 0),
            'max_discount' => $request->filled('max_discount') ? (int) $request->input('max_discount') : null,
            'usage_limit' => $request->filled('usage_limit') ? (int) $request->input('usage_limit') : null,
            'starts_at' => $request->input('starts_at'),
            'expires_at' => $request->input('expires_at'),
            'is_active' => $request->has('is_active'),
            'is_public' => $request->has('is_public'),
        ]);

        return redirect()->route('admin.coupons.index')->with('success', 'Kupon promo baru berhasil dibuat!');
    }

    public function update(Request $request, int $id)
    {
        $coupon = Coupon::findOrFail($id);

        $request->validate([
            'code' => 'required|string|max:50|unique:coupons,code,' . $coupon->id,
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:255',
            'type' => 'required|in:percent,fixed,shipping',
            'value' => 'required|numeric|min:0.01',
            'min_spend' => 'nullable|numeric|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'usage_limit' => 'nullable|integer|min:1',
            'starts_at' => 'nullable|date',
            'expires_at' => 'nullable|date',
            'is_active' => 'nullable|boolean',
            'is_public' => 'nullable|boolean',
        ]);

        $coupon->update([
            'code' => strtoupper(trim($request->input('code'))),
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'type' => $request->input('type'),
            'value' => $request->input('value'),
            'min_spend' => (int) $request->input('min_spend', 0),
            'max_discount' => $request->filled('max_discount') ? (int) $request->input('max_discount') : null,
            'usage_limit' => $request->filled('usage_limit') ? (int) $request->input('usage_limit') : null,
            'starts_at' => $request->input('starts_at'),
            'expires_at' => $request->input('expires_at'),
            'is_active' => $request->has('is_active'),
            'is_public' => $request->has('is_public'),
        ]);

        return redirect()->route('admin.coupons.index')->with('success', "Kupon [{$coupon->code}] berhasil diperbarui!");
    }

    public function toggle(int $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->is_active = !$coupon->is_active;
        $coupon->save();

        $statusText = $coupon->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.coupons.index')->with('success', "Kupon [{$coupon->code}] berhasil {$statusText}!");
    }

    public function destroy(int $id)
    {
        $coupon = Coupon::findOrFail($id);
        $code = $coupon->code;
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('success', "Kupon [{$code}] berhasil dihapus!");
    }
}

