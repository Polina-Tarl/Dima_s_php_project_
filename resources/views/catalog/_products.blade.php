<div class="row">
    @forelse($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="{{ route('catalog.product', $product->id) }}">
                            {{ $product->name }}
                        </a>
                    </h5>
                    <p class="card-text">
                        Цена: {{ number_format($product->price->price, 0, ',', ' ') }}₽
                    </p>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <p>Нет товаров в этой категории.</p>
        </div>
    @endforelse
</div>


@if ($products->hasPages())
    <div class="d-flex justify-content-center w-100 pagination">
        {{ $products->withQueryString()->links() }}
    </div>
@endif
