<x-layout>
    <div class="container py-5">
        <div class="border-bottom pb-3 mb-4">
            <h1 class="fw-bold text-dark mb-1"><i class="bi bi-shield-check text-primary me-2"></i>System Audit Logs</h1>
            <p class="text-muted small mb-0">History trail tracking user modifications and data updates.</p>
        </div>

        <div class="card shadow-sm border-light-subtle overflow-hidden">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light border-bottom text-secondary small text-uppercase">
                        <tr>
                            <th class="ps-4 py-3" style="width: 200px;">Timestamp</th>
                            <th style="width: 180px;">User</th>
                            <th style="width: 120px;">Action</th>
                            <th>Activity Details</th>
                        </tr>
                    </thead>
                    <tbody class="small">
                        @forelse($logs as $log)
                        <tr>
                            <td class="ps-4 text-muted">
                                {{ $log->created_at->format('Y-m-d H:i:s') }}
                            </td>
                            <td>
                                @if($log->user)
                                <span class="fw-semibold text-dark">{{ $log->user->name }}</span>
                                <span class="text-muted d-block" style="font-size: 11px;">ID: #{{ $log->user_id }}</span>
                                @else
                                <span class="text-muted italic">System / Guest</span>
                                @endif
                            </td>
                            <td>
                                @if($log->action === 'created')
                                <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill">Created</span>
                                @elseif($log->action === 'updated')
                                <span class="badge bg-warning-subtle text-warning px-2 py-1 rounded-pill">Updated</span>
                                @else
                                <span class="badge bg-danger-subtle text-danger px-2 py-1 rounded-pill">Deleted</span>
                                @endif
                            </td>
                            <td class="text-secondary">
                                {{ $log->description }}
                                <span class="text-muted font-monospace ms-2" style="font-size: 11px;">({{ class_basename($log->model_type) }} #{{ $log->model_id }})</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5 text-muted">
                                No activity logged yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $logs->links() }}
        </div>
    </div>
</x-layout>