@extends('backend.layouts.frontend')

@section('title')
{{ __($module_action) }} {{ __($module_title) }}
@endsection


@push('after-styles')
<link rel="stylesheet" href="{{ mix('modules/constant/style.css') }}">
@endpush
@section('content')
<div class="container">
    
    <div class="card">        
        <div class="card-body">
       
            
        {!! $data->description !!}

        </div>
    </div>
</div>

@endsection