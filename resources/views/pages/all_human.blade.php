@extends('layouts.app')

@section('content')
    <header class="content__header">
        <h1 class="text-title">Просмотр студентов</h1>
    </header>
    <div class="content__body">
        <view-student-table></view-student-table>
    </div>
@endsection
