@extends('layouts.app')

@push('style')
{{--    <link rel="stylesheet" href="{{ asset('assets/css/order.css') }}"/>--}}
@endpush
@section('content')
    <div class="cards">
        <div class="card-div">
            <div class="card-content">
                <div class="number">{{ $installCount }}</div>
                <div class="card-name">O'rnatishlar</div>
            </div>
            <div class="icon-box">
{{--                <i class="fas fa-user-graduate"></i>--}}
                <i class="fas fa-project-diagram"></i>
            </div>
        </div>
        <div class="card-div">
            <div class="card-content">
                <div class="number">{{ $serviceCount }}</div>
                <div class="card-name">Servislar</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-users-cog"></i>
            </div>
        </div>
        <div class="card-div">
            <div class="card-content">
                <div class="number">{{ $groupCount }}</div>
                <div class="card-name">Guruhlar</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="card-div">
            <div class="card-content">
                <div class="number">$4500</div>
                <div class="card-name">Jami summa</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
    </div>
    <div class="charts">
    <div class="chart">
        <h2>Ishlar (oxirgi 12 oylik)</h2>
        <div>
            <canvas id="lineChart"></canvas>
        </div>
    </div>
    <div class="chart doughnut-chart">
        <h2>Gruhlar</h2>
        <div>
            <canvas id="doughnut" data-url="{{ route('getGroup') }}"></canvas>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/chart1.js') }}"></script>
    <script src="{{ asset('assets/js/chart2.js') }}"></script>
@endpush
