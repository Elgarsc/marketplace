<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Listing;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display all message conversations for the authenticated user
     */
    public function list()
    {
        $userId = Auth::id();

        // Get all unique conversations
        $conversations = Message::where('sender_id', $userId)
            ->orWhere('receiver_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique(function ($message) use ($userId) {
                return $message->sender_id === $userId ? $message->receiver_id : $message->sender_id;
            });

        return view('message.list', compact('conversations'));
    }

    /**
     * Show conversation with a specific user
     */
    public function show(User $user)
    {
        $currentUser = Auth::user();
        $messages = Message::conversation($currentUser->id, $user->id)->get();

        return view('message.show', compact('user', 'messages'));
    }

    /**
     * Send a new message to a user
     */
    public function send(Request $request, User $user)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'listing_id' => 'nullable|exists:listings,id',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $user->id,
            'content' => $validated['content'],
            'listing_id' => $validated['listing_id'] ?? null,
        ]);

        return back()->with('success', 'Message sent successfully!');
    }

    /**
     * Send message from listing detail page
     */
    public function sendFromListing(Request $request, Listing $listing)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $listing->user_id,
            'content' => $validated['content'],
            'listing_id' => $listing->id,
        ]);

        return back()->with('success', 'Message sent to seller!');
    }
}
