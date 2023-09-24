@extends('layout')

@section('contenu')
    <table class="table">
        <caption>Cart Content</caption>
        <tr>
            <th>Photo</th><th>Item Name</th><th>Unit Price</th><th>Quantity</th>
            <th>Total</th><th></th>
        </tr>
        @php
            $total = 0;
        @endphp
        @foreach($items as $i)
            <tr>
                <td><img src="{{asset('/images/'.$i->photo)}}" alt="" width="150"></td>
                <td>{{$i->nom_article}}</td>
                <td>{{$i->prix_unitaire}}</td>
                <td>{{$i->quantite}}</td>
                <td>{{$i->prix_unitaire * $i->quantite}}</td>
                <td><a href="/cart/delete/{{$i->id}}">Delete</td>
            </tr>
            @php
                $total += $i->prix_unitaire * $i->quantite;
            @endphp
        @endforeach
        <tr>
            <th colspan="4">Total</th>
            <th>{{$total}}</th>
        </tr>
    </table>
@endsection