<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $company->name }}</h2>
            <div class="space-x-2">
                <a href="/super-admin/companies/{{ $company->id }}/edit" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600">Edit</a>
                <a href="/super-admin/companies/{{ $company->id }}/admins" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">Admins</a>
                <a href="/super-admin/companies" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md">Back</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <dl class="grid grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Name</dt>
                        <dd class="text-lg">{{ $company->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Domain</dt>
                        <dd class="text-lg">{{ $company->domain ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status</dt>
                        <dd class="text-lg">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ $company->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($company->status) }}
                            </span>
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Total Users</dt>
                        <dd class="text-lg">{{ $company->users_count ?? 0 }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Created</dt>
                        <dd class="text-lg">{{ $company->created_at->format('M d, Y') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </div>
</x-app-layout>
