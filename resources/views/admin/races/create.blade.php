<x-layouts.app>
    @php
        $statusOptions = collect([
            (object) ['id' => 'scheduled', 'name' => 'Scheduled'],
            (object) ['id' => 'cancelled', 'name' => 'Cancelled'],
            (object) ['id' => 'completed', 'name' => 'Completed'],
        ]);
    @endphp

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
        <div class="p-6">
            <form action="{{ route('admin.races.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2">
                            Create Race
                        </h3>

                        <div>
                            <x-forms.select
                                label="Competition"
                                name="competition_id"
                                :options="$competitions"
                                value="{{ old('competition_id') }}"
                            />
                        </div>

                        <div>
                            <x-forms.input label="Title" name="title" placeholder="Enter title" value="{{ old('title') }}" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <x-forms.input label="Season Year" name="season_year" type="number" placeholder="2026" value="{{ old('season_year', now()->year) }}" />
                            <x-forms.select label="Status" name="status" :options="$statusOptions" optionKey="id" optionValue="name" value="{{ old('status', 'scheduled') }}" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <x-forms.input label="Starts At" name="starts_at" type="date" value="{{ old('starts_at') }}" />
                            <x-forms.input label="Ends At" name="ends_at" type="date" value="{{ old('ends_at') }}" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <x-forms.input label="Venue" name="venue" placeholder="Motorsport Park" value="{{ old('venue') }}" />
                            <x-forms.input label="City" name="city" placeholder="Bucuresti" value="{{ old('city') }}" />
                        </div>

                        <div>
                            <x-forms.input label="Classes" name="classes" placeholder="OK-N, Mini, Junior, Senior" value="{{ old('classes') }}" />
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <x-forms.input label="Tickets URL" name="tickets_url" placeholder="https://..." value="{{ old('tickets_url') }}" />
                            <x-forms.input label="Details URL" name="details_url" placeholder="https://..." value="{{ old('details_url') }}" />
                        </div>

                        <div>
                            <x-forms.input label="Image" name="image" type="file" />
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">
                                Uploads are stored under <span class="font-mono">storage/app/public/uploads</span>.
                            </p>
                        </div>

                        <div>
                            <x-forms.checkbox label="Featured" name="is_featured" value="1" :checked="old('is_featured') == '1'" />
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
                            Create Race
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

