@extends('layouts.app')

@section('content')
    <h1 class="mb-5">@lang('views.status.index.create')</h1>
    {{ Form::model($status, ['route' => 'task_statuses.store', 'class' => 'w-50']) }}
    @include('task_statuses.form')
    {{ Form::submit(__('views.buttons.create'), ['class' => 'btn btn-primary mt-2']) }}
    {{ Form::close() }}
@endsection
