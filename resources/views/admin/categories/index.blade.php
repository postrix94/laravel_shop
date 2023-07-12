<x-admin-layout>
    <h6 class="mt-4">Категории</h6>
@if($categories->count())
    <div class="overflow-x-auto">
        <div class="min-w-screen  bg-gray-100 flex items-center justify-center bg-gray-100 font-sans overflow-hidden">
            <div class="w-full lg:w-5/6">
                <div class="bg-white shadow-md rounded my-6">
                    <table class="min-w-max w-full table-auto">
                        <thead>
                        <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Имя</th>
                            <th class="py-3 px-6 text-center">Родитель</th>
                            <th class="py-3 px-6 text-center">Описание</th>
                            <th class="py-3 px-6 text-center">Действие</th>
                        </tr>
                        </thead>
                        <tbody class="text-gray-600 text-sm font-light">

                        @foreach($categories as $category)
                            <x-table-row-categories slug="{{$category->slug}}" name="{{$category->name}}" parent="{{$category->parent ? $category->parent->name : null}}" description="{{$category->description}}"></x-table-row-categories>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{$categories->links()}}
@endif
</x-admin-layout>
