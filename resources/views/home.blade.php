@extends('layout')

@section('contenu')
    <p>Select a sector:</p>
    <ul>
        @foreach($categories as $c)
            <li><a href="/item/{{$c->id}}">{{$c->nom_cat}}</a></li>
        @endforeach
    </ul>
@endsection