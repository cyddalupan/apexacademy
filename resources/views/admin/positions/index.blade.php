<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Positions</h2>
            <a href="/admin/positions/create" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">+ New Position</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">{{ session('status') }}</div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employees</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($positions as $position)
                        <tr>
                            <td class="px-6 py-4">{{ $position->title }}</td>
                            <td class="px-6 py-4 text-sm">{{ $position->employees_count ?? 0 }}</td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="/admin/positions/{{ $position->id }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                <a href="/admin/positions/{{ $position->id }}/edit" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4">{{ $positions->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
