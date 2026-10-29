<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\TeaserVideo;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index()
    {
        $totalSales = Order::where('payment_status', 'paid')->sum('total_amount');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $lowStockCount = Product::where('stock', '<', 20)->where('category', '!=', 'ebook')->count();

        // Breakdown Penjualan per Kategori (Buku Fisik, E-Book Digital, Merchandise)
        $paidOrderIds = Order::where('payment_status', 'paid')->pluck('id');

        $paidItems = OrderItem::with('product')
            ->whereIn('order_id', $paidOrderIds)
            ->get();

        $categorySales = [
            'novel' => [
                'name' => 'Buku Fisik (Novel)',
                'badge' => 'Novel Cetak & Boxset',
                'icon' => 'fa-book-open',
                'color' => '#1D4ED8',
                'bg' => '#EFF6FF',
                'border' => '#BFDBFE',
                'bar_color' => '#3B82F6',
                'total' => 0,
                'qty' => 0,
                'items_count' => 0,
            ],
            'ebook' => [
                'name' => 'E-Book & Bab Digital',
                'badge' => 'Full E-Book & Serial Part',
                'icon' => 'fa-book-bookmark',
                'color' => '#15803D',
                'bg' => '#F0FDF4',
                'border' => '#BBF7D0',
                'bar_color' => '#10B981',
                'total' => 0,
                'qty' => 0,
                'items_count' => 0,
            ],
            'merchandise' => [
                'name' => 'Merchandise Resmi',
                'badge' => 'Aksesoris & Edisi Kolektor',
                'icon' => 'fa-crown',
                'color' => '#7E22CE',
                'bg' => '#FAF5FF',
                'border' => '#E9D5FF',
                'bar_color' => '#A855F7',
                'total' => 0,
                'qty' => 0,
                'items_count' => 0,
            ],
        ];

        foreach ($paidItems as $item) {
            $cat = $item->product ? $item->product->category : 'novel';
            if (!isset($categorySales[$cat])) {
                $cat = 'novel';
            }
            $categorySales[$cat]['total'] += (int) $item->subtotal;
            $categorySales[$cat]['qty'] += (int) $item->quantity;
            $categorySales[$cat]['items_count']++;
        }

        $totalItemsRevenue = array_sum(array_column($categorySales, 'total')) ?: 1;
        foreach ($categorySales as $key => &$catData) {
            $catData['percentage'] = round(($catData['total'] / $totalItemsRevenue) * 100);
        }
        unset($catData);

        $recentOrders = Order::with('items')->latest()->take(10)->get();

        return view('admin.index', compact(
            'totalSales',
            'totalOrders',
            'totalProducts',
            'lowStockCount',
            'categorySales',
            'recentOrders'
        ));
    }

    public function orders(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');
        $selectedCategory = $request->query('category', 'all');
        $statusFilter = $request->query('status', 'all');
        $search = $request->query('search');

        // Query base untuk pesanan
        $query = Order::with('items.product')->latest();

        // 1. Filter Tanggal (WIB)
        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // 2. Filter Status Pembayaran / Pengiriman
        if ($statusFilter && $statusFilter !== 'all') {
            if (in_array($statusFilter, ['paid', 'pending', 'failed'])) {
                $query->where('payment_status', $statusFilter);
            } else {
                $query->where('order_status', $statusFilter);
            }
        }

        // 3. Filter Pencarian Teks
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('tracking_number', 'like', "%{$search}%");
            });
        }

        // 4. Filter Kategori Produk (Novel Fisik, Serial E-Book, Merchandise)
        if ($selectedCategory && $selectedCategory !== 'all') {
            $query->whereHas('items.product', function ($q) use ($selectedCategory) {
                $q->where('category', $selectedCategory);
            });
        }

        // 5. Hitung Statistik & Monitoring Pendapatan Berdasarkan Tanggal yang Dipilih
        $statsQuery = Order::with('items.product')->where('payment_status', 'paid');
        if ($startDate) {
            $statsQuery->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $statsQuery->whereDate('created_at', '<=', $endDate);
        }

        $paidOrdersInPeriod = $statsQuery->get();
        $totalPeriodRevenue = $paidOrdersInPeriod->sum('total_amount');
        $totalPeriodOrdersCount = $paidOrdersInPeriod->count();

        // Breakdown Pendapatan per Kategori (Novel, E-Book, Merchandise)
        $categoryBreakdown = [
            'novel' => [
                'name' => 'Buku Fisik (Novel)',
                'badge' => 'Novel & Boxset Cetak',
                'icon' => 'fa-book-open',
                'color' => '#1D4ED8',
                'bg' => '#EFF6FF',
                'border' => '#BFDBFE',
                'bar_color' => '#3B82F6',
                'revenue' => 0,
                'items_sold' => 0,
                'orders_count' => 0,
            ],
            'ebook' => [
                'name' => 'Serial E-Book (Digital)',
                'badge' => 'Full E-Book & Bab Digital',
                'icon' => 'fa-book-bookmark',
                'color' => '#15803D',
                'bg' => '#F0FDF4',
                'border' => '#BBF7D0',
                'bar_color' => '#10B981',
                'revenue' => 0,
                'items_sold' => 0,
                'orders_count' => 0,
            ],
            'merchandise' => [
                'name' => 'Merchandise Resmi',
                'badge' => 'Aksesoris & Edisi Kolektor',
                'icon' => 'fa-crown',
                'color' => '#7E22CE',
                'bg' => '#FAF5FF',
                'border' => '#E9D5FF',
                'bar_color' => '#A855F7',
                'revenue' => 0,
                'items_sold' => 0,
                'orders_count' => 0,
            ],
        ];

        foreach ($paidOrdersInPeriod as $pOrder) {
            $countedCatsInOrder = [];
            foreach ($pOrder->items as $item) {
                $cat = $item->product ? $item->product->category : 'novel';
                if (!isset($categoryBreakdown[$cat])) {
                    $cat = 'novel';
                }
                $categoryBreakdown[$cat]['revenue'] += (int) $item->subtotal;
                $categoryBreakdown[$cat]['items_sold'] += (int) $item->quantity;
                if (!isset($countedCatsInOrder[$cat])) {
                    $categoryBreakdown[$cat]['orders_count']++;
                    $countedCatsInOrder[$cat] = true;
                }
            }
        }

        // Pagination pesanan dengan query string
        $orders = $query->paginate(15)->withQueryString();

        return view('admin.orders', compact(
            'orders',
            'startDate',
            'endDate',
            'selectedCategory',
            'statusFilter',
            'search',
            'totalPeriodRevenue',
            'totalPeriodOrdersCount',
            'categoryBreakdown'
        ));
    }

    public function printResi(string $order_number)
    {
        $order = Order::with('items.product')->where('order_number', $order_number)->firstOrFail();
        return view('admin.resi', compact('order'));
    }

    public function updateOrderStatus(Request $request, string $order_number)
    {
        $order = Order::where('order_number', $order_number)->firstOrFail();

        $updateData = [
            'order_status' => $request->input('order_status', $order->order_status),
        ];

        if ($request->filled('tracking_number')) {
            $updateData['tracking_number'] = trim($request->input('tracking_number'));
        }

        if ($request->filled('courier')) {
            $updateData['courier'] = trim($request->input('courier'));
        }

        $order->update($updateData);

        return back()->with('success', "Status dan resi pesanan #{$order->order_number} berhasil diperbarui!");
    }

    public function products()
    {
        $products = Product::whereNull('parent_id')
            ->with('ebookParts')
            ->orderBy('category')
            ->orderBy('order_index')
            ->get();
        return view('admin.products', compact('products'));
    }

    public function createProduct()
    {
        return view('admin.products_create');
    }

    public function storeProduct(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:novel,ebook,merchandise',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'cover_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        $data = $request->except(['_token', 'cover_image_file', 'cover_image_url', 'collectors_items_text']);
        $data['author'] = $request->input('author', 'Bianca Veana') ?: 'Bianca Veana';
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_preorder'] = $request->boolean('is_preorder');

        // Normalize Merchandise vs Novel/E-Book fields
        if ($request->input('category') === 'merchandise') {
            $data['pages'] = null;
            $data['digital_file_type'] = null;
            $data['digital_file_url'] = null;
        } else {
            if ($request->filled('book_genre')) $data['genre'] = $request->input('book_genre');
            if ($request->filled('book_publisher')) $data['publisher'] = $request->input('book_publisher');
            if ($request->filled('book_isbn')) $data['isbn'] = $request->input('book_isbn');
            if ($request->filled('book_dimensions')) $data['dimensions'] = $request->input('book_dimensions');
            if ($request->filled('book_weight_grams')) $data['weight_grams'] = (int) $request->input('book_weight_grams');
            
            if ($request->input('category') === 'ebook') {
                $data['weight_grams'] = 0;
                $data['dimensions'] = null;
            }
        }
        unset(
            $data['book_genre'], $data['book_publisher'], $data['book_isbn'], 
            $data['book_dimensions'], $data['book_weight_grams'],
            $data['gallery_image_2'], $data['gallery_image_3'],
            $data['gallery_url_2'], $data['gallery_url_3'],
            $data['remove_gallery_2'], $data['remove_gallery_3']
        );

        // Generate Unique Slug
        $slug = Str::slug($request->input('title'));
        if (Product::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }
        $data['slug'] = $slug;

        // Handle Image
        if ($request->hasFile('cover_image_file')) {
            $file = $request->file('cover_image_file');
            $fileName = time() . '_' . Str::slug($request->input('title')) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            $data['cover_image'] = '/images/' . $fileName;
        } elseif ($request->filled('cover_image_url')) {
            $data['cover_image'] = $request->input('cover_image_url');
        } else {
            $data['cover_image'] = '/images/mantra.svg';
        }

        // Handle Collectors Items array
        if ($request->filled('collectors_items_text')) {
            $items = preg_split('/[\r\n,]+/', $request->input('collectors_items_text'));
            $data['collectors_items'] = array_values(array_filter(array_map('trim', $items)));
        } else {
            $data['collectors_items'] = null;
        }

        // Handle Physical Book Extra Gallery Images (up to 3 images total)
        $gallery = [];
        if ($request->hasFile('gallery_image_2')) {
            $f2 = $request->file('gallery_image_2');
            $fn2 = time() . '_2_' . Str::slug($request->input('title')) . '.' . $f2->getClientOriginalExtension();
            $f2->move(public_path('images'), $fn2);
            $gallery[] = '/images/' . $fn2;
        } elseif ($request->filled('gallery_url_2')) {
            $gallery[] = $request->input('gallery_url_2');
        }

        if ($request->hasFile('gallery_image_3')) {
            $f3 = $request->file('gallery_image_3');
            $fn3 = time() . '_3_' . Str::slug($request->input('title')) . '.' . $f3->getClientOriginalExtension();
            $f3->move(public_path('images'), $fn3);
            $gallery[] = '/images/' . $fn3;
        } elseif ($request->filled('gallery_url_3')) {
            $gallery[] = $request->input('gallery_url_3');
        }

        $data['gallery_images'] = !empty($gallery) ? $gallery : null;

        Product::create($data);

        return redirect()->route('admin.products')->with('success', 'Produk baru "' . $request->title . '" berhasil ditambahkan ke katalog!');
    }

    public function editProduct(int $id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products_edit', compact('product'));
    }

    public function updateProduct(Request $request, int $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|in:novel,ebook,merchandise',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'cover_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
        ]);

        $data = $request->except(['_token', '_method', 'cover_image_file', 'cover_image_url', 'collectors_items_text']);
        $data['author'] = $request->input('author', 'Bianca Veana') ?: 'Bianca Veana';
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_preorder'] = $request->boolean('is_preorder');

        // Normalize Merchandise vs Novel/E-Book fields
        if ($request->input('category') === 'merchandise') {
            $data['pages'] = null;
            $data['digital_file_type'] = null;
            $data['digital_file_url'] = null;
        } else {
            if ($request->filled('book_genre')) $data['genre'] = $request->input('book_genre');
            if ($request->filled('book_publisher')) $data['publisher'] = $request->input('book_publisher');
            if ($request->filled('book_isbn')) $data['isbn'] = $request->input('book_isbn');
            if ($request->filled('book_dimensions')) $data['dimensions'] = $request->input('book_dimensions');
            if ($request->filled('book_weight_grams')) $data['weight_grams'] = (int) $request->input('book_weight_grams');
            
            if ($request->input('category') === 'ebook') {
                $data['weight_grams'] = 0;
                $data['dimensions'] = null;
            }
        }
        unset(
            $data['book_genre'], $data['book_publisher'], $data['book_isbn'], 
            $data['book_dimensions'], $data['book_weight_grams'],
            $data['gallery_image_2'], $data['gallery_image_3'],
            $data['gallery_url_2'], $data['gallery_url_3'],
            $data['remove_gallery_2'], $data['remove_gallery_3']
        );

        // Update Slug if title changed
        if ($request->input('title') !== $product->title) {
            $slug = Str::slug($request->input('title'));
            if (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug .= '-' . time();
            }
            $data['slug'] = $slug;
        }

        // Handle Image update
        if ($request->hasFile('cover_image_file')) {
            $file = $request->file('cover_image_file');
            $fileName = time() . '_' . Str::slug($request->input('title')) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images'), $fileName);
            $data['cover_image'] = '/images/' . $fileName;
        } elseif ($request->filled('cover_image_url')) {
            $data['cover_image'] = $request->input('cover_image_url');
        }

        // Handle Collectors Items array
        if ($request->filled('collectors_items_text')) {
            $items = preg_split('/[\r\n,]+/', $request->input('collectors_items_text'));
            $data['collectors_items'] = array_values(array_filter(array_map('trim', $items)));
        } else {
            $data['collectors_items'] = null;
        }

        // Handle Physical Book Extra Gallery Images
        $existingGallery = is_array($product->gallery_images) ? $product->gallery_images : [];
        $img2 = $existingGallery[0] ?? null;
        $img3 = $existingGallery[1] ?? null;

        if ($request->boolean('remove_gallery_2')) {
            $img2 = null;
        } elseif ($request->hasFile('gallery_image_2')) {
            $f2 = $request->file('gallery_image_2');
            $fn2 = time() . '_2_' . Str::slug($request->input('title')) . '.' . $f2->getClientOriginalExtension();
            $f2->move(public_path('images'), $fn2);
            $img2 = '/images/' . $fn2;
        } elseif ($request->filled('gallery_url_2')) {
            $img2 = $request->input('gallery_url_2');
        }

        if ($request->boolean('remove_gallery_3')) {
            $img3 = null;
        } elseif ($request->hasFile('gallery_image_3')) {
            $f3 = $request->file('gallery_image_3');
            $fn3 = time() . '_3_' . Str::slug($request->input('title')) . '.' . $f3->getClientOriginalExtension();
            $f3->move(public_path('images'), $fn3);
            $img3 = '/images/' . $fn3;
        } elseif ($request->filled('gallery_url_3')) {
            $img3 = $request->input('gallery_url_3');
        }

        $newGallery = array_values(array_filter([$img2, $img3]));
        $data['gallery_images'] = !empty($newGallery) ? $newGallery : null;

        $product->update($data);

        return redirect()->route('admin.products')->with('success', 'Produk "' . $product->title . '" berhasil diperbarui!');
    }

    public function destroyProduct(int $id)
    {
        $product = Product::findOrFail($id);
        $title = $product->title;
        $product->delete();

        return redirect()->route('admin.products')->with('success', 'Produk "' . $title . '" berhasil dihapus dari sistem.');
    }

    public function updateStock(Request $request, int $id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'stock' => max(0, (int) $request->input('stock')),
            'price' => max(0, (int) $request->input('price')),
        ]);

        return back()->with('success', "Stok & harga {$product->title} berhasil diperbarui.");
    }

    // ==========================================
    // 11. TEASER VIDEO MANAGEMENT
    // ==========================================

    public function videos()
    {
        $videos = TeaserVideo::latest()->get();
        return view('admin.videos', compact('videos'));
    }

    public function createVideo()
    {
        return view('admin.videos_create');
    }

    public function storeVideo(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'video_type' => 'required|in:file,youtube,url',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ];

        if ($request->input('video_type') === 'youtube') {
            $rules['youtube_url'] = 'required|string';
        } elseif ($request->input('video_type') === 'url') {
            $rules['video_url'] = 'required|string';
        } else {
            $rules['video_file'] = 'nullable|file|mimes:mp4,webm,ogg,mov,mkv|max:204800';
        }

        $request->validate($rules);

        $data = [
            'title' => $request->input('title'),
            'tagline' => $request->input('tagline', 'OFFICIAL CINEMATIC TRAILER'),
            'subtitle' => $request->input('subtitle'),
            'video_type' => $request->input('video_type', 'file'),
            'badge_1' => $request->input('badge_1', '1080p Full HD'),
            'badge_2' => $request->input('badge_2', 'Original Soundtrack'),
            'badge_3' => $request->input('badge_3', 'Official Universe'),
            'cta_text' => $request->input('cta_text', 'Beli Seri Novel'),
            'cta_link' => $request->input('cta_link', '#notonegoro-series'),
            'is_active' => $request->boolean('is_active'),
        ];

        // Handle Video Type
        if ($data['video_type'] === 'file') {
            if ($request->hasFile('video_file')) {
                $file = $request->file('video_file');
                $filename = 'teaser_' . time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('videos'), $filename);
                $data['video_path'] = '/videos/' . $filename;
            } elseif (file_exists(public_path('videos/teaser.mp4'))) {
                $data['video_path'] = '/videos/teaser.mp4';
            }
        } elseif ($data['video_type'] === 'youtube') {
            $data['youtube_url'] = $request->input('youtube_url');
        } elseif ($data['video_type'] === 'url') {
            $data['video_path'] = $request->input('video_url');
        }

        // Handle Thumbnail Poster
        if ($request->hasFile('thumbnail_file')) {
            $thumb = $request->file('thumbnail_file');
            $thumbName = 'poster_' . time() . '.' . $thumb->getClientOriginalExtension();
            $thumb->move(public_path('images'), $thumbName);
            $data['thumbnail_path'] = '/images/' . $thumbName;
        } elseif ($request->filled('thumbnail_url')) {
            $data['thumbnail_path'] = $request->input('thumbnail_url');
        } else {
            $data['thumbnail_path'] = '/images/hero-slide-1.jpg';
        }

        // Create video without deactivating other videos (multiple videos can be active)
        TeaserVideo::create($data);

        return redirect()->route('admin.videos')->with('success', 'Video Teaser "' . $request->title . '" berhasil ditambahkan!');
    }

    public function editVideo(int $id)
    {
        $video = TeaserVideo::findOrFail($id);
        return view('admin.videos_edit', compact('video'));
    }

    public function updateVideo(Request $request, int $id)
    {
        $video = TeaserVideo::findOrFail($id);

        $rules = [
            'title' => 'required|string|max:255',
            'video_type' => 'required|in:file,youtube,url',
            'thumbnail_file' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ];

        if ($request->input('video_type') === 'youtube') {
            $rules['youtube_url'] = 'required|string';
        } elseif ($request->input('video_type') === 'url') {
            $rules['video_url'] = 'required|string';
        } else {
            $rules['video_file'] = 'nullable|file|mimes:mp4,webm,ogg,mov,mkv|max:204800';
        }

        $request->validate($rules);

        $data = [
            'title' => $request->input('title'),
            'tagline' => $request->input('tagline'),
            'subtitle' => $request->input('subtitle'),
            'video_type' => $request->input('video_type', 'file'),
            'badge_1' => $request->input('badge_1'),
            'badge_2' => $request->input('badge_2'),
            'badge_3' => $request->input('badge_3'),
            'cta_text' => $request->input('cta_text'),
            'cta_link' => $request->input('cta_link'),
            'is_active' => $request->boolean('is_active'),
        ];

        // Handle Video Replacement
        if ($data['video_type'] === 'file') {
            if ($request->hasFile('video_file')) {
                if ($video->video_path && str_starts_with($video->video_path, '/videos/teaser_') && file_exists(public_path($video->video_path))) {
                    @unlink(public_path($video->video_path));
                }
                $file = $request->file('video_file');
                $filename = 'teaser_' . time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('videos'), $filename);
                $data['video_path'] = '/videos/' . $filename;
            }
        } elseif ($data['video_type'] === 'youtube') {
            $data['youtube_url'] = $request->input('youtube_url');
        } elseif ($data['video_type'] === 'url') {
            $data['video_path'] = $request->input('video_url');
        }

        // Handle Thumbnail Replacement
        if ($request->hasFile('thumbnail_file')) {
            $thumb = $request->file('thumbnail_file');
            $thumbName = 'poster_' . time() . '.' . $thumb->getClientOriginalExtension();
            $thumb->move(public_path('images'), $thumbName);
            $data['thumbnail_path'] = '/images/' . $thumbName;
        } elseif ($request->filled('thumbnail_url')) {
            $data['thumbnail_path'] = $request->input('thumbnail_url');
        }

        $video->update($data);

        return redirect()->route('admin.videos')->with('success', 'Video Teaser "' . $video->title . '" berhasil diperbarui!');
    }

    public function destroyVideo(int $id)
    {
        $video = TeaserVideo::findOrFail($id);
        $title = $video->title;

        if ($video->video_path && str_starts_with($video->video_path, '/videos/teaser_') && file_exists(public_path($video->video_path))) {
            @unlink(public_path($video->video_path));
        }

        $video->delete();

        return redirect()->route('admin.videos')->with('success', 'Video Teaser "' . $title . '" berhasil dihapus.');
    }

    public function activateVideo(int $id)
    {
        $video = TeaserVideo::findOrFail($id);
        $video->update(['is_active' => !$video->is_active]);

        $statusMsg = $video->is_active ? 'kini AKTIF ditayangkan' : 'kini DI-NON-AKTIFKAN';
        return back()->with('success', "Video Teaser \"{$video->title}\" {$statusMsg} di website!");
    }

    // ==========================================
    // 12. E-BOOK PARTS MANAGEMENT (PART 1, 2, ...)
    // ==========================================

    public function ebookPartsHub()
    {
        $notonegoroTitles = Product::with('ebookParts')
            ->whereNull('parent_id')
            ->where('category', 'novel')
            ->where('subcategory', 'notonegoro')
            ->orderBy('order_index')
            ->get();

        $standaloneTitles = Product::with('ebookParts')
            ->whereNull('parent_id')
            ->where('category', 'novel')
            ->where('subcategory', 'standalone')
            ->orderBy('order_index')
            ->get();

        $allParentTitles = Product::whereNull('parent_id')
            ->where('category', 'novel')
            ->orderBy('order_index')
            ->get();

        $totalParts = Product::whereNotNull('parent_id')->count();

        return view('admin.ebook_parts_hub', compact('notonegoroTitles', 'standaloneTitles', 'allParentTitles', 'totalParts'));
    }

    public function parts(int $id)
    {
        $product = Product::with('ebookParts')->findOrFail($id);
        $parts = $product->ebookParts;
        return view('admin.parts', compact('product', 'parts'));
    }

    public function storePart(Request $request, int $id)
    {
        $parent = Product::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'part_number' => 'nullable|integer|min:1',
            'price' => 'required|numeric|min:0',
            'digital_file_url' => 'nullable|string',
            'ebook_file' => 'nullable|file|mimes:pdf,epub,zip|max:51200',
            'synopsis' => 'nullable|string',
            'content' => 'nullable|string',
        ]);

        $fileUrl = $request->input('digital_file_url');
        $fileType = 'gdrive';

        if ($request->hasFile('ebook_file')) {
            $file = $request->file('ebook_file');
            $filename = 'part_' . time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/ebooks'), $filename);
            $fileUrl = '/uploads/ebooks/' . $filename;
            $fileType = $file->getClientOriginalExtension();
        }

        $partNum = $request->input('part_number') ? (int) $request->input('part_number') : null;
        $orderIndex = $partNum ? (10 + $partNum) : 99;

        $slug = Str::slug($request->input('title'));
        if (Product::where('slug', $slug)->exists()) {
            $slug .= '-' . time();
        }

        Product::create([
            'parent_id' => $parent->id,
            'part_number' => $partNum,
            'title' => $request->input('title'),
            'slug' => $slug,
            'subtitle' => $parent->title . ($partNum ? " — Part {$partNum}" : " — Edisi Lengkap"),
            'series_name' => $parent->series_name,
            'category' => 'ebook',
            'subcategory' => $partNum ? 'chapter' : 'ebook',
            'author' => $parent->author,
            'price' => (int) $request->input('price'),
            'stock' => 9999,
            'cover_image' => $parent->cover_image,
            'synopsis' => $request->filled('synopsis') ? trim($request->input('synopsis')) : "Part serial digital untuk judul {$parent->title}",
            'content' => $request->input('content'),
            'genre' => $parent->genre,
            'digital_file_type' => $fileType,
            'digital_file_url' => $fileUrl,
            'order_index' => $orderIndex,
        ]);

        return back()->with('success', "Part e-book \"{$request->title}\" berhasil ditambahkan untuk {$parent->title}!");
    }

    public function destroyPart(int $part_id)
    {
        $part = Product::findOrFail($part_id);
        $title = $part->title;

        if ($part->digital_file_url && (str_starts_with($part->digital_file_url, '/uploads/ebooks/') || str_starts_with($part->digital_file_url, '/ebooks/')) && file_exists(public_path($part->digital_file_url))) {
            @unlink(public_path($part->digital_file_url));
        }

        $part->delete();

        return back()->with('success', "Part e-book \"{$title}\" berhasil dihapus.");
    }
}
