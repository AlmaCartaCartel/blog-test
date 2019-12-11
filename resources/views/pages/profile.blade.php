@extends('layout')

@section('content')
    <!--main content start-->
    <div class="main-content">
        <div class="container">
            <div class="row">
                <div class="col-md-8">

                    <div class="leave-comment mr0"><!--leave comment-->

                        <h3 class="text-uppercase">My profile</h3>
                        @if(session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        @include('admin.errors')

                        @if(Auth::user()->is_admin === 1)
                            <a href="{{ route('admin.dashboard') }}" class="btn send-btn">ADMIN DASHBOARD</a>
                        @endif
                        <br>
                        <img src="{{ $user -> getImage() }}" alt="" class="profile-image">

                        {{ Form::open(['route' => 'profile.update', 'method'=> 'put','files' => true]) }}

                        <span class="form-horizontal contact-form">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" id="name" name="name"
                                           placeholder="Name" value="{{ $user -> name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" id="email" name="email"
                                           placeholder="Email" value="{{ $user -> email }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="password" class="form-control" id="password" name="password"
                                           placeholder="password">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="file" class="form-control" id="image" name="avatar">
                                </div>
                            </div>

                            <button type="submit" class="btn send-btn">Update</button>
                        </span>
                        {{ Form::close() }}
                    </div><!--end leave comment-->
                </div>
               @include('pages._sidebar')
            </div>
        </div>
    </div>
    <!-- end main content-->
@endsection
