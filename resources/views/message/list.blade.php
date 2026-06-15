<x-layout>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h1 class="display-5 mb-4">
                    <i class="bi bi-chat-dots"></i> Messages
                </h1>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 mb-4">
                <!-- Search Messages -->
                <div class="card mb-4 shadow-sm">
                    <div class="card-body">
                        <input
                            type="text"
                            class="form-control mb-3"
                            id="searchConversations"
                            placeholder="Search conversations...">
                    </div>
                </div>
            </div>

            <div class="col-lg-9">
                @if($conversations->count() > 0)
                <div class="list-group">
                    @forelse($conversations as $conversation)
                    @php
                    $otherUser = $conversation->sender_id === Auth::id() ? $conversation->receiver : $conversation->sender;
                    @endphp
                    <a
                        href="{{ route('message.show', $otherUser) }}"
                        class="list-group-item list-group-item-action conversation-item"
                        data-name="{{ strtolower($otherUser->name) }}">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <i class="bi bi-person-circle"></i> {{ $otherUser->name }}
                                </h6>
                                <p class="mb-1 text-muted small">
                                    {{ Str::limit($conversation->content, 60) }}
                                </p>
                            </div>
                            <small class="text-muted ms-2">
                                {{ $conversation->created_at->diffForHumans() }}
                            </small>
                        </div>
                    </a>
                    @empty
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i> No conversations yet
                    </div>
                    @endforelse
                </div>
                @else
                <div class="card text-center py-5">
                    <div class="card-body">
                        <i class="bi bi-chat-dots" style="font-size: 3rem; color: #999;"></i>
                        <h5 class="mt-3 mb-2">No Messages</h5>
                        <p class="text-muted mb-3">Start by contacting a seller about an item</p>
                        <a href="{{ route('listing.index') }}" class="btn btn-primary">
                            <i class="bi bi-search"></i> Browse Listings
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchConversations');
            const conversationItems = document.querySelectorAll('.conversation-item');

            if (searchInput) {
                searchInput.addEventListener('keyup', function() {
                    const searchTerm = this.value.toLowerCase();

                    conversationItems.forEach(item => {
                        const name = item.getAttribute('data-name');
                        if (name.includes(searchTerm)) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
</x-layout>