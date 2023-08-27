<x-app-layout>
    @vite(['resources/css/admin/app.css', 'resources/js/app.js'])
    <div class="h-screen bg-gray-100 pt-20">
        @if(Cart::instance('cart')->count())
            <h1 class="mb-10 text-center text-2xl font-bold">Cart</h1>
            <div class="mx-auto max-w-5xl justify-center px-6 md:flex md:space-x-6 xl:px-0">
                <div id="products" class="rounded-lg md:w-2/3">
                    @foreach(Cart::instance('cart')->content() as $product)
                        <div class="container_counter justify-between mb-6 rounded-lg bg-white p-6 shadow-md sm:flex sm:justify-start">
                            <img
                                src="{{ $product->model->thumbnailUrl }}"
                                alt="product-image" class="w-full rounded-lg sm:w-40"/>
                            <div class="sm:ml-4 sm:flex sm:w-full sm:justify-between">
                                <div class="mt-5 sm:mt-0">
                                    <h2 class="text-lg font-bold text-gray-900"><a
                                            href="{{ route('products.show', $product->model->slug) }}">{{ $product->name }}</a>
                                    </h2>
                                    <p class="text-sm">{{ $product->price . "uah" }}</p>
                                </div>

                                <div class="mt-4 flex flex-col items-end justify-end sm:space-y-6 sm:mt-0 sm:space-x-6 ">
                                    <div class="qty mt-5">
                                        <input type="hidden" name="row_id" value="{{$product->rowId}}"/>
                                        <input type="hidden" name="product_id" value="{{$product->id}}"/>
                                        <span class="minus bg-dark">-</span>
                                        <input type="number" class="count" name="qty" value="{{$product->qty}}">
                                        <input id="quantity_product" type="hidden" name="quantity_product"
                                               value="{{$product->model->quantity}}"/>
                                        <span class="plus bg-dark">+</span>
                                    </div>

                                    <div class="flex items-center space-x-4">
                                        <p class="text-sm product_subtotal"><b>Total: </b>{{ $product->subtotal . "uah"}}</p>
                                        <form action="{{ route('cart.delete') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="rowId" value="{{$product->rowId}}"/>
                                            <button class="p-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke-width="1.5" stroke="currentColor"
                                                     class="h-5 w-5 cursor-pointer duration-150 hover:text-red-500">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <!-- Sub total -->
                <div class="mt-6 h-full rounded-lg border bg-white p-6 shadow-md md:mt-0 md:w-1/3">
                    <div class="mb-2 flex justify-between">
                        <p class="text-gray-700">Subtotal</p>
                        <p id="subtotal" class="text-gray-700">{{ Cart::subtotal() . "uah" }}</p>
                    </div>
                    <div class="flex justify-between">
                        <p class="text-gray-700">Tax</p>
                        <p id="tax" class="text-gray-700">{{ Cart::tax() . "uah"}}</p>
                    </div>
                    <hr class="my-4"/>
                    <div class="flex justify-between">
                        <p class="text-lg font-bold">Total</p>
                        <div class="flex flex-col items-end">
                            <p id="total" class="mb-1 text-lg font-bold">{{ Cart::total() . "uah"}}</p>
                            <p class="text-sm text-gray-700">including Tax</p>
                        </div>
                    </div>
                    <button
                        class="mt-6 w-full rounded-md bg-blue-500 py-1.5 font-medium text-blue-50 hover:bg-blue-600">
                        Check out
                    </button>
                </div>
            </div>
        @else
            <h3 class="text-center">Your cart is empty</h3>
        @endif
    </div>
</x-app-layout>
