<?php

namespace App\Observers;

use App\Models\Listing;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;

class ListingObserver
{
    public function created(Listing $listing): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'created',
            'model_type' => Listing::class,
            'model_id' => $listing->id,
            'description' => 'Created listing "' . $listing->title . '" priced at ' . ($listing->currency === 'EUR' ? '€' : '$') . number_format($listing->price, 2)
        ]);
    }

    public function updated(Listing $listing): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'updated',
            'model_type' => Listing::class,
            'model_id' => $listing->id,
            'description' => 'Updated details for listing "' . $listing->title . '"'
        ]);
    }

    public function deleted(Listing $listing): void
    {
        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'deleted',
            'model_type' => Listing::class,
            'model_id' => $listing->id,
            'description' => 'Deleted listing "' . $listing->title . '"'
        ]);
    }
}
