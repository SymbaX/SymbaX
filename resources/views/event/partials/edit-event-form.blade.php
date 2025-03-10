<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Edit event') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Edit event') }}
        </p>
    </header>

    <form method="post" action="{{ route('event.update', ['event_id' => $event->id]) }}" class="mt-6 space-y-6"
        enctype="multipart/form-data">
        @csrf
        @method('patch')

        <input type="hidden" name="edit_token" value="{{ session('edit_token') }}">
        <div>
            <x-input-label for="name" class="required" :value="__('Event Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $event->name)"
                required autofocus autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="detail" class="required" :value="__('Detail')" />
            <x-textarea id="detail" name="detail" type="text" class="mt-1 block w-full" required
                autocomplete="off">{{ old('detail', $event->detail) }}</x-textarea>
            <x-input-error class="mt-2" :messages="$errors->get('detail')" />
        </div>

        <div>
            <x-input-label for="category" class="required" :value="__('Category')" />

            <select name="category" id="category"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category', $event->category) === $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>


        <div>
            <x-input-label for="date" :value="__('Date')" />
            {{ $event->date }}
        </div>

        <div>
            <x-input-label for="deadline_date" :value="__('Deadline date')" />
            {{ $event->deadline_date }}
        </div>

        <div>
            <x-input-label for="place" class="required" :value="__('Location')" />
            <x-text-input id="place" name="place" type="text" class="mt-1 block w-full" :value="old('place', $event->place)"
                required autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('place')" />
        </div>

        <div>
            <x-input-label for="number_of_recruits" class="required" :value="__('Number of recruits')" />
            <x-text-input id="number_of_recruits" name="number_of_recruits" type="number" class="mt-1 block w-full"
                :value="old('number_of_recruits', $event->number_of_recruits)" required autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('number_of_recruits')" />
        </div>

        <div>
            <x-input-label for="image_path" class="optional" :value="__('Image')" />
            <input id="image_path" name="image_path" type="file" class="mt-1 block w-full" accept="image/*">
            <x-input-error class="mt-2" :messages="$errors->get('image_path')" />
        </div>


        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Update') }}</x-primary-button>

            @if (session('status') === 'event-create')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>

</section>
