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
                <div>
                    <div class="text-center pt-3 pb-3">
                        <span class="db"><img src="../assets/images/logo.png" alt="logo" /></span>
                    </div>
                    @if (session('error'))
                        <h4 class="alert alert-danger">{{ session('error') }}</h4>
                    @endif
                    <!-- Form -->
                    <form class="form-horizontal mt-3" action="{{ route('checkChangePassword') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row pb-4">
                            <div class="col-12">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-warning text-white h-100" id="basic-addon2"><i
                                                class="mdi mdi-lock fs-4"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg" placeholder="OldPassword"
                                        aria-label="Password" name="oldPassword" aria-describedby="basic-addon1" required />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-warning text-white h-100" id="basic-addon2"><i
                                                class="mdi mdi-lock fs-4"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg" placeholder="New Password"
                                        aria-label="Password" name="password" aria-describedby="basic-addon1" required />
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-info text-white h-100" id="basic-addon2"><i
                                                class="mdi mdi-lock fs-4"></i></span>
                                    </div>
                                    <input type="text" class="form-control form-control-lg"
                                        placeholder=" Confirm Password" aria-label="Password"
                                        aria-describedby="basic-addon1" name="password_confirmation" required />
                                </div>
                            </div>
                        </div>
                        <div class="row border-top border-secondary">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="pt-3 ">
                                        <a class="btn btn-info" href="{{ route('forgetPasswordPage') }}"> <i
                                                class="mdi mdi-lock fs-4 me-1"></i> forget
                                            password</a>
                                        <button class="btn btn-success float-end text-white" type="submit">
                                            conform
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@push('scripts')
    <script>
        $(".preloader").fadeOut();
    </script>
@endpush
