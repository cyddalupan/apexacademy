<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Companies</h2>
            <a href="{{ route('super-admin.companies.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">+ New Company</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('status') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Domain</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Users</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($companies as $company)
                        <tr>
                            <td class="px-6 py-4">{{ $company->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $company->domain ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm">{{ $company->users_count ?? 0 }}</td>
                            <td class="px-6 py-4">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $company->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($company->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm space-x-2">
                                <a href="/super-admin/companies/{{ $company->id }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                <a href="/super-admin/companies/{{ $company->id }}/edit" class="text-yellow-600 hover:text-yellow-900">Edit</a>
                                @if($company->status === 'active')
                                <form action="/super-admin/companies/{{ $company->id }}/suspend" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:text-red-900">Suspend</button>
                                </form>
                                @else
                                <form action="/super-admin/companies/{{ $company->id }}/activate" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="text-green-600 hover:text-green-900">Activate</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="p-4">
                    {{ $companies->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
