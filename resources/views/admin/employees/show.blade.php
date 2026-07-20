<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $employee->name }}</h2>
            <div class="space-x-2">
                <a href="/admin/employees/{{ $employee->id }}/edit" class="bg-yellow-500 text-white px-4 py-2 rounded-md">Edit</a>
                <a href="/admin/employees" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md">Back</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <dl class="grid grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="text-lg">{{ $employee->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Email</dt>
                        <dd class="text-lg">{{ $employee->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Position</dt>
                        <dd class="text-lg">{{ $employee->position?->title ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="text-lg"><span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span></dd>
                    </div>
                </dl>
            </div>

            @if($employee->trainings->isNotEmpty())
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
                <h3 class="text-lg font-semibold mb-4">Training Progress</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Module</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($employee->trainings as $training)
                        <tr>
                            <td class="px-6 py-4">{{ $training->trainingModule?->name ?? 'Unknown' }}</td>
                            <td class="px-6 py-4">{{ ucfirst($training->status) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
