@extends('layouts.app')

@section('content')
    <div class="container">
        <h4>AJAX тест: выбор количества</h4>

        <form id="test-form" method="GET" class="mb-3">
            <label for="per_page" class="form-label">Товаров на странице:</label>
            <select name="per_page" id="per_page" class="form-select w-auto d-inline">
                <option value="6">6</option>
                <option value="12">12</option>
                <option value="18">18</option>
            </select>
        </form>

        <div id="output">
            <p>Выбрано: <strong id="result">6</strong></p>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const perPageSelect = document.getElementById('per_page');
            const resultDisplay = document.getElementById('result');

            perPageSelect.addEventListener('change', function () {
                const selectedValue = this.value;
                resultDisplay.textContent = selectedValue;
                console.log('AJAX-обработка: выбрано ' + selectedValue);

            });
        });
    </script>
@endsection

