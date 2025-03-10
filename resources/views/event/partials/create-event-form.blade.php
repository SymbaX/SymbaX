<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Create event') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Create a new event.') }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('event.store') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" class="required" :value="__('Event Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', '')"
                required autofocus autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <div class="label-with-tooltip">
                <x-input-label for="detail" class="required" :value="__('Detail')" />
                <span class="tooltip">
                    <span class="tooltip-text">
                        {{ __('Markdown notation can be used for this item.') }}
                    </span>
                </span>
            </div>
            <x-textarea id="detail" name="detail" type="text" class="mt-1 block w-full" required
                autocomplete="off">
                {{ old('detail', '') }}
            </x-textarea>
            <x-input-error class="mt-2" :messages="$errors->get('detail')" />
        </div>

        <div>
            <x-input-label for="category" class="required" :value="__('Category')" />
            <select name="category" id="category"
                class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">

                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $selectedCategoryId == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>


        <div>
            <x-input-label for="date" class="required" :value="__('Date')" />
            <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" :value="old('date', '')"
                required autocomplete="off" />
            <x-input-hint-text>
                {{ __('This item cannot be changed later.') }}
            </x-input-hint-text>
            <x-input-error class="mt-2" :messages="$errors->get('date')" />
        </div>

        <div>
            <x-input-label for="deadline_date" class="required" :value="__('Deadline date')" />
            <x-text-input id="deadline_date" name="deadline_date" type="date" class="mt-1 block w-full"
                :value="old('deadline_date', '')" required autocomplete="off" />
            <x-input-hint-text>
                {{ __('This item cannot be changed later.') }}
            </x-input-hint-text>
            <x-input-error class="mt-2" :messages="$errors->get('deadline_date')" />
        </div>

        <div>
            <x-input-label for="place" class="required" :value="__('Location')" />
            <x-text-input id="place" name="place" type="text" class="mt-1 block w-full" :value="old('place', '')"
                required autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('place')" />
        </div>

        <div>
            <x-input-label for="number_of_recruits" class="required" :value="__('Number of recruits')" />
            <x-text-input id="number_of_recruits" name="number_of_recruits" type="text" class="mt-1 block w-full"
                :value="old('number_of_recruits', '')" required autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('number_of_recruits')" />
        </div>

        <div>
            <x-input-label for="image_path" class="required" :value="__('Image')" />
            <x-text-input id="image_path" name="image_path" type="file" class="mt-1 block w-full" :value="old('image_path', '')"
                required autocomplete="off" />
            <x-input-error class="mt-2" :messages="$errors->get('image_path')" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>

</section>
