<x-filament::page>
    <div class="space-y-6 p-6">
        <header>
            <h1 class="text-3xl font-bold">Analytics Overview</h1>
            <p class="text-gray-600">Lihat ringkasan data analitik untuk konten Anda.</p>
        </header>

        <!-- Contoh card analitik -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Total Articles -->
            <div class="p-4 bg-white border border-gray-200 rounded shadow">
                <h2 class="text-xl font-semibold text-gray-800">Total Articles</h2>
                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ $totalArticles ?? '0' }}
                </p>
            </div>
            <!-- Daily Articles -->
            <div class="p-4 bg-white border border-gray-200 rounded shadow">
                <h2 class="text-xl font-semibold text-gray-800">Daily Articles</h2>
                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ $dailyArticles ?? '0' }}
                </p>
            </div>
            <!-- Weekly Articles -->
            <div class="p-4 bg-white border border-gray-200 rounded shadow">
                <h2 class="text-xl font-semibold text-gray-800">Weekly Articles</h2>
                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ $weeklyArticles ?? '0' }}
                </p>
            </div>
        </div>

        <!-- Section filter (opsional) -->
        <div class="mt-8">
            <label for="filter" class="block font-medium text-sm text-gray-700">
                Filter Analytics:
            </label>
            <select wire:model="filter" id="filter" class="mt-1 block w-1/3 border-gray-300 rounded-md shadow-sm">
                <option value="all">All</option>
                <option value="daily">Daily</option>
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
            </select>
        </div>
    </div>
</x-filament::page>
