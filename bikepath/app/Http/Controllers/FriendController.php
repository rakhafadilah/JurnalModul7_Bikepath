<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    // Halaman Friends: pencarian rider, featured riders, dan jaringan saya
    public function index(Request $request)
    {
        $user      = Auth::user();
        $following = $user->following()->orderBy('name')->get();
        $followingIds = $following->pluck('id')->all();

        $q      = trim((string) $request->query('q', ''));
        $others = User::where('id', '!=', $user->id)->orderBy('name')->get();

        $recommendations = $others->whereNotIn('id', $followingIds)->values()->take(12);

        $results = $q === ''
            ? collect()
            : $others->filter(fn ($u) => str_contains(mb_strtolower($u->name), mb_strtolower($q)))->values();

        return view('friends', compact('following', 'followingIds', 'q', 'recommendations', 'results'));
    }

    public function follow(User $rider)
    {
        $me = Auth::user();

        if ($rider->id !== $me->id) {
            $me->following()->syncWithoutDetaching([$rider->id]);
        }

        return back()->with('success', 'Kamu mengikuti ' . $rider->name . '.');
    }

    public function unfollow(User $rider)
    {
        Auth::user()->following()->detach($rider->id);

        return back()->with('success', 'Kamu berhenti mengikuti ' . $rider->name . '.');
    }
}
