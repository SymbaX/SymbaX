<link rel="stylesheet" href="{{ asset('css/list.css') }}">

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Upcoming events') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex items-center gap-4">
                    @if (session('status') === 'event-deleted')
                        <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-gray-600">{{ __('Deleted the event.') }}</p>
                    @endif
                </div>
                @if ($events->isEmpty())
                    <p>No events found.</p>
                @else
                    <div id="cardlayout-wrap">
                        <!--カードレイアウトをラッピング -->
                        @foreach ($events as $event)
                            <section class="card-list">
                                <a class="card-link" href="#">
                                    <ul>

                                        <li><a href="details/{{ $event->id }}">
                                                <h3 class="card-title">{{ $event->name }}</h3>
                                                <figure class="card-figure"><img class="product_image mx-auto"
                                                        src="{{ Storage::url($event->product_image) }}" alt="">
                                                </figure>
                                                <p class="card-text-tax">{{ $event->details }}</p>
                                            </a>
                                        </li>

                                    </ul>

                                </a>
                            </section>
                        @endforeach
                    </div>
                    <!--カードレイアウトをラッピング -->
                @endif
                <br />
                {{ $events->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
