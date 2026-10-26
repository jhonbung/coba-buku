<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:100',
        ]);

        NewsletterSubscriber::firstOrCreate([
            'email' => $request->input('email'),
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Terima kasih telah bergabung dengan Bianca Veana Universe! Informasi peluncuran buku terbaru akan dikirimkan ke email Anda.',
            ]);
        }

        return back()->with('newsletter_success', 'Terima kasih telah bergabung dengan Bianca Veana Universe! Informasi peluncuran novel terbaru akan segera dikirimkan ke email Anda.');
    }
}
