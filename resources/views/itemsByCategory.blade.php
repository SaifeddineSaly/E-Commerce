@extends('layout')

@section('contenu')
    <h2>{{$cat_name}}</h2>

    <div class="row">
        @foreach($items as $i)
            <div class="col-sm-12 col-md-4 col-lg-3">     
                <div class="card" style="width:250px; height: 300px; overflow:auto; 
                    float:left; margin:5px; border:1px solid lightblue;">
                    <img class="card-img-top" src="{{asset('/images/'.$i->photo)}}" 
                            alt="Card image" style="height:150px">
                    <div class="card-body">
                        <h4 class="card-title">{{$i->nom_article}}</h4>
                        <p class="card-text">Prix: {{$i->prix_unitaire}}</p>
                        <p class="card-text">Stock: {{$i->stock}}</p>
                        <a href="/addToCart/{{$i->id}}" class="btn btn-primary">Add to Cart</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection