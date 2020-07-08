@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="{{ route('shared.index') }}">{{ __('Fichiers partagés') }}</a>
                    @foreach($breadcrumbs as $key => $value)
                        >
                        @if ($key == $folderID)
                            <strong>{{ $value }}</strong>
                        @else
                            <a href="{{ route('shared.index', $key) }}"> {{ $value }}</a>
                        @endif
                    @endforeach
                </div>

                @if (null !== $folderID)
                <div class="col-12">
                    <form action="{{ route('shared.storeFolder', $folderID) }}" method="post" class="row">
                        @csrf
                        <input class="form-control col" type="text" name="folder_name" placeholder="{{ __('Nom du dossier') }}" required>
                        <button type="submit" class="btn btn-success col-auto">{{ __('Créer le dossier') }}</button>
                    </form>
                    <form action="{{ route('shared.storeFiles', $folderID) }}" method="post" class="row" enctype="multipart/form-data">
                        @csrf
                        <div class="custom-file col">
                            <input type="file" name="file" class="custom-file-input">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                        <button type="submit" class="btn btn-success col-auto">{{ __('Téléverser le fichier') }}</button>
                    </form>
                </div>
                @endif

                <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">{{ __('Type') }}</th>
                                <th scope="col">{{ __('Nom') }}</th>
                                <th scope="col">{{ __('Propriétaire') }}</th>
                                <th scope="col">{{ __('Taille') }}</th>
                                <th scope="col">{{ __('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($files  as $file)
                                <tr>
                                    <form method="post" action="{{ route('shared.update', $file->id) }}">
                                        @csrf
                                        @method('put')
                                        <th scope="row">{{ ucwords($file->type) }}</th>
                                        <td>
                                            <input type="text" class="form-control" value="{{ old('name', $file->name) }}" name="file_name">
                                        </td>
                                        <td>{{ $file->user->email }}</td>
                                        <td>
                                            {{ BytesToHuman::convert($file->size) }}
                                        </td>
                                        <td>
                                            @if ($file->type === 'folder')
                                                <a href="{{ route('shared.index', $file->id) }}" class="btn btn-primary">{{ __('Ouvrir') }}</a>
                                            @endif

                                            <button type="submit" class="btn btn-info">{{ __('Modifier') }}</button>

                                            @if ($file->type === 'file')
                                                    <a href="{{ route('shared.download', $file->id) }}" class="btn btn-secondary">{{ __('Télécharger') }}</a>
                                            @endif

                                                <a class="btn btn-danger" href="{{ route('shared.destroy', $file->id) }}"
                                                   onclick="event.preventDefault();
                                                     document.getElementById('destroy-form-{{ $file->id }}').submit();">
                                                    {{ __('Supprimer') }}
                                                </a>

                                        </td>
                                    </form>
                                    <form action="{{ route('shared.destroy', $file->id) }}" id="destroy-form-{{ $file->id }}" method="post"  style="display: none;">
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
