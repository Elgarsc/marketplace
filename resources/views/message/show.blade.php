<x-layout>
    <div class="container mt-5 mb-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white p-3">
                        <div class="d-flex align-items-center justify-content-between">
                            <div>
                                <h5 class="mb-0">
                                    <i class="bi bi-person-circle"></i> {{ $user->name }}
                                </h5>
                                <small class="text-white-50">
                                    {{ __('messages.chat.member_since', ['date' => $user->created_at->format('M Y')]) }}
                                </small>
                            </div>
                            <a href="{{ route('message.list') }}" class="btn btn-light btn-sm">
                                <i class="bi bi-arrow-left"></i> {{ __('messages.chat.back_btn') }}
                            </a>
                        </div>
                    </div>

                    <div class="card-body" style="height: 400px; overflow-y: auto; background-color: #f8f9fa;">
                        @forelse($messages as $message)
                        <div class="mb-3 d-flex {{ $message->sender_id === Auth::id() ? 'justify-content-end' : 'justify-content-start' }}">
                            <div class="card {{ $message->sender_id === Auth::id() ? 'bg-primary text-white' : 'bg-light' }} p-3" style="max-width: 70%;">
                                <p class="mb-1">{{ $message->content }}</p>
                                <small class="{{ $message->sender_id === Auth::id() ? 'text-white-50' : 'text-muted' }}">
                                    {{ $message->created_at->format('H:i') }}
                                </small>

                                @if($message->listing)
                                <hr class="my-2">
                                <small>
                                    <strong>{{ __('messages.chat.about') }}</strong>
                                    <a href="{{ route('listing.show', $message->listing) }}" class="text-decoration-none {{ $message->sender_id === Auth::id() ? 'text-white' : 'text-primary' }}">
                                        {{ $message->listing->title }}
                                    </a>
                                </small>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="bi bi-chat-dots" style="font-size: 3rem; color: #999;"></i>
                            <p class="text-muted mt-3">{{ __('messages.chat.no_messages') }}</p>
                        </div>
                        @endforelse
                    </div>

                    <div class="card-footer bg-light border-top p-3">
                        <form action="{{ route('message.send', $user) }}" method="POST">
                            @csrf
                            <div class="input-group">
                                <textarea
                                    name="content"
                                    class="form-control"
                                    rows="2"
                                    placeholder="{{ __('messages.chat.placeholder') }}"
                                    required></textarea>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send"></i> {{ __('messages.chat.send_btn') }}
                                </button>
                            </div>
                            @error('content')
                            <div class="text-danger small mt-2">{{ $errors->first('content') }}</div>
                            @enderror
                        </form>
                    </div>
                </div>

                <div class="mt-4">
                    <h6 class="mb-3">{{ __('messages.chat.about_user') }}</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card p-3 text-center">
                                <i class="bi bi-person-circle text-primary" style="font-size: 2rem;"></i>
                                <h6 class="mt-2">{{ $user->name }}</h6>
                                <p class="text-muted small mb-0">{{ $user->role === 'seller' ? __('messages.chat.seller') : __('messages.chat.buyer') }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card p-3 text-center">
                                <i class="bi bi-calendar-event text-primary" style="font-size: 2rem;"></i>
                                <h6 class="mt-2">{{ __('messages.chat.joined') }}</h6>
                                <p class="text-muted small mb-0">{{ $user->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Auto-scroll to bottom of messages
            const messagesContainer = document.querySelector('.card-body');
            if (messagesContainer) {
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            }
        });
    </script>
</x-layout>