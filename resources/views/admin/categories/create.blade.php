<x-admin-layout>
    <div class="flex items-center justify-center p-12 w-600" style="width: 500px; margin: 0 auto;">
        <div class="mx-auto w-full max-w-[550px]">
            <form action="{{route('admin.categories.store')}}" method="POST">
                @csrf
                <div class="mb-5">
                    <label
                        for="name"
                        class="mb-3 block text-base font-small text-[#07074D]"
                    >
                        Название категории
                    </label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="w-full rounded-sm border border-[#e0e0e0] bg-white py-3 px-6 text-base font-small text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                    />
                </div>

                <div class="col-span-6 sm:col-span-3 mt-4">
                    <label for="country" class="block text-sm font-medium text-gray-700">
                        Родитель</label>
                    <select id="parent" name="parent_id"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option default value="">Выбрать родительскую категорию</option>

                        @foreach($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach

                    </select>
                </div>

                <div class="mb-5 mt-4">
                    <label
                        for="description"
                        class="mb-3 block text-base font-medium text-[#07074D]"
                    >
                        Описание
                    </label>
                    <textarea
                        rows="4"
                        name="description"
                        id="description"
                        class="w-full resize-none rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md"
                    ></textarea>
                </div>
                <div>
                    <button
                        class="hover:shadow-form rounded-sm bg-[#6A64F1] py-3 px-8 text-base font-semibold text-white outline-none"
                        style="background: greenyellow"
                    >
                        Создать
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
