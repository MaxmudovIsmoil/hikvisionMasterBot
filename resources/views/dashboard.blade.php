@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/order.css') }}"/>
@stop
@section('content')
    <div class="cards">
        <div class="card-div">
            <div class="card-content">
                <div class="number">1217</div>
                <div class="card-name">Hizmatlar</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-user-graduate"></i>
            </div>
        </div>
        <div class="card-div">
            <div class="card-content">
                <div class="number">42</div>
                <div class="card-name">Tugallangan ishlar</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
        </div>
        <div class="card-div">
            <div class="card-content">
                <div class="number">68</div>
                <div class="card-name">Hodimlar</div>
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
        <h2>Ishlar (past 12 months)</h2>
        <div>
            <canvas id="lineChart"></canvas>
        </div>
    </div>
    <div class="chart doughnut-chart">
        <h2>Ustalar</h2>
        <div>
            <canvas id="doughnut"></canvas>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset('assets/js/chart.min.js') }}"></script>
    <script src="{{ asset('assets/js/chart1.js') }}"></script>
    <script src="{{ asset('assets/js/chart2.js') }}"></script>
@stop
