@extends('layout.mainLayout')

@push('style')
    <link href="{{ asset('assets/libs/flot/css/float-chart.css') }} " rel="stylesheet" />
@endpush

@section('main')
    <x-layout>
        <x-form name="Employ" :routeName="isset($employ) ? 'updateEmploy' : 'addEmploy'" :parentId="$departmentId" :obj="$employ ?? null" />
    </x-layout>
@endsection

@push('scripts')
@endpush
