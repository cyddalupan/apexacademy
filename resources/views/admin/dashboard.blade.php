<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Employees</h3>
                    <p class="text-3xl font-bold text-indigo-600">{{ $stats['employee_count'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Positions</h3>
                    <p class="text-3xl font-bold text-green-600">{{ $stats['position_count'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Training Modules</h3>
                    <p class="text-3xl font-bold text-blue-600">{{ $stats['training_count'] }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900">Flagged</h3>
                    <p class="text-3xl font-bold text-red-600">{{ $stats['flagged_count'] }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
