@extends('layout.mainLayout')

@push('style')
    <link href="{{ asset('assets/libs/flot/css/float-chart.css') }} " rel="stylesheet" />
@endpush

@section('main')
    <x-layout>
        @isset($companies)
            <x-form name="Companies" routeName="updateCompanies" :obj="$companies" />
        @else
            <x-form name="Companies" routeName="addCompanies" />
        @endisset
    </x-layout>
@endsection

@push('scripts')
@endpush
