<x-filament::page>
    <div class="space-y-6">
        <!-- Filter Section -->
        <div>
            <label for="filter" class="block font-medium text-sm text-gray-700">
                Filter Analytics:
            </label>
            <!-- Menggunakan Livewire binding agar perubahan filter otomatis memicu perhitungan ulang -->
            <select wire:model="filter" id="filter" class="mt-1 block w-1/3 border-gray-300 rounded-md shadow-sm">
                <option value="all">All</option>
                <option value="daily">Daily</option>
                <option value="weekly">Weekly</option>
                <option value="monthly">Monthly</option>
            </select>
        </div>

        <!-- Analytics Result -->
        <div class="p-4 bg-white rounded shadow">
            <h2 class="text-2xl font-bold">
                Total Articles: {{ $totalArticles }}
            </h2>
        </div>
    </div>
</x-filament::page>
