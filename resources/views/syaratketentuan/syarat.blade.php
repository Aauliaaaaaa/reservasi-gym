<section id="sk" class="max-w-5xl mx-auto my-10 p-6 bg-white rounded-2xl shadow-md">
    <h2 class="text-2xl font-bold mb-6 text-center">Syarat dan Ketentuan Gym</h2>
    <div id="accordion-collapse" data-accordion="collapse">
        @foreach($syarat as $index => $item)
            <h2 id="accordion-heading-{{ $index }}">
                <button type="button" class="flex items-center justify-between w-full p-4 font-medium text-left text-gray-900 border border-gray-200 {{ $index == 0 ? 'rounded-t-xl' : '' }}"
                    data-accordion-target="#accordion-body-{{ $index }}" aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" aria-controls="accordion-body-{{ $index }}">
                    <span>{{ $index + 1 }}. {{ $item->kategori }}</span>
                    <svg data-accordion-icon class="w-4 h-4 shrink-0 {{ $index == 0 ? 'rotate-180' : '' }}" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.94l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.23 8.29a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-body-{{ $index }}" class="hidden" aria-labelledby="accordion-heading-{{ $index }}">
                <div class="p-4 border border-t-0 border-gray-200">
                    {!! nl2br(e($item->isi)) !!}
                </div>
            </div>
        @endforeach
    </div>
</section>
