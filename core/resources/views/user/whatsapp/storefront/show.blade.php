<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
<meta charset="UTF-8">
<title>{{ $setting->store_name ?? 'متجر' }}</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 min-h-screen">
<div class="max-w-2xl mx-auto p-6">
    <div class="bg-white rounded-xl p-6 mb-4 text-center">
        <h1 class="text-2xl font-bold">{{ $setting->store_name ?? 'متجر' }}</h1>
        <p class="text-sm text-slate-500 mt-1">{{ $setting->store_description ?? '' }}</p>
    </div>
    <div class="grid grid-cols-2 gap-3">
        @forelse($products ?? [] as $p)
            <div class="bg-white rounded-xl p-4">
                <div class="font-bold">{{ $p->name ?? '-' }}</div>
                <div class="text-emerald-600 font-bold mt-1">{{ number_format($p->price ?? 0, 0) }} ر</div>
            </div>
        @empty
            <p class="col-span-2 text-center py-8 text-slate-500">لا توجد منتجات بعد</p>
        @endforelse
    </div>
</div>
</body>
</html>
