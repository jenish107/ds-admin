@extends('layout.mainLayout')

@push('style')
    <link href="{{ asset('assets/libs/flot/css/float-chart.css') }} " rel="stylesheet" />
@endpush

@section('main')
    <x-layout>
        @isset($family)
            <x-form routeName="updateFamily" :parentId="$employId" :obj="$family" />
        @else
            <x-form routeName="addFamily" :parentId="$employId" />
        @endisset
    </x-layout>
@endsection

@push('scripts')
@endpush
