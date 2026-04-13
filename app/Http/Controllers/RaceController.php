<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use App\Models\Race;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class RaceController extends Controller
{
    public function index(Request $request): View
    {
        $year = (int) $request->query('year', now()->year);
        if ($year < 2000 || $year > 2100) {
            $year = (int) now()->year;
        }

        $competitions = Competition::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $racesByCompetition = Race::query()
            ->with('competition')
            ->where('season_year', $year)
            ->orderByDesc('is_featured')
            ->orderBy('starts_at')
            ->get()
            ->groupBy('competition_id');

        $years = Race::query()
            ->select('season_year')
            ->distinct()
            ->orderByDesc('season_year')
            ->pluck('season_year');

        $upcomingRaces = Race::query()
            ->with('competition')
            ->whereDate('starts_at', '>=', now()->toDateString())
            ->orderBy('starts_at')
            ->take(5)
            ->get();

        return view('races.index', [
            'year' => $year,
            'years' => $years,
            'competitions' => $competitions,
            'racesByCompetition' => $racesByCompetition,
            'upcomingRaces' => $upcomingRaces,
        ]);
    }

    public function show(Race $race): View
    {
        $race->load('competition');

        return view('races.show', [
            'race' => $race,
        ]);
    }
}

