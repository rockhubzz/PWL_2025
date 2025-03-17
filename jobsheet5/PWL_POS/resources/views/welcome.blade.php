@extends('layout.app')

{{-- Customize layout section --}}

@section('subtitle', 'Welcome')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Welcome to the Laravel AdminLTE Starter Kit')

{{-- Content body : main page content --}}

@section ('content_body')
    <p>Welcome to this beautiful admin panel</p>
@stop

{{-- Push the extra CSS --}}
@push('css')
{{-- Add here extra stylesheet --}}
{{-- <link rel-"stylesheet" href-"/css/admin_custom.css"> --}}
@endpush

{{-- Push the extra JS --}}
@push('js')
    <script>
        console.log("Hi, im using the Laravel AdminLTE package!");
    </script>
@endpush