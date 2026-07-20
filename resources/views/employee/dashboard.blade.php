<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Training') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if($trainings->isEmpty())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-center">
                    <p class="text-gray-500">No training modules assigned yet.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($trainings as $training)
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h3 class="text-lg font-semibold">{{ $training->trainingModule->name }}</h3>
                                    <p class="text-sm text-gray-500">Status: 
                                        <span class="font-medium 
                                            @if($training->status === 'completed') text-green-600
                                            @elseif($training->status === 'flagged') text-red-600
                                            @else text-yellow-600 @endif">
                                            {{ ucfirst($training->status) }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <div class="w-32 bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-indigo-600 h-2.5 rounded-full" style="width: 0%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
