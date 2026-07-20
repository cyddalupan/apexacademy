<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Employees</h2>
            <a href="/admin/employees/create" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">+ New Employee</a>
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
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Position</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($employees as $employee)
                        <tr>
                            <td class="px-6 py-4">{{ $employee->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $employee->email }}</td>
                            <td class="px-6 py-4 text-sm">{{ $employee->position?->title ?? '—' }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Active</span>
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="/admin/employees/{{ $employee->id }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                <a href="/admin/employees/{{ $employee->id }}/edit" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4">{{ $employees->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
