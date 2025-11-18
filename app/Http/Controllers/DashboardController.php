<?php
// app/Http/Controllers/DashboardController.php

namespace App\Http\Controllers;

use App\Models\Ormawa;
use App\Models\Announcement;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        
        if ($user->isAdmin()) {
            return $this->adminDashboard();
        } elseif ($user->isKetuaBem()) {
            return $this->ketuaBemDashboard($user);
        } else {
            return $this->ketuaUkmDashboard($user);
        }
    }

    private function adminDashboard()
    {
        // Basic Stats
        $totalOrmawa = Ormawa::count();
        $totalUsers = User::count();
        $totalAnnouncements = Announcement::where('status', 'sent')->count();
        $totalActivities = Activity::count();
        
        // Monthly Stats
        $announcementsThisMonth = Announcement::where('status', 'sent')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        // Upcoming Activities
        $upcomingActivities = Activity::where('event_date', '>=', now()->toDateString())
            ->count();
        
        // Active ORMAWA
        $activeOrmawa = Ormawa::where('is_active', true)->count();
        
        // Recent Announcements
        $recentAnnouncements = Announcement::with(['ormawa', 'user'])
            ->latest()
            ->take(5)
            ->get();
        
        // Recent Activities
        $recentActivities = Activity::with('ormawa')
            ->latest()
            ->take(5)
            ->get();
        
        // ORMAWA Statistics with counts
        $ormawaStats = Ormawa::withCount([
            'members' => function($query) {
                $query->where('is_active', true);
            },
            'activities',
            'announcements' => function($query) {
                $query->where('status', 'sent');
            }
        ])->get();
        
        return view('dashboard.admin', compact(
            'totalOrmawa',
            'totalUsers',
            'totalAnnouncements',
            'totalActivities',
            'announcementsThisMonth',
            'upcomingActivities',
            'activeOrmawa',
            'recentAnnouncements',
            'recentActivities',
            'ormawaStats'
        ));
    }

    private function ketuaBemDashboard($user)
    {
        $ormawa = $user->ormawa;
        
        $sentAnnouncements = Announcement::where('ormawa_id', $ormawa->id)
            ->sent()
            ->count();
        
        $receivedAnnouncements = $ormawa->receivedAnnouncements()
            ->wherePivot('is_read', false)
            ->count();
        
        $recentSent = Announcement::where('ormawa_id', $ormawa->id)
            ->with('recipients')
            ->latest()
            ->take(5)
            ->get();
        
        $recentReceived = $ormawa->receivedAnnouncements()
            ->with('ormawa')
            ->latest('announcements.created_at')
            ->take(5)
            ->get();
        
        return view('dashboard.ketua-bem', compact(
            'ormawa',
            'sentAnnouncements',
            'receivedAnnouncements',
            'recentSent',
            'recentReceived'
        ));
    }

    private function ketuaUkmDashboard($user)
    {
        $ormawa = $user->ormawa;
        
        $sentAnnouncements = Announcement::where('ormawa_id', $ormawa->id)
            ->sent()
            ->count();
        
        $receivedAnnouncements = $ormawa->receivedAnnouncements()
            ->wherePivot('is_read', false)
            ->count();
        
        $totalActivities = Activity::where('ormawa_id', $ormawa->id)->count();
        
        $recentSent = Announcement::where('ormawa_id', $ormawa->id)
            ->with('recipients')
            ->latest()
            ->take(5)
            ->get();
        
        $recentReceived = $ormawa->receivedAnnouncements()
            ->with('ormawa')
            ->latest('announcements.created_at')
            ->take(5)
            ->get();
        
        return view('dashboard.ketua-ukm', compact(
            'ormawa',
            'sentAnnouncements',
            'receivedAnnouncements',
            'totalActivities',
            'recentSent',
            'recentReceived'
        ));
    }
}