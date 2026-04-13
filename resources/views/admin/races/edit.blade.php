<x-layouts.app>
    @php
        $statusOptions = collect([
            (object) ['id' => 'scheduled', 'name' => 'Scheduled'],
            (object) ['id' => 'cancelled', 'name' => 'Cancelled'],
            (object) ['id' => 'completed', 'name' => 'Completed'],
        ]);

        $img = (string) ($race->image ?? '');
        $imgUrl = null;
        if ($img !== '') {
            $imgUrl = str_contains($img, '/') ? asset($img) : asset('storage/uploads/' . $img);
        }
    @endphp

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
        <div class="p-6">
            <form action="{{ route('admin.races.update', $race->id) }}" method="POST" enctype="multipart/form-data">
                @method('PUT')
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2">
                            Edit Race
                        </h3>

                        <div>
                            <x-forms.select
                                label="Competition"
                                name="competition_id"
                                :options="$competitions"
                                value="{{ old('competition_id', $race->competition_id) }}"
                            />
                        </div>

                        <div>
                            <x-forms.input label="Title" name="title" placeholder="Enter title" value="{{ old('title', $race->title) }}" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <x-forms.input label="Season Year" name="season_year" type="number" value="{{ old('season_year', $race->season_year) }}" />
                            <x-forms.select label="Status" name="status" :options="$statusOptions" optionKey="id" optionValue="name" value="{{ old('status', $race->status) }}" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <x-forms.input label="Starts At" name="starts_at" type="date" value="{{ old('starts_at', optional($race->starts_at)->format('Y-m-d')) }}" />
                            <x-forms.input label="Ends At" name="ends_at" type="date" value="{{ old('ends_at', optional($race->ends_at)->format('Y-m-d')) }}" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <x-forms.input label="Venue" name="venue" value="{{ old('venue', $race->venue) }}" />
                            <x-forms.input label="City" name="city" value="{{ old('city', $race->city) }}" />
                        </div>

                        <div>
                            <x-forms.input label="Classes" name="classes" value="{{ old('classes', $race->classes) }}" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <x-forms.input label="Tickets URL" name="tickets_url" value="{{ old('tickets_url', $race->tickets_url) }}" />
                            <x-forms.input label="Details URL" name="details_url" value="{{ old('details_url', $race->details_url) }}" />
                        </div>

                        <div>
                            <x-forms.input label="Image" name="image" type="file" />
                            @if ($imgUrl)
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                                    Current image:
                                    <a href="{{ $imgUrl }}" target="_blank" rel="noopener">
                                        <img src="{{ $imgUrl }}" alt="{{ $race->title }}" class="mt-2 w-24 h-24 object-cover rounded-md border border-gray-700">
                                    </a>
                                </p>
                            @endif
                        </div>

                        <div>
                            <x-forms.checkbox label="Featured" name="is_featured" value="1" :checked="old('is_featured', $race->is_featured) == '1'" />
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-5 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.races.index') }}"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <x-button type="primary" tag="button" buttonType="submit">
                            Update Race
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

