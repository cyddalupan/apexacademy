<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $position->title }}</h2>
            <div class="space-x-2">
                <a href="/admin/positions/{{ $position->id }}/edit" class="bg-yellow-500 text-white px-4 py-2 rounded-md">Edit</a>
                <a href="/admin/positions" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md">Back</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <dl class="grid grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Title</dt>
                        <dd class="text-lg">{{ $position->title }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Description</dt>
                        <dd class="text-lg">{{ $position->description ?: '—' }}</dd>
                    </div>
                </dl>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Assigned Employees ({{ $position->employees->count() }})</h3>
                @if($position->employees->isNotEmpty())
                <ul class="divide-y divide-gray-200">
                    @foreach($position->employees as $emp)
                    <li class="py-2">{{ $emp->name }}</li>
                    @endforeach
                </ul>
                @else
                <p class="text-gray-500">No employees assigned to this position.</p>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
                <h3 class="text-lg font-semibold mb-4">Training Modules ({{ $position->trainingModules->count() }})</h3>
                @if($position->trainingModules->isNotEmpty())
                <ul class="divide-y divide-gray-200">
                    @foreach($position->trainingModules as $mod)
                    <li class="py-2">{{ $mod->name }}</li>
                    @endforeach
                </ul>
                @else
                <p class="text-gray-500">No training modules assigned.</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
