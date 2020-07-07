@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <a href="#">{{ __('Fichiers partagés') }}</a>
                    </div>

                    <div class="col-12">
                        <form class="row" action="{{ route('file.share.store', $fileID) }}" method="post">
                            @csrf
                            <input type="email" name="email" class="form-control col" placeholder="{{ __('L\'email de l\'utilisateur') }}">
                            <div class="custom-control custom-switch">
                                <input name="write" type="checkbox" class="custom-control-input" id="customSwitch1">
                                <label class="custom-control-label" for="customSwitch1">{{ __('Autoriser l\'écriture') }}</label>
                            </div>
                            <button class="btn btn-primary col-auto">{{ __('Partager') }}</button>
                        </form>

                        <hr>

                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Email</th>
                                <th scope="col">Modification</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($shares as $share)
                                <tr>
                                    <th scope="row">{{ $share->user->email }}</th>
                                    @if ($share->write)
                                        <td>{{ __('Modification autorisé') }}</td>
                                    @else
                                        <td>{{ __('Modification non-autorisé') }}</td>
                                    @endif
                                    <td>
                                        <form method="post" action="{{ route('file.share.destroy',[ $fileID, $share->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
