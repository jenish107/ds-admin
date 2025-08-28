@extends('layout.mainLayout')

@section('main')
    <x-otp-page routeName="newPasswordForm" />
@endsection

@push('scripts')
    <script>
        $(".preloader").fadeOut();
        $("#to-recover").on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
        $("#to-login").click(function() {
            $("#recoverform").hide();
            $("#loginform").fadeIn();
        });
    </script>
@endpush
