@php use App\Enums\PublishStatus;use App\Enums\TaskStatus; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Task details') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-6">
                    <div class="py-4 flex justify-start px-5 col-span-4">
                        <a href="{{ url()->previous() ?? route('tasks.index') }}"
                           class="px-3 py-2 text-xs font-medium text-center text-blue-700 rounded-lg focus:outline-none  ">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                    </div>
                    <div class="text-right py-5 px-8 ">
                        <label class="inline-flex items-center">

                            <input type="checkbox" value="1" name="published" disabled
                                {{ $task->published == 1 ? 'checked': null }} />
                            &nbsp; Published
                        </label>
                    </div>
                    <div class=" py-5 px-8 ">
                        <div class="flex flex-col">
                            <label for="status"
                                   class="text-sm font-medium  text-gray-600 align-middle">Status:

                            </label>
                            <span
                                class="{{ TaskStatus::fromValue($task->status)->color($task->status) }}">{{ $task->status }}</span>

                        </div>
                    </div>
                </div>

                <div class="p-6 text-gray-900 ">

                    <div class="grid grid-cols-3">
                        <div class="col-span-2 w-auto">
                            <div class="mb-5">
                                <label for="title"
                                       class="font-extrabold block mb-2 text-sm  text-gray-600">Title</label>
                                <label>
                                    {{ $task->title }}
                                </label>

                            </div>
                            <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-300">
                            <div class="mb-5 relative max-h-[448px] overflow-y-auto">
                                <label for="content"
                                       class="block mb-2 text-sm font-medium text-gray-600">Content</label>
                                <label class="text-justify break-words">
                                    {{ $task->content }}
                                </label>
                            </div>
                        </div>
                        <div class="col-span-1 ">
                            <div class="flex-col space-y-3">
                                <div class="flex justify-center mb-3  ">
                                    <img src="{{ $task->image_path }}" width="130"
                                         class="h-auto max-w-full rounded-lg" alt="task image"/>

                                </div>


                            </div>

                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

</x-app-layout>
