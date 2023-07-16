<x-admin-layout>

    <div class="row justify-content-center pt-4 ml-5 mr-5">
        <div class="col-md-6">
            <form action="{{route('admin.categories.update', ['category' => $category->slug])}}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group col-md">
                        <label for="name">Название категории</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                               name="name"
                               placeholder="Введите название категории" value="{{$category->name}}">
                        @error('name')
                        <div class="invalid-feedback">{{$message}}</div>@enderror
                    </div>

                    <div class="form-group col-md">
                        <label for="inputState">Родительская категория</label>
                        <select id="parent" name="parent_id" class="form-control">
                            <option value="">Выбрать родительскую категорию</option>
                            @foreach($categories as $_category)
                                <option value="{{$_category->id}}"
                                    {{ $_category->id === $category->parent_id ? 'selected' : '' }}>{{$_category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Описание категории</label>
                        <textarea class="form-control  @error('description') is-invalid @enderror" id="description"
                                  name="description" rows="3"
                                  placeholder="Введите описание категории">{{$category->description}}</textarea>
                        @error('description')
                        <div class="invalid-feedback">{{$message}}</div>@enderror

                    </div>
                </div>
                <button type="submit" class="fa-pull-right btn btn-sm btn-success mr-auto">Редактировать</button>
            </form>
        </div>
    </div>


</x-admin-layout>
