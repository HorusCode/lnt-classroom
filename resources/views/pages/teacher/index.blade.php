@extends('layouts.app')

@section('content')
    <header class="content__header">
        <h1 class="text-title">Курсы</h1>
    </header>
    <div class="content__body">
        @include('partials.empty_course')
    </div>
@endsection