@extends('layout.mainLayout')

@push('style')
    <link href="{{ asset('assets/libs/flot/css/float-chart.css') }} " rel="stylesheet" />
@endpush

@section('main')
    <x-layout>
        <x-form name="Companies" :routeName="isset($companies) ? 'updateCompanies' : 'addCompanies'" :obj="$companies ?? null" />
    </x-layout>
@endsection

@push('scripts')
@endpush
