@extends('layout.mainLayout')

@push('style')
    <link href="{{ asset('assets/libs/flot/css/float-chart.css') }} " rel="stylesheet" />
@endpush

@section('main')
    <x-layout>
        <x-form name="Department" :routeName="isset($department) ? 'updateDepartment' : 'addDepartment'" :parentId="$companyId" :obj="$department ?? null" />
    </x-layout>
@endsection

@push('scripts')
@endpush
