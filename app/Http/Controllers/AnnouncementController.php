<?php
namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\Ormawa;
use App\Models\AnnouncementRecipient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class AnnouncementController extends Controller
{
    use AuthorizesRequests;
    public function index(Request $request)
    {
        $user = $request->user();
        
        $announcements = Announcement::with(['ormawa', 'recipients'])
            ->where('ormawa_id', $user->ormawa_id)
            ->latest()
            ->paginate(10);
        
        return view('announcements.index', compact('announcements'));
    }

    public function create()
    {
        $ormawas = Ormawa::where('is_active', true)->get();
        
        return view('announcements.create', compact('ormawas'));
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'content' => 'required|string',
        'priority' => 'required|in:low,normal,high,urgent',
        'is_public' => 'boolean',
        'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        'recipients' => 'required|array',
        'recipients.*' => 'exists:ormawas,id',
    ]);

    $user = $request->user();
    $attachmentPath = null;

    if ($request->hasFile('attachment')) {
        $attachmentPath = $request->file('attachment')->store('announcements', 'public');
    }

    // --- LOGIKA BARU UNTUK ORMAWA_ID ---
    
    // Periksa apakah pengguna adalah Admin (ganti dengan logika peran Anda)
    // Contoh: Jika user memiliki role 'admin' atau menggunakan method isAdmin()
    $isAdmin = $user->role === 'admin'; 
    
    if ($isAdmin) {
        // Admin membuat pengumuman atas nama sistem/kampus, tidak terikat ORMAWA
        $ormawaId = null; 
    } elseif (is_null($user->ormawa_id)) {
        // Pengguna non-admin/ORMAWA yang tidak terikat ORMAWA tidak boleh membuat pengumuman
        return back()->with('error', 'Akun Anda harus terdaftar pada salah satu ORMAWA untuk membuat pengumuman.')->withInput();
    } else {
        // Pengguna ORMAWA membuat pengumuman atas nama ORMAWA-nya
        $ormawaId = $user->ormawa_id;
    }

    // --- AKHIR LOGIKA BARU ---

    // Create announcement
    $announcement = Announcement::create([
        'user_id' => $user->id,
        'ormawa_id' => $ormawaId, // Menggunakan variabel yang sudah ditentukan
        'title' => $validated['title'],
        'content' => $validated['content'],
        'priority' => $validated['priority'],
        'is_public' => $request->boolean('is_public'),
        'attachment' => $attachmentPath,
        'status' => 'draft',
    ]);

    // Add recipients (Logika ini sudah benar)
    foreach ($validated['recipients'] as $recipientOrmawaId) {
        // Jangan kirim ke diri sendiri, kecuali jika pengirimnya adalah Admin (null)
        // Kita hanya perlu memastikan bahwa ormawa_id pengirim tidak sama dengan ormawa_id penerima
        if ($recipientOrmawaId != $ormawaId) {
            AnnouncementRecipient::create([
                'announcement_id' => $announcement->id,
                'ormawa_id' => $recipientOrmawaId,
            ]);
        }
    }

    return redirect()->route('announcements.show', $announcement)
        ->with('success', 'Pengumuman berhasil dibuat sebagai draft.');
}
    public function show(Announcement $announcement)
    {
        $this->authorize('view', $announcement);
        
        $announcement->load(['ormawa', 'user', 'recipients']);
        
        return view('announcements.show', compact('announcement'));
    }

    public function edit(Announcement $announcement)
    {
        $this->authorize('update', $announcement);
        
        if ($announcement->status === 'sent') {
            return back()->with('error', 'Pengumuman yang sudah terkirim tidak dapat diedit.');
        }
        
        $ormawas = Ormawa::where('is_active', true)->get();
        $announcement->load('recipients');
        
        return view('announcements.edit', compact('announcement', 'ormawas'));
    }

    public function update(Request $request, Announcement $announcement)
    {
        $this->authorize('update', $announcement);
        
        if ($announcement->status === 'sent') {
            return back()->with('error', 'Pengumuman yang sudah terkirim tidak dapat diedit.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'priority' => 'required|in:low,normal,high,urgent',
            'is_public' => 'boolean',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'recipients' => 'required|array',
            'recipients.*' => 'exists:ormawas,id',
        ]);

        // Handle file upload
        if ($request->hasFile('attachment')) {
            // Delete old file
            if ($announcement->attachment) {
                Storage::disk('public')->delete($announcement->attachment);
            }
            $validated['attachment'] = $request->file('attachment')->store('announcements', 'public');
        }

        $announcement->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'priority' => $validated['priority'],
            'is_public' => $request->boolean('is_public'),
            'attachment' => $validated['attachment'] ?? $announcement->attachment,
        ]);

        // Update recipients
        $announcement->announcementRecipients()->delete();
        
        foreach ($validated['recipients'] as $ormawaId) {
            if ($ormawaId != $request->user()->ormawa_id) {
                AnnouncementRecipient::create([
                    'announcement_id' => $announcement->id,
                    'ormawa_id' => $ormawaId,
                ]);
            }
        }

        return redirect()->route('announcements.show', $announcement)
            ->with('success', 'Pengumuman berhasil diperbarui.');
    }

    public function destroy(Announcement $announcement)
    {
        $this->authorize('delete', $announcement);
        
        if ($announcement->status === 'sent') {
            return back()->with('error', 'Pengumuman yang sudah terkirim tidak dapat dihapus.');
        }

        if ($announcement->attachment) {
            Storage::disk('public')->delete($announcement->attachment);
        }

        $announcement->delete();

        return redirect()->route('announcements.index')
            ->with('success', 'Pengumuman berhasil dihapus.');
    }

    public function send(Announcement $announcement)
    {
        $this->authorize('update', $announcement);
        
        if ($announcement->status === 'sent') {
            return back()->with('error', 'Pengumuman sudah terkirim sebelumnya.');
        }

        $announcement->markAsSent();

        return redirect()->route('announcements.show', $announcement)
            ->with('success', 'Pengumuman berhasil dikirim ke semua penerima.');
    }

    public function inbox(Request $request)
    {
        $user = $request->user();
        
        $announcements = $user->ormawa->receivedAnnouncements()
            ->with(['ormawa', 'user'])
            ->latest('announcements.created_at')
            ->paginate(10);
        
        return view('announcements.inbox', compact('announcements'));
    }

    public function markAsRead(Announcement $announcement, Request $request)
    {
        $user = $request->user();
        
        $recipient = AnnouncementRecipient::where('announcement_id', $announcement->id)
            ->where('ormawa_id', $user->ormawa_id)
            ->first();
        
        if ($recipient) {
            $recipient->markAsRead();
        }
        
        return back();
    }
    public function manageAdmins()
    {
        $this->authorize('manageAdmins', Announcement::class);

        $announcements = Announcement::with(['ormawa', 'recipients'])
            ->latest()
            ->paginate(10);

        return view('pengumumans.index', compact('announcements'));
    }
}