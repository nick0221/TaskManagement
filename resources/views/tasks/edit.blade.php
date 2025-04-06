@php use App\Enums\TaskStatus; @endphp
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Task') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="py-4 flex justify-start px-5">
                    <a href="{{ url()->previous() ?? route('tasks.index') }}"
                       class="px-3 py-2 text-xs font-medium text-center text-blue-700 rounded-lg focus:ring-4 focus:outline-none focus:ring-blue-300  ">
                        <i class="fas fa-arrow-left"></i> Back
                    </a>
                </div>

                <div class="p-6 text-gray-900 ">
                    <form action="{{ route('tasks.update', $task) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-3">
                            <div class="col-span-2 w-auto">
                                <div class="mb-5">
                                    <label for="title"
                                           class="block mb-2 text-sm font-medium text-gray-900  ">Title</label>
                                    <label>
                                        <textarea rows="4" name="title"
                                                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5   "
                                                  required>{{ $task->title }}</textarea>
                                    </label>
                                    @error('title')
                                    <x-flash-error-msg>{{ $message }}</x-flash-error-msg>
                                    @enderror
                                </div>

                                <div class="mb-5">
                                    <label for="content"
                                           class="block mb-2 text-sm font-medium text-gray-900  ">Content</label>
                                    <label>
                                        <textarea rows="10" name="content"
                                                  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5   "
                                                  required>{{ $task->content }}</textarea>
                                    </label>
                                    @error('content')
                                    <x-flash-error-msg>{{ $message }}</x-flash-error-msg>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-span-1 ">
                                <div class="flex-col space-y-3">
                                    <div class="flex justify-center mb-3 ">
                                        <img src="{{ $task->image_path }}" width="130"
                                             class="h-auto max-w-full rounded-lg" alt="task image"/>

                                    </div>
                                    <div class="flex justify-center ">
                                        <input type="file" name="image" accept="image/*">
                                    </div>
                                    <div class="flex justify-center mb-5  ">
                                        @error('image')
                                        <x-flash-error-msg>{{ $message }}</x-flash-error-msg>
                                        @enderror
                                    </div>

                                    <div class="p-5">
                                        <label for="status"
                                               class="block mb-2 text-sm font-medium text-gray-900  ">Status</label>
                                        <select id="status" name="status"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5   ">
                                            @foreach(TaskStatus::toSelectArray() as $value => $label)
                                                <option
                                                    value="{{ $value }}" {{ $task->status === $value ? 'selected' : '' }}>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="py-5 px-4">

                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox" value="1" name="published"
                                                {{ $task->published == 1 ? 'checked': null }} />
                                            &nbsp; Published
                                        </label>
                                    </div>
                                </div>

                            </div>


                            <div class="mt-5 col-span-3 flex justify-center">
                                <button type="submit"
                                        class="px-5 py-2 text-medium font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    Submit
                                </button>
                            </div>

                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>

</x-app-layout>
