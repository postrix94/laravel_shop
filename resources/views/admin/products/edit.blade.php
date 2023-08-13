<x-admin-layout>
    <div class="row justify-content-center pt-4 ml-5 mr-5">
        <div class="col-md-6">
            <form action="{{route('admin.products.update', ['product' => $product->slug])}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group col-md">
                        <label for="title">Название товара</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                               name="title"
                               placeholder="Введите название товара" value="{{$product->title}}">
                        @error('title')
                        <div class="invalid-feedback">{{$message}}</div>@enderror


                        <div class="d-flex">
                            <div class="form-group col-md-6 mt-3">
                                <label for="price">Цена</label>
                                <input type="text" class="form-control @error('price') is-invalid @enderror" id="price"
                                       name="price"
                                       placeholder="Введите цену товара"
                                       value="{{$product->price}}">
                                @error('price')
                                <div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>

                            <div class="form-group col-md-6 mt-3">
                                <label for="SKU">SKU</label>
                                <input type="text" class="form-control @error('SKU') is-invalid @enderror" id="SKU"
                                       name="SKU"
                                       placeholder="Введите SKU" value="{{$product->SKU}}">
                                @error('SKU')
                                <div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                        </div>

                        <div class="d-flex">
                            <div class="form-group col-md-6 mt-3">
                                <label for="discount">Скидка</label>
                                <input type="text" class="form-control @error('discount') is-invalid @enderror"
                                       id="discount" name="discount"
                                       value="{{$product->discount}}">
                                @error('discount')
                                <div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>

                            <div class="form-group col-md-6 mt-3">
                                <label for="quantity">Кол-во</label>
                                <input type="text" class="form-control @error('quantity') is-invalid @enderror"
                                       id="quantity" name="quantity"
                                       placeholder="Введите колличество товара"
                                       value="{{$product->quantity}}">
                                @error('quantity')
                                <div class="invalid-feedback">{{$message}}</div>@enderror
                            </div>
                        </div>

                        <div class="form-group col-md">
                            <label for="inputState">Категории</label>
                            <select id="category" name="categories[]" class="form-control" multiple>
                                <option value="">Без категории</option>
                                @foreach($categories as $category)
                                    <option
                                        @if($product->categories->contains($category)) selected @endif
                                        value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="description">Описание товара</label>
                            <textarea class="form-control  @error('description') is-invalid @enderror" id="description"
                                      name="description" rows="3"
                                      placeholder="Введите описание категории">{{$product->descripiton}}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{$message}}</div>@enderror
                        </div>


                        <div class="form-group">
                            <div class="form-group text-center">
                                <img src="{{$product->thumbnailUrl}}" id="thumbnail-preview" class="thumbnail-preview">
                            </div>

                            <div class="custom-file">
                                <div>
                                    <div class="upload">
                                        <div class="position-absolute c-upload">
                                            <div class="text-center">
                                                <span>Загрузить обложку</span>
                                                <i class="fas fa-upload"></i>
                                            </div>
                                        </div>
                                        <input type="file" id="thumbnail" name="thumbnail">
                                    </div>
                                </div>
                            </div>
                            @error('thumbnail')<div class="text-danger">{{$message}}</div>@enderror
                        </div>

                        <div class="form-group">
                            <div id="productImagesWrapper" class="form-group images-wrapper">
                                @foreach($product->images as $image)
                                    <div class="mb-4 text-center position-relative">
                                        <button class="btn position-absolute right-0">
                                            <i class="fas fa-trash text-danger" data-route="{{route('ajax.images.delete', $image)}}"></i>
                                        </button>
                                        <img src="{{$image->url}}" style="width: 50%" />
                                    </div>
                                @endforeach

                            </div>

                            <div class="custom-file">
                                <div>
                                    <div class="upload">
                                        <div class="position-absolute c-upload">
                                            <div class="text-center">
                                                <span>Загрузить изображения товара</span>
                                                <i class="fas fa-upload"></i>
                                            </div>
                                        </div>
                                        <input type="file" id="images" name="images[]" multiple>
                                    </div>
                                </div>
                            </div>
                            @error('images')<div class="text-danger">{{$message}}</div>@enderror
                        </div>

                    </div>
                </div>

                <button type="submit" class="fa-pull-right btn btn-sm btn-success mr-auto">Обновить</button>
            </form>
        </div>
    </div>

</x-admin-layout>
