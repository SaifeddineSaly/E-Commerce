<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Cart;
class CartController extends Controller
{
    public function add(Request $request){
        //verifier si l'article existe pour l'utilisateur en cours
        $c = Cart::where('id_article', '=', $request->id)->where('ref_session', '=', session()->getId())->first();
        if($c == null){
            //insertion
            Cart::create([
                'ref_session' => session()->getId(),
                'id_article' => $request->id,
                'quantite' => 1,
                'date_panier' => Date('Y-m-d')
            ]);
        }
        else{
            $c-> quantite += 1;
            $c->save();
        }
        return redirect()->to('/cart');
    }

    public function displayCart(){
        $items = Cart::where('ref_session', '=', session()->getId())
                ->join('articles', 'articles.id',  '=', 'id_article' )->get();
        return view('cart', ['items' => $items]);
    }

    public function deleteCart(Request $request){
        $c = Cart::find($request->id);
        $c->delete();
        return redirect()->to('/cart');
    }
}
