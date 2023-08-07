@push('css')
    <link rel="stylesheet" href="{{ asset('css/event-community.css') }}">
@endpush
@push('script')
    <script src="{{ asset('script/loading.js') }}"></script>
@endpush
@push('script')
    <script src="{{ asset('script/community-dropdown.js') }}"></script>
@endpush
@push('script')
    <script src="{{ asset('script/community-other.js') }}"></script>
@endpush


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('only') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST">
                        @csrf
                        <input type="hidden" name="event_id" value="{{ $event }}">

                        <div>
                            <x-textarea id="content" name="content" type="text" style="height:100px"
                                class="mt-1 block w-full" required autocomplete="off">{{ old('content', '') }}
                            </x-textarea>
                            <div id="content-count">0 / 300</div>
                            <x-input-error class="mt-2" :messages="$errors->get('content')" />
                        </div>

                        <x-primary-button class="send-button" onclick="showLoading()"
                            disabled>{{ __('Post') }}</x-primary-button>

                    </form>

                    @forelse($topics as $topic)
                        <div class="border my-2 p-2 comment-box">
                            <div class="dropdown-container">
                                <div class="dropdown">
                                    <span class="dropdown-btn">&or;</span>
                                    <div class="dropdown-menu">
                                        <a href="#" class="copy-id-btn"
                                            data-topic-id="{{ $topic->id }}">{{ __('Copy ID') }}</a>

                                        @if ($topic->user_id == Auth::id() and $topic->is_deleted == false)
                                            <form method="POST"
                                                action="{{ route('topic.delete', ['event_id' => $event, 'topic_id' => $topic->id]) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit">{{ __('Delete') }}</button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="user-info-wrapper">
                                <img id="preview"
                                    src="{{ isset($topic->user->profile_photo_path) ? Storage::url($topic->user->profile_photo_path) : asset('img/default-user.png') }}"
                                    alt="" class="w-10 h-10 rounded-full object-cover border-none bg-gray-200">
                                <div class="user-info">
                                    <div>{{ $topic->user->name }} <span
                                            class="login-id">{{ $topic->user->login_id }}</span></div>
                                </div>
                            </div>
                            <div class="comment-detail-wrapper">
                                <div class="comment-detail">
                                    @if ($topic->is_deleted == true)
                                        <div class="p-2 is_deleted"><i>{{ __('This post has been deleted') }}</i></div>
                                    @else
                                        <div class="p-2">{{ $topic->content }}</div>
                                    @endif

                                    <div class="text-secondary text-right-abs">{{ $topic->created_at }}</div>
                                </div>
                            </div>




                            <button onclick="toggleEmojiPicker(this)">😀</button>

                            <div class="emoji-picker" style="display: none;">
                                <form action="{{ route('reactions.store', ['topic' => $topic->id]) }}" method="post">
                                    @csrf
                                    <button type="submit" name="emoji" value="😀">😀</button>
                                    <button type="submit" name="emoji" value="😂">😂</button>
                                    <button type="submit" name="emoji" value="😍">😍</button>
                                    <button type="submit" name="emoji" value="😊">😊</button>
                                    <button type="submit" name="emoji" value="👍">👍</button>
                                </form>

                                <button onclick="toggleMoreEmojis(this)">...</button>


                                <div class="more-emojis" style="display: none;">
                                    <form id="reaction-form-{{ $topic->id }}"
                                        action="{{ route('reactions.store', ['topic' => $topic->id]) }}"
                                        method="post">
                                        @csrf
                                        <input id="reaction-emoji-{{ $topic->id }}" type="hidden" name="emoji">
                                    </form>
                                    <div class="emoji-tab-container">
                                        <div class="emoji-tabs">
                                            <button data-tab="smileys"
                                                onclick="switchEmojiTab('smileys', this.parentElement.parentElement.parentElement)">Smileys</button>
                                            <button data-tab="emotions"
                                                onclick="switchEmojiTab('emotions', this.parentElement.parentElement.parentElement)">Emotions</button>
                                            <button data-tab="expressions"
                                                onclick="switchEmojiTab('expressions', this.parentElement.parentElement.parentElement)">Expressions</button>
                                        </div>
                                        <div class="emoji-list">
                                            <!-- 絵文字の一覧はここに表示されます -->
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="reaction-counts">
                                @foreach ($emojis as $emojiCategory => $emojiList)
                                    @foreach ($emojiList as $emoji)
                                        @if (isset($reactionData[$topic->id][$emoji]) && $reactionData[$topic->id][$emoji]['count'] > 0)
                                            <form action="{{ route('reactions.store', ['topic' => $topic->id]) }}"
                                                method="post" onsubmit="event.preventDefault(); this.submit();">
                                                @csrf
                                                <input type="hidden" name="emoji" value="{{ $emoji }}">
                                                <button type="submit" name="emoji"
                                                    style="{{ $reactionData[$topic->id][$emoji]['hasReacted'] ? 'background-color: #ADE0EE;' : '' }}">{{ $emoji }}
                                                    {{ $reactionData[$topic->id][$emoji]['count'] }}</button>
                                            </form>
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>



                        </div>
                    @empty
                        <p>トピックがありません。</p>
                    @endforelse
                    {{ $topics->links('vendor.pagination.tailwind02') }}


                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleEmojiPicker(button) {
            const picker = button.nextElementSibling;
            picker.style.display = picker.style.display === 'none' ? 'block' : 'none';
        }

        function toggleMoreEmojis(button) {
            const moreEmojis = button.nextElementSibling;
            moreEmojis.style.display = moreEmojis.style.display === 'none' ? 'block' : 'none';
        }

        function switchEmojiTab(tabName, picker) {
            const tabs = picker.querySelectorAll('.emoji-tab-container .emoji-tabs button');
            tabs.forEach(tab => tab.classList.remove('active'));
            const selectedTab = picker.querySelector(`.emoji-tab-container .emoji-tabs button[data-tab="${tabName}"]`);
            selectedTab.classList.add('active');

            const emojiList = picker.querySelector('.emoji-tab-container .emoji-list');
            emojiList.innerHTML = '';

            const emojis = {!! json_encode($emojis) !!};
            const emojiCategory = emojis[tabName];

            emojiCategory.forEach(emoji => {
                const button = document.createElement('button');
                button.type = 'button';
                button.name = 'emoji';
                button.value = emoji;
                button.innerHTML = emoji;
                button.onclick = function() {
                    const topicId = this.parentElement.parentElement.parentElement.querySelector('form').id
                        .split('-')[2];
                    document.getElementById(`reaction-emoji-${topicId}`).value = this.value;
                    document.getElementById(`reaction-form-${topicId}`).submit();
                };
                emojiList.appendChild(button);
            });
        }

        window.onload = function() {
            const pickers = document.querySelectorAll('.emoji-picker');
            pickers.forEach(picker => {
                switchEmojiTab('smileys', picker);
            });
        }
    </script>

</x-app-layout>
