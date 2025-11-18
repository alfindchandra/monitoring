<?php

namespace App\Http\Controllers;

use App\Models\Ormawa;
use App\Models\Activity;
use App\Models\Announcement;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $bem = Ormawa::where('type', 'bem')->where('is_active', true)->first();
        $ukms = Ormawa::where('type', 'ukm')->where('is_active', true)->get();
        $recentActivities = Activity::with('ormawa')
            ->public()
            ->latest()
            ->take(6)
            ->get();
        $announcements = Announcement::with('ormawa')
            ->public()
            ->sent()
            ->latest()
            ->take(5)
            ->get();
        
        return view('homepage.index', compact('bem', 'ukms', 'recentActivities', 'announcements'));
    }

    public function ormawa()
    {
        $bem = Ormawa::where('type', 'bem')->where('is_active', true)->first();
        $ukms = Ormawa::where('type', 'ukm')->where('is_active', true)->get();
        
        return view('public.ormawa.index', compact('bem', 'ukms'));
    }

    public function ormawaDetail($slug)
    {
        $ormawa = Ormawa::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $activities = $ormawa->activities()->public()->latest()->take(6)->get();
        
        return view('public.ormawa.detail', compact('ormawa', 'activities'));
    }
    public function ormawaStructure($slug)
{
    $ormawa = Ormawa::where('slug', $slug)->where('is_active', true)->firstOrFail();
    $members = $ormawa->currentMembers()->with('division')->get();
    $divisions = $ormawa->activeDivisions;
    
    // Group by position
    $structure = [
        'pembina' => $members->where('position', 'pembina')->first(),
        'ketua' => $members->where('position', 'ketua')->first(),
        'wakil_ketua' => $members->where('position', 'wakil_ketua')->first(),
        'sekretaris' => $members->where('position', 'sekretaris')->first(),
        'bendahara' => $members->where('position', 'bendahara')->first(),
        'divisions' => [],
    ];
    
    // Group division members
    foreach ($divisions as $division) {
        $divisionMembers = $members->where('division_id', $division->id);
        $structure['divisions'][$division->id] = [
            'info' => $division,
            'kepala' => $divisionMembers->where('position', 'kepala_divisi')->first(),
            'anggota' => $divisionMembers->where('position', 'anggota_divisi'),
        ];
    }
    
    return view('public.ormawa.structure', compact('ormawa', 'structure', 'divisions'));
}


    public function activities()
    {
        $activities = Activity::with('ormawa')
            ->public()
            ->upcoming()
            ->latest('event_date')
            ->paginate(12);
         $recentActivities = Activity::with('ormawa')
            ->public()
            ->latest()
            ->take(6)
            ->get();
        return view('public.activities', compact('activities', 'recentActivities'));
    }

    public function announcements()
    {
        $announcements = Announcement::with('ormawa')
            ->public()
            ->sent()
            ->latest()
            ->paginate(10);
        
        return view('public.announcements', compact('announcements'));
    }
}
