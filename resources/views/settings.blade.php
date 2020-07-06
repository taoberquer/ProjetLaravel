@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Vos paramètres') }}
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('updateSettings') }}" method="POST" autocomplete="off">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter name" value="{{ old('name', $user->name) }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value="{{ old('email', $user->email) }}">
                        </div>
                        <div class="form-group">
                            <label for="current_password">Old password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" placeholder="Old password">
                        </div>
                        <div class="form-group">
                            <label for="password">New password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="New password">
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm new password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirm new password">
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
