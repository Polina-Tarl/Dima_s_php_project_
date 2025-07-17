@extends('layouts.app')

@section('title', 'Каталог')

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-3">
                <h4>Категории</h4>
                <ul class="list-group">
                    @foreach($rootGroups as $group)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <a href="{{ route('catalog.group', ['id' => $group->id]) }}">{{ $group->name }}</a>
                            <span class="badge bg-secondary">{{ $group->product_count ?? 0 }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>


            <div class="col-md-9">
                <h4>Товары</h4>


                <form method="GET" class="mb-3" id="filter-form">
                    <label for="per_page" class="form-label">Товаров на странице:</label>
                    <select name="per_page" id="per_page" class="form-select w-auto d-inline">
                        <option value="6" {{ request('per_page') == 6 ? 'selected' : '' }}>6</option>
                        <option value="12" {{ request('per_page') == 12 ? 'selected' : '' }}>12</option>
                        <option value="18" {{ request('per_page') == 18 ? 'selected' : '' }}>18</option>
                    </select>
                    @foreach(request()->except('per_page', 'page') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                </form>


                @php
                    $sort = request('sort', 'name');
                    $order = request('order', 'asc');
                @endphp

                <div class="mb-3">
                    Сортировка:
                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'order' => 'asc']) }}"
                       class="sort-link {{ $sort === 'name' && $order === 'asc' ? 'fw-bold text-decoration-underline' : '' }}">
                        Название ↑
                    </a> |

                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'name', 'order' => 'desc']) }}"
                       class="sort-link {{ $sort === 'name' && $order === 'desc' ? 'fw-bold text-decoration-underline' : '' }}">
                        ↓
                    </a> |

                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'order' => 'asc']) }}"
                       class="sort-link {{ $sort === 'price' && $order === 'asc' ? 'fw-bold text-decoration-underline' : '' }}">
                        Цена ↑
                    </a> |

                    <a href="{{ request()->fullUrlWithQuery(['sort' => 'price', 'order' => 'desc']) }}"
                       class="sort-link {{ $sort === 'price' && $order === 'desc' ? 'fw-bold text-decoration-underline' : '' }}">
                        ↓
                    </a>
                </div>


                @if(isset($activeGroup))
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}">Главная</a></li>
                            @foreach($activeGroup->breadcrumbs() as $crumb)
                                <li class="breadcrumb-item {{ $loop->last ? 'active' : '' }}">
                                    @if (!$loop->last)
                                        <a href="{{ route('catalog.group', $crumb->id) }}">{{ $crumb->name }}</a>
                                    @else
                                        {{ $crumb->name }}
                                    @endif
                                </li>
                            @endforeach
                        </ol>
                    </nav>
                @endif


                @if(isset($childGroups) && $childGroups->count())
                    <div class="mb-4">
                        <h5>Подкатегории:</h5>
                        <ul class="list-inline">
                            @foreach($childGroups as $child)
                                <li class="list-inline-item">
                                    <a href="{{ route('catalog.group', $child->id) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        {{ $child->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <div id="product-list">
                    @include('catalog._products', ['products' => $products])
                </div>


                <div id="loading-spinner" class="text-center my-4" style="display: none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Загрузка...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const productList = document.querySelector('#product-list');
            const loader = document.querySelector('#loading-spinner');

            function loadProducts(url) {
                if (!productList || !loader) return;

                loader.style.display = 'block';
                productList.style.opacity = '0.5';

                fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.text())
                    .then(html => {
                        productList.innerHTML = html;
                        attachListeners();
                    })
                    .catch(error => console.error('Ошибка загрузки товаров:', error))
                    .finally(() => {
                        loader.style.display = 'none';
                        productList.style.opacity = '1';
                    });
            }

            function attachListeners() {
                document.querySelectorAll('.sort-link').forEach(link => {
                    const clone = link.cloneNode(true);
                    link.replaceWith(clone);
                    clone.addEventListener('click', function (e) {
                        e.preventDefault();
                        loadProducts(this.href);
                    });
                });


                const perPageSelect = document.querySelector('#per_page');
                if (perPageSelect) {
                    const clone = perPageSelect.cloneNode(true);
                    perPageSelect.replaceWith(clone);
                    clone.addEventListener('change', function () {
                        const form = document.querySelector('#filter-form');
                        const url = window.location.href.split('?')[0];
                        const params = new URLSearchParams(new FormData(form)).toString();
                        loadProducts(url + '?' + params);
                    });
                }


                document.querySelectorAll('.pagination a').forEach(link => {
                    const clone = link.cloneNode(true);
                    link.replaceWith(clone);
                    clone.addEventListener('click', function (e) {
                        e.preventDefault();
                        loadProducts(this.href);
                    });
                });
            }

            attachListeners();
        });
    </script>
@endsection
