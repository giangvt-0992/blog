@extends('master')
@section('name', 'Register')

@section('content')
    <div class="container col-md-6 col-md-offset-3">
        <div class="card mt-5">
            <div class="card-header ">
                <h5 class="float-left">Login with your account</h5>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                <form method="post" action="{{url('/users/login')}}">
                    @foreach ($errors->all() as $error)
                        <p class="alert alert-danger">{{ $error }}</p>
                    @endforeach

                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="email" class="col-lg-12 control-label">Email</label>
                        <div class="col-lg-12">
                            <input type="email" class="form-control" id="email" placeholder="Email" name="email" value="{{ old('email') }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password" class="col-lg-12 control-label">Password</label>
                        <div class="col-lg-12">
                            <input type="password" class="form-control"  name="password">
                        </div>
                    </div>
                    <div class="form-group">
                        {{-- <label for="password" class="col-lg-12 control-label">Password</label> --}}
                        <input type="checkbox" type="checkbox" name="remember_me"> remember me
                    </div>
                    <div class="form-group">
                        <div class="col-lg-10 col-lg-offset-2">
                            <button type="reset" class="btn btn-default">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection