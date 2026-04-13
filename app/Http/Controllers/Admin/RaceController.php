<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateRaceRequest;
use App\Http\Requests\Admin\EditRaceRequest;
use App\Models\Competition;
use App\Models\Race;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class RaceController extends Controller
{
    public function index(): View
    {
        $races = Race::query()
            ->with('competition')
            ->orderByDesc('starts_at')
            ->paginate(20);

        return view('admin.races.index', [
            'races' => $races,
        ]);
    }

    public function create(): View
    {
        $competitions = Competition::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.races.create', [
            'competitions' => $competitions,
        ]);
    }

    public function store(CreateRaceRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $filename = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('uploads', $filename, 'public');
            $data['image'] = $filename;
        }

        $data['is_featured'] = $request->boolean('is_featured');

        Race::create($data);

        return redirect()->route('admin.races.index')
            ->with('status', __('Race created successfully.'));
    }

    public function edit(Race $race): View
    {
        $competitions = Competition::query()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('admin.races.edit', [
            'race' => $race,
            'competitions' => $competitions,
        ]);
    }

    public function update(EditRaceRequest $request, Race $race): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('image')) {
            $this->deleteRaceImageIfUpload($race);

            $filename = time().'_'.$request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('uploads', $filename, 'public');
            $data['image'] = $filename;
        }

        $data['is_featured'] = $request->boolean('is_featured');

        $race->update($data);

        return redirect()->route('admin.races.index')
            ->with('status', __('Race updated successfully.'));
    }

    public function destroy(Race $race): RedirectResponse
    {
        $this->deleteRaceImageIfUpload($race);

        $race->delete();

        return redirect()->route('admin.races.index')
            ->with('status', __('Race deleted successfully.'));
    }

    private function deleteRaceImageIfUpload(Race $race): void
    {
        $img = (string) ($race->image ?? '');
        if ($img === '' || str_contains($img, '/')) {
            return;
        }

        Storage::disk('public')->delete('uploads/'.$img);
    }
}

