<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Super Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Companies</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $stats['total_companies'] }}</p>
                    <p class="text-sm text-gray-500">{{ $stats['active_companies'] }} active</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Admins</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['total_admins'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Employees</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['total_employees'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Platform Status</h3>
                    <p class="text-sm text-gray-500 mt-4">All systems operational</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
