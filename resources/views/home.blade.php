@extends('layouts.app')
@section('style')
    <link rel="stylesheet" href="{{ asset('assets/css/order.css') }}"/>
@stop
@section('content')
    <div class="cards">
        <div class="card">
            <div class="card-content">
                <div class="number">1217</div>
                <div class="card-name">Students</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-user-graduate"></i>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <div class="number">42</div>
                <div class="card-name">Teachers</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-chalkboard-teacher"></i>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <div class="number">68</div>
                <div class="card-name">Employees</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="card">
            <div class="card-content">
                <div class="number">$4500</div>
                <div class="card-name">Earnings</div>
            </div>
            <div class="icon-box">
                <i class="fas fa-dollar-sign"></i>
            </div>
        </div>
    </div>
    <div class="charts">
    <div class="chart">
        <h2>Earnings (past 12 months)</h2>
        <div>
            <canvas id="lineChart"></canvas>
        </div>
    </div>
    <div class="chart doughnut-chart">
        <h2>Employees</h2>
        <div>
            <canvas id="doughnut"></canvas>
        </div>
    </div>
</div>
@endsection
