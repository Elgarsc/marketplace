<x-layout>
    <div class="container-fluid mt-5">
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="display-5 mb-2">
                            <i class="bi bi-people"></i> {{ __('messages.users.title') }}
                        </h1>
                        <p class="text-muted">{{ __('messages.users.sub') }}</p>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> {{ __('messages.users.back_btn') }}
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('messages.users.th_name') }}</th>
                                        <th>{{ __('messages.users.th_email') }}</th>
                                        <th>{{ __('messages.users.th_role') }}</th>
                                        <th>{{ __('messages.users.th_joined') }}</th>
                                        <th>{{ __('messages.users.th_status') }}</th>
                                        <th>{{ __('messages.users.th_actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                    <tr>
                                        <td>{{ $user->id }}</td>
                                        <td>
                                            <strong>{{ $user->name }}</strong>
                                        </td>
                                        <td>
                                            <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                        </td>
                                        <td>
                                            <span class="badge {{ $user->isAdmin() ? 'bg-danger' : ($user->isSeller() ? 'bg-warning' : 'bg-secondary') }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>
                                        <td>
                                            <small>{{ $user->created_at->format('M d, Y') }}</small>
                                        </td>
                                        <td>
                                            @if($user->blocked)
                                            <span class="badge bg-danger">{{ __('messages.users.blocked') }}</span>
                                            @else
                                            <span class="badge bg-success">{{ __('messages.users.active') }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!$user->isAdmin())
                                            @if($user->blocked)
                                            <form action="{{ route('admin.unblockUser', $user) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" title="{{ __('messages.users.unblock') }}">
                                                    <i class="bi bi-check-circle"></i> {{ __('messages.users.unblock') }}
                                                </button>
                                            </form>
                                            @else
                                            <form action="{{ route('admin.blockUser', $user) }}"
                                                method="POST"
                                                style="display:inline;"
                                                data-confirm-message="{{ __('messages.users.block_confirm') }}">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    title="{{ __('messages.users.block') }}"
                                                    onclick="return confirm(this.closest('form').getAttribute('data-confirm-message'))">
                                                    <i class="bi bi-ban"></i> {{ __('messages.users.block') }}
                                                </button>
                                            </form>
                                            @endif
                                            @else
                                            <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            {{ __('messages.users.no_users') }}
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if($users->count() > 0)
                <div class="d-flex justify-content-center mt-4">
                    {{ $users->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>