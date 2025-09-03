@extends('layout.mainLayout')

@push('style')
    <link href="{{ asset('assets/libs/flot/css/float-chart.css') }} " rel="stylesheet" />
@endpush

@section('main')
    <x-layout>
        @isset($department)
            <x-form routeName="updateDepartment" :obj="$department" />
        @else
            <x-form routeName="addDepartment" />
        @endisset
    </x-layout>
@endsection

@push('scripts')
@endpush
