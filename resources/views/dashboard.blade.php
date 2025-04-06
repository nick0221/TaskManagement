@php use App\Enums\PublishStatus;use App\Enums\TaskStatus; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{--  Status Summary--}}
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow mb-3">
                            <label class="font-extrabold text-lg text-gray-500">In-progress
                                <hr class="mt-2 mb-4"/>
                            </label>
                            <div class="flex items-center">
                                <i class="fas fa-business-time text-blue-500 text-4xl"></i>
                                <div class="ml-auto text-right font-extrabold text-4xl text-gray-400">
                                    {{ $countProgress == 0 ? '-' : $countProgress }}
                                </div>
                            </div>
                        </div>

                        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow mb-3">
                            <label class="font-extrabold text-lg text-gray-500">Done
                                <hr class="mt-2 mb-4"/>
                            </label>
                            <div class="flex items-center">
                                <i class="fas fa-clipboard-check text-green-400 text-4xl"></i>
                                <div class="ml-auto text-right font-extrabold text-4xl text-gray-400">
                                    {{ $countDone == 0 ? '-' : $countDone }}
                                </div>
                            </div>
                        </div>

                        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow mb-3">
                            <label class="font-extrabold text-lg text-gray-500">Todo
                                <hr class="mt-2 mb-4"/>
                            </label>
                            <div class="flex items-center">
                                <i class="fa-solid fa-pen-clip text-yellow-300 text-4xl"></i>
                                <div class="ml-auto text-right font-extrabold text-4xl text-gray-400">
                                    {{ $countTodo == 0 ? '-' : $countTodo }}
                                </div>
                            </div>
                        </div>

                        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow mb-3">
                            <label class="font-extrabold text-lg text-gray-500">Trash
                                <hr class="mt-2 mb-4"/>
                            </label>
                            <div class="flex items-center">
                                <i class="fas fa-trash text-red-600 text-4xl"></i>
                                <div class="ml-auto text-right font-extrabold text-4xl text-gray-400">
                                    {{ $countTrash == 0 ? '-' : $countTrash }}
                                </div>
                            </div>
                        </div>
                    </div>


                    {{--  Task status tab  --}}
                    <div class="grid grid-cols-1">
                        <div class="mb-4 border-b border-gray-400  col-span-4">
                            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="todo-tab"
                                data-tabs-toggle="#todo-tab-content" role="tablist">
                                <li class="me-2" role="presentation">
                                    <button
                                        class="inline-block p-4 border-b-1 border-transparent rounded-t-lg hover:text-gray-600  "
                                        id="todo-tab"
                                        data-tabs-target="#todo" type="button" role="tab" aria-controls="todo"
                                        aria-selected="false">Todo {{ $countTodo == 0 ? null : '('.$countTodo.')' }}
                                    </button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button
                                        class="inline-block p-4 border-b-1 border-transparent rounded-t-lg hover:text-gray-600  "
                                        id="draft-tab" data-tabs-target="#Draft" type="button" role="tab"
                                        aria-controls="draft" aria-selected="false">
                                        Draft {{ $countDraft == 0 ? null : '('.$countDraft.')' }}
                                    </button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button
                                        class="inline-block p-4 border-b-1 border-transparent rounded-t-lg hover:text-gray-600  "
                                        id="inProgress-tab" data-tabs-target="#inProgress" type="button" role="tab"
                                        aria-controls="inProgress" aria-selected="false">
                                        In-progress {{ $countProgress == 0 ? null : '('.$countProgress.')' }}
                                    </button>
                                </li>

                            </ul>
                        </div>
                        <div id="default-tab-content" class="col-span-3">
                            <div class="hidden rounded-lg h-[1000px]" id="todo" role="tabpanel"
                                 aria-labelledby="todo-tab">
                                {{-- To do Tab List --}}
                                <div id="todolist"
                                     class=" w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                                    <div class="flex items-center justify-between mb-4">
                                        <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white"><i
                                                class="far fa-clipboard-list-check fa-1x"></i>
                                            Todo
                                        </h5>
                                        <a href="{{ route('tasks.create') }}"
                                           class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            Create new
                                        </a>
                                    </div>
                                    <div class="overflow-y-auto" style="max-height: 300px">
                                        <x-task-components.tab-todo :taskTodo="$todotask"/>

                                    </div>
                                </div>

                            </div>
                            <div class="hidden rounded-lg " id="Draft" role="tabpanel"
                                 aria-labelledby="Draft-tab">
                                {{-- Draft Tab List --}}
                                <div id="draftlist"
                                     class="col-span-3 w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                                    <div class="flex items-center justify-between mb-4">
                                        <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">
                                            <i class="far fa-file-alt"></i>
                                            Draft

                                        </h5>
                                        <a href="{{ route('tasks.create') }}"
                                           class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            Create new
                                        </a>
                                    </div>
                                    <div class="overflow-y-auto overflow-x-hidden" style="max-height: 350px">
                                        <x-task-components.tab-draft :taskDraft="$draftTasks"/>
                                    </div>
                                </div>
                            </div>

                            <div class="hidden rounded-lg " id="inProgress"
                                 role="tabpanel"
                                 aria-labelledby="inProgress-tab">
                                {{-- inProgress Tab List --}}
                                <div id="inProgresslist"
                                     class="col-span-3 w-full p-4 bg-white border border-gray-200 rounded-lg shadow sm:p-8">
                                    <div class="flex items-center justify-between mb-4">
                                        <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white">
                                            <i class="far fa-business-time"></i>
                                            In-progress

                                        </h5>
                                        <a href="{{ route('tasks.create') }}"
                                           class="inline-flex items-center font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            Create new
                                        </a>
                                    </div>
                                    <div class="overflow-y-auto overflow-x-hidden" style="max-height: 350px">
                                        <x-task-components.tab-inprogress :taskProgress="$inProgressTasks"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
