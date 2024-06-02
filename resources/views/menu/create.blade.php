@extends('layouts.master')

@section('custom-header-scripts')
    <link href="{{ asset('vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

{{-- Content --}}
@section('content')
    <div class="container-fluid">

        @component('components.breadcrumb')
            @slot('title') @lang('common.create') @endslot
            @slot('breadcrumb1') @lang('menu.menu') @endslot
            @slot('breadcrumb1_link') {{ route('menu.index') }} @endslot
            @slot('breadcrumb2') @lang('common.dashboard') @endslot
            @slot('breadcrumb2_link') {{ route('dashboard') }} @endslot
            @slot('action_button1') @lang('common.back') @endslot
            @slot('action_button1_link') {!! route('menu.index') !!} @endslot
            @slot('action_button1_class') btn-dark @endslot
        @endcomponent

        @if($errors->any())
            @include('components.error_messages')
        @endif

        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['url' => route('menu.store'), 'method' => 'post','class' => 'custom-validation']) }}
                            @include('menu.form')
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


