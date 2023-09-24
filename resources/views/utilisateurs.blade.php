@extends('layout')

@section('contenu')
    <h1>Liste d'utilisateurs</h1>
    <ul>
        @foreach($liste_uti as $u)
            <li>{{$u->email}} et son mot de passe {{$u->mot_de_passe}}</li>
        @endforeach
    </ul>
@endsection