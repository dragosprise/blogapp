<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateCompetitionRequest;
use App\Http\Requests\Admin\EditCompetitionRequest;
use App\Models\Competition;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;

class CompetitionController extends Controller
{
    public function index(): View
    {
        $competitions = Competition::query()
            ->withCount('races')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.competitions.index', [
            'competitions' => $competitions,
        ]);
    }

    public function create(): View
    {
        return view('admin.competitions.create');
    }

    public function store(CreateCompetitionRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $slug = $data['slug'] ?? null;
        $slug = $slug ? Str::slug($slug) : Str::slug($data['name']);
        $data['slug'] = $this->makeUniqueSlug($slug);

        Competition::create($data);

        return redirect()->route('admin.competitions.index')
            ->with('status', __('Competition created successfully.'));
    }

    public function edit(Competition $competition): View
    {
        return view('admin.competitions.edit', [
            'competition' => $competition,
        ]);
    }

    public function update(EditCompetitionRequest $request, Competition $competition): RedirectResponse
    {
        $data = $request->validated();

        $slug = $data['slug'] ?? null;
        $slug = $slug ? Str::slug($slug) : Str::slug($data['name']);
        $data['slug'] = $this->makeUniqueSlug($slug, $competition->getKey());

        $competition->update($data);

        return redirect()->route('admin.competitions.index')
            ->with('status', __('Competition updated successfully.'));
    }

    public function destroy(Competition $competition): RedirectResponse
    {
        if ($competition->races()->exists()) {
            return back()->withErrors(['error' => __('Cannot delete, competition has races.')]);
        }

        $competition->delete();

        return redirect()->route('admin.competitions.index')
            ->with('status', __('Competition deleted successfully.'));
    }

    private function makeUniqueSlug(string $baseSlug, ?int $ignoreId = null): string
    {
        $slug = $baseSlug ?: 'competition';
        $n = 2;

        while (
            Competition::query()
                ->where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))
                ->exists()
        ) {
            $slug = $baseSlug.'-'.$n;
            $n++;
        }

        return $slug;
    }
}

