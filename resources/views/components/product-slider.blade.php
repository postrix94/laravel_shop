@props([
'product' => null
])

@if($product)
    <div class="col-12 col-sm-6">
        <h3 class="d-inline-block d-sm-none">{{$product->title}}</h3>
        <div class="col-12">
            <img src="{{$product->thumbnailUrl}}" class="product-image" alt="Product Image">
        </div>
        <div class="col-12 product-image-thumbs">
            <div class="product-image-thumb active"><img src="{{$product->thumbnailUrl}}"
                                                         alt="Product Image"></div>

            @foreach($product->images as $image)
                <div class="product-image-thumb active"><img src="{{$image->url}}" alt="Product Image">
                </div>
            @endforeach
        </div>
    </div>
@endif
