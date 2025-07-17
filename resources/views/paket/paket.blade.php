<section id="harga" class="max-w-4xl mx-auto my-16 px-4">
    <h2 class="text-3xl font-bold text-center mb-10">Daftar Harga</h2>

    @foreach($pakets as $kategori => $items)
        <div class="bg-white border border-gray-200 rounded-lg shadow-md p-6 mb-6">
            <h3 class="text-xl font-semibold mb-4 text-yellow-600">{{ $kategori }}</h3>
            <ul class="space-y-2 text-gray-700">
                @foreach($items as $item)
                    <li class="flex justify-between">
                        <span>{{ $item->nama }}</span> 
                        <span>Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</section>
