<x-admin-layout>
    <h6 class="pl-5 pt-4">Товары</h6>

    @if($products->count())
        <div class="card-body pt-1">
            <table id="products" class="table table-striped">
                <thead>
                <tr>
                    <th class="text-center">ID</th>
                    <th></th>
                    <th class="text-center">Имя</th>
                    <th class="text-center">Категория</th>
                    <th class="text-center">SKU</th>
                    <th class="text-center">Кол-во</th>
                    <th class="text-center">Цена</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($products as $product)
                    <tr>
                        <td><p class="text-center">{{$product->id}}</p></td>
                        <td style="width: 5%">
                            <img alt="Avatar" class="no-product-img d-inline-block" src="{{$product->thumbnailUrl}}">
                        </td>
                        <td><p class="text-center">{{$product->title}}</p></td>
                        <td>
                            <div style="max-width: 20%" class="m-auto">
                                @each('admin.categories.partials.link_category', $product->categories, 'category')
                            </div>
                        </td>
                        <td><p class="text-center">{{$product->SKU}}</p></td>
                        <td><p class="text-center">{{$product->quantity}}</p></td>
                        <td><p class="text-center">{{$product->price}}</p></td>
                        <td>
                            <div class="d-flex justify-content-center align-items-center">
                                <div>
                                    <a href="{{route('admin.products.edit', ['product' => $product->slug])}}"
                                       class="text-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>

                                <div class="w-4 mr-2 transform hover:text-purple-500 hover:scale-110">
                                    <form action="{{route('admin.products.destroy', ['product' => $product->slug])}}"
                                          method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn" data-delete-category>
                                            <i class="fas fa-trash text-danger"
                                               data-delete-product="{{$product->title}}"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        {{$products->links()}}
    @endif
</x-admin-layout>
