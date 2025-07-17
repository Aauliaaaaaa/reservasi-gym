<section id="fasilitas" class="max-w-7xl mx-auto my-16 px-4">
    <h2 class="text-3xl font-bold text-center mb-10">Fasilitas dan Alat Gym</h2>

    <div id="fasilitasContainer" class="overflow-x-auto scrollbar-hide">
        <div class="flex gap-6">
            @foreach ($fasilitas as $item)
                <div class="min-w-[250px] max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden transform transition-all duration-300 hover:scale-105">
                    @if ($item->foto)
                        <img class="rounded-t-lg w-full h-48 object-cover" src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama }}">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                            Tidak ada foto
                        </div>
                    @endif
                    <div class="p-5">
                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $item->nama }}</h5>
                        <p class="mb-3 font-normal text-gray-700">{{ $item->keterangan }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<script>
    const container = document.getElementById('fasilitasContainer');

    // Swipe support
    let isDown = false;
    let startX;
    let scrollLeftStart;

    container.addEventListener('touchstart', (e) => {
        isDown = true;
        startX = e.touches[0].pageX;
        scrollLeftStart = container.scrollLeft;
    });

    container.addEventListener('touchmove', (e) => {
        if (!isDown) return;
        const x = e.touches[0].pageX;
        const walk = (startX - x); // Geser sejauh apa
        container.scrollLeft = scrollLeftStart + walk;
    });

    container.addEventListener('touchend', () => {
        isDown = false;
    });
</script>

<style>
    /* Sembunyikan scrollbar agar lebih clean */
    .scrollbar-hide::-webkit-scrollbar {
        display: none;
    }
    .scrollbar-hide {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
    }
</style>
