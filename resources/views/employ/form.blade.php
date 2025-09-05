@extends('layout.mainLayout')

@push('style')
    <link href="{{ asset('assets/libs/flot/css/float-chart.css') }} " rel="stylesheet" />
@endpush

@section('main')
    <x-layout>
        @isset($employ)
            <x-form name="Employ" routeName="updateEmploy" :parentId="$departmentId" :obj="$employ" />
        @else
            <x-form name="Employ" routeName="addEmploy" :parentId="$departmentId" />
        @endisset
    </x-layout>
@endsection

@push('scripts')
@endpush
