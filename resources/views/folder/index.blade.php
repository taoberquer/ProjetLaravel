@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    {{ __('Vos fichiers') }}

                    <button class="btn btn-primary">{{ __('Téléverser un document') }}</button>
                    <button class="btn btn-primary">{{ __('Partager') }}</button>
                </div>
                <div class="col-12">
                    <form action="{{ route('file.storeFolder', $folderID) }}" method="post" class="row">
                        @csrf
                        <input class="form-control col" type="text" name="folder_name" placeholder="{{ __('Nom du dossier') }}" required>
                        <button type="submit" class="btn btn-success col-auto">{{ __('Créer le dossier') }}</button>
                    </form>
                    <form action="{{ route('file.storeFiles') }}" method="post" class="row">
                        @csrf
                        <div class="custom-file col">
                            <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                        <button type="submit" class="btn btn-success col-auto">{{ __('Téléverser des fichiers') }}</button>
                    </form>
                </div>
                <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Handle</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($files as $file)
                                <tr>
                                    <form method="post" action="{{ route('file.update', $file->id) }}">
                                        @csrf
                                        @method('put')
                                        <th scope="row">{{ $file->type }}</th>
                                        <td>
                                            <input type="text" value="{{ old('name', $file->name) }}" name="file_name">
                                        </td>
                                        <td>{{ $file->size }}</td>
                                        <td>
                                            @if ($file->type === 'folder')
                                                <a href="{{ route('home', $file->id) }}">{{ __('Ouvrir') }}</a>
                                            @endif

                                            <button type="submit">{{ __('Modifier') }}</button>

                                            @if ($file->type === 'file')
                                                    <a href="{{ route('file.download', $file->id) }}">{{ __('Télécharger') }}</a>
                                            @endif

                                                <a class="dropdown-item" href="{{ route('file.destroy', $file->id) }}"
                                                   onclick="event.preventDefault();
                                                     document.getElementById('destroy-form-{{ $file->id }}').submit();">
                                                    {{ __('Supprimer') }}
                                                </a>

                                        </td>
                                    </form>
                                    <form action="{{ route('file.destroy', $file->id) }}" id="destroy-form-{{ $file->id }}" method="post"  style="display: none;">
                                        @csrf
                                        @method('delete')
                                    </form>
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
