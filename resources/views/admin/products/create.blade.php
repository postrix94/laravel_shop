<x-admin-layout>

    <div class="row justify-content-center pt-4 ml-5 mr-5">
        <div class="col-md-6">
            <form action="{{route('admin.products.store')}}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group col-md">
                        <label for="title">Название товара</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                               placeholder="Введите название товара" @if(old('title')) value="{{old('title')}}"  @endif>
                        @error('title')<div class="invalid-feedback">{{$message}}</div>@enderror


                    <div class="d-flex">
                        <div class="form-group col-md-6 mt-3">
                            <label for="price">Цена</label>
                            <input type="text" class="form-control @error('price') is-invalid @enderror" id="price" name="price"
                                   placeholder="Введите цену товара" @if(old('price')) value="{{old('price')}}"  @endif>
                            @error('price')<div class="invalid-feedback">{{$message}}</div>@enderror
                        </div>

                        <div class="form-group col-md-6 mt-3">
                            <label for="SKU">SKU</label>
                            <input type="text" class="form-control @error('SKU') is-invalid @enderror" id="SKU" name="SKU"
                                   placeholder="Введите SKU" @if(old('SKU')) value="{{old('SKU')}}"  @endif>
                            @error('SKU')<div class="invalid-feedback">{{$message}}</div>@enderror
                        </div>
                    </div>

                        <div class="d-flex">
                            <div class="form-group col-md-6 mt-3">
                                <label for="discount">Скидка</label>
                                <input type="text" class="form-control @error('discount') is-invalid @enderror" id="discount" name="discount"
                                       value="0">
                                @error('discount')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>

                            <div class="form-group col-md-6 mt-3">
                                <label for="quantity">Кол-во</label>
                                <input type="text" class="form-control @error('quantity') is-invalid @enderror" id="quantity" name="quantity"
                                       placeholder="Введите колличество товара" @if(old('quantity')) value="{{old('quantity')}}"  @endif>
                                @error('quantity')<div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                        </div>

                    <div class="form-group col-md">
                        <label for="inputState">Категории</label>
                        <select id="category" name="categories[]" class="form-control" multiple>
                            <option value="">Без категории</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Описание товара</label>
                        <textarea class="form-control  @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Введите описание категории">@if(old('description')){{old('description')}}@endif</textarea>
                        @error('description')<div class="invalid-feedback">{{$message}}</div>@enderror

                    </div>
                </div>
                <button type="submit" class="fa-pull-right btn btn-sm btn-success mr-auto">Создать</button>
            </form>
        </div>
    </div>

</x-admin-layout>
