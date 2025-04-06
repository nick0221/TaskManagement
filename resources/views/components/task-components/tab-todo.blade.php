@php use App\Enums\TaskStatus; @endphp
@props(['taskTodo'])

<ul role="list"
    class="divide-y divide-gray-200 dark:divide-gray-300 border rounded-lg">
    @php $i = 1 @endphp
    @forelse($taskTodo as $todo)
        <li class="py-3 sm:py-4 hover:bg-gray-100 p-2">
            <div class="flex items-center ">
                <div class="pr-3 font-light text-xs text-slate-400">{{ $i }}.
                </div>
                <div class="flex-shrink-0 rounded-sm">
                    <img class="w-8 h-8 "
                         src="{{ $todo->imagePath }}"
                         alt="Bonnie image">
                </div>
                <div class="flex-1 min-w-0 ms-4">
                    <p class="text-lg font-bold  text-gray-500">
                        {{ $todo->limitedTitle }}
                    </p>
                    <p class="text-sm text-gray-500">
                        {{ $todo->limitedContent }}
                    </p>
                    <p class="text-xs text-gray-400">
                        {{ $todo->diffTime }}
                    </p>
                </div>
                <div
                    class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">

                    <div class="inline-flex rounded-md shadow-sm" role="group">
                        {{-- View Button--}}
                        <x-task-components.view-button
                            taskId="{{$todo->id}}">
                            <i class="far fa-eye"></i>
                        </x-task-components.view-button>

                        {{-- Edit Button--}}
                        <x-task-components.edit-button
                            taskId="{{$todo->id}}"
                            isAuthorize="{{$todo->isAuthorizeToEdit($todo)}}">
                            <i class=" far fa-edit"></i>
                        </x-task-components.edit-button>

                        {{-- In Progress Button--}}
                        <x-task-components.inprogress-button
                            taskId="{{$todo->id}}"
                            isAuthorize="{{$todo->isAuthorizeToEdit($todo)}}">
                            <i class="fa-solid fa-list-check"></i>
                        </x-task-components.inprogress-button>

                        {{-- Done Button--}}
                        <x-task-components.done-button
                            taskId="{{$todo->id}}"
                            isAuthorize="{{$todo->isAuthorizeToEdit($todo)}}">
                            <i class="fas fa-clipboard-check text-green-900"></i>
                        </x-task-components.done-button>


                        <!-- Delete button with modal trigger -->
                        <x-task-components.trash-button taskId="{{$todo->id}}">
                            <i class="fas fa-trash"></i>
                        </x-task-components.trash-button>
                    </div>

                </div>
            </div>
        </li>
        @php $i++ @endphp
    @empty
        <div
            class="text-center text-lg font-extrabold align-middle p-10 text-gray-500">
            No task today.

        </div>
    @endforelse


</ul>
