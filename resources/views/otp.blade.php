@extends('layout.mainLayout')

@section('main')
    <div class="main-wrapper">
        <div class="preloader">
            <div class="lds-ripple">
                <div class="lds-pos"></div>
                <div class="lds-pos"></div>
            </div>
        </div>
        <div
            class="
          auth-wrapper
          d-flex
          no-block
          justify-content-center
          align-items-center
          bg-dark
        ">
            <div class="auth-box bg-dark border-top border-secondary">
                <div id="recoverform">

                    <div class="row my-5">
                        <!-- Form -->
                        <form class="col-12" action="{{ route('confirmOtp') }}" method="POST">
                            @csrf
                            <!-- email -->
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-danger text-white h-100" id="basic-addon1"><i
                                            class="mdi mdi-email fs-4"></i></span>
                                </div>
                                <input type="text" class="form-control form-control-lg" placeholder="Enter Otp"
                                    aria-label="Username" name="otp" aria-describedby="basic-addon1" />
                            </div>
                            <div>
                                @if (session('error'))
                                    <p style="color:red;">{{ session('error') }}</p>
                                @endif
                            </div>
                            <!-- pwd -->
                            <div class="row mt-3 pt-3 border-top border-secondary">
                                <div class="col-12">
                                    <a class="btn btn-success text-white" href="{{ route('loginPage') }}" id="to-login"
                                        name="action">Back
                                        To Login</a>
                                    <button class="btn btn-info float-end" type="submit" name="action">
                                        Enter
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
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
