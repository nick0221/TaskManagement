@php use App\Enums\TaskStatus; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tasks') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900">
                    <div class="py-4 flex justify-end gap-x-3">


                        {{-- Create task --}}
                        <div class="flex items-center">
                            <a href="{{ route('tasks.create') }}"
                               class="px-3 py-2 text-xs font-medium text-center text-white bg-blue-700 rounded hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                <i class="fas fa-plus"></i> Create
                            </a>
                        </div>

                    </div>

                    <div class="relative overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 border">
                            <thead>
                            <tr>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                <span
                                    class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">#</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                <span
                                    class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Img</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">

                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                    <span class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Content</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">

                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                <span
                                    class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Draft/Published</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                <span
                                    class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider">Status</span>
                                </th>
                                <th class="px-6 py-3 bg-gray-50 text-left">
                                <span
                                    class="text-xs leading-4 font-medium text-gray-500 uppercase tracking-wider"></span>
                                </th>
                            </tr>
                            </thead>

                            <tbody class="bg-white divide-y divide-gray-200 divide-solid">


                            </tbody>
                        </table>
                    </div>


                </div>


            </div>
        </div>
    </div>


</x-app-layout>
