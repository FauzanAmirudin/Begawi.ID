<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    /**
     * Ensure the authenticated user is a super admin.
     */
    protected function ensureSuperAdmin(): void
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();

        if (!$user || $user->role !== User::ROLE_SUPER_ADMIN) {
            abort(403, 'Akses ditolak. Hanya Super Admin yang dapat mengakses halaman ini.');
        }
    }

    /**
     * Display a listing of contact messages.
     */
    public function index(Request $request): View
    {
        $this->ensureSuperAdmin();

        $query = ContactMessage::query();

        // Search functionality
        if ($request->filled('search')) {
            $search = trim($request->search);
            if ($search !== '') {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('subject', 'like', "%{$search}%")
                        ->orWhere('message', 'like', "%{$search}%");
                });
            }
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $messages = $query->with('responder')
            ->orderBy('created_at', 'desc')
            ->paginate(15)
            ->withQueryString();

        // Statistics
        $stats = [
            'total' => ContactMessage::count(),
            'unread' => ContactMessage::where('status', 'unread')->count(),
            'read' => ContactMessage::where('status', 'read')->count(),
            'replied' => ContactMessage::where('status', 'replied')->count(),
        ];

        return view('admin.super-admin.contact-messages.index', compact('messages', 'stats'));
    }

    /**
     * Display the specified contact message.
     */
    public function show(int $id): View
    {
        $this->ensureSuperAdmin();

        $message = ContactMessage::with('responder')->findOrFail($id);

        // Mark as read if unread
        if ($message->status === 'unread') {
            $message->markAsRead();
        }

        return view('admin.super-admin.contact-messages.show', compact('message'));
    }

    /**
     * Update the status of a contact message (mark as read/replied).
     */
    public function updateStatus(Request $request, int $id)
    {
        $this->ensureSuperAdmin();

        $request->validate([
            'status' => 'required|in:read,replied',
            'admin_response' => 'required_if:status,replied|string|max:5000',
        ]);

        $message = ContactMessage::findOrFail($id);
        $user = Auth::user();

        if ($request->status === 'replied' && $request->filled('admin_response')) {
            $message->markAsReplied($user->id, $request->admin_response);
        } elseif ($request->status === 'read') {
            $message->markAsRead();
        }

        return redirect()
            ->route('admin.contact-messages.show', $id)
            ->with('success', 'Status pesan berhasil diperbarui.');
    }

    /**
     * Delete a contact message.
     */
    public function destroy(int $id)
    {
        $this->ensureSuperAdmin();

        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()
            ->route('admin.contact-messages.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }
}
