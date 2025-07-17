@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}">Главная</a></li>
                @foreach($breadcrumbs as $crumb)
                    <li class="breadcrumb-item">
                        <a href="{{ route('catalog.group', $crumb->id) }}">{{ $crumb->name }}</a>
                    </li>
                @endforeach
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="card">
            <div class="card-body">
                <h3>{{ $product->name }}</h3>
                <p class="text-muted">Цена: {{ number_format($product->price->price, 0, ',', ' ') }} ₽</p>
            </div>
        </div>
    </div>
@endsection
