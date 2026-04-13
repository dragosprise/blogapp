<x-layouts.app>
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden mb-6">
        <div class="p-6">
            <form action="{{ route('admin.competitions.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-800 dark:text-gray-200 border-b border-gray-200 dark:border-gray-700 pb-2">
                            Create Competition
                        </h3>

                        <div>
                            <x-forms.input label="Name" name="name" placeholder="Enter name" value="{{ old('name') }}" />
                        </div>
                        <div>
                            <x-forms.input label="Slug (optional)" name="slug" placeholder="auto-from name if empty" value="{{ old('slug') }}" />
                        </div>
                        <div>
                            <x-forms.textarea label="Description" name="description" placeholder="Optional description">{{ old('description') }}</x-forms.textarea>
                        </div>
                        <div>
                            <x-forms.input label="Sort Order" name="sort_order" type="number" placeholder="0" value="{{ old('sort_order', 0) }}" />
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-5 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-end space-x-3">
                        <a href="{{ route('admin.competitions.index') }}"
                            class="px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </a>
                        <x-button type="primary" tag="button" buttonType="submit">
                            Create Competition
                        </x-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>

