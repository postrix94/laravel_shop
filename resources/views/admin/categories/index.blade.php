<x-admin-layout>
    <h6 class="pl-5 pt-4">Категории</h6>

@if($categories->count())
        <div class="card-body pt-1">
            <table id="categories" class="table table-striped">
                <thead>
                <tr>
                    <th class="text-center">Имя</th>
                    <th class="text-center">Родитель</th>
                    <th class="text-center">Описание</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                     <x-table-row-categories slug="{{$category->slug}}" name="{{$category->name}}" parent="{{$category->parent ? $category->parent->name : null}}" description="{{$category->description}}"></x-table-row-categories>
                @endforeach
                </tbody>
            </table>
        </div>
    {{$categories->links()}}
@endif
</x-admin-layout>
