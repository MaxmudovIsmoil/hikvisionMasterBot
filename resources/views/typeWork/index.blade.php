@extends('layout.app')

@section('content')
    <div class="cards">
        <div class="card">
            <div class="card-content">
                <div class="number">type of word</div>
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
@endsection
