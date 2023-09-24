<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Article;
use App\Models\Categories;
class ArticleController extends Controller
{
    public function displayItems(){
        $article = Article::all();
        $categories = Categories::all();
        return view('list_items', ['articles'=>$article, 'categories'=>$categories]);
    }

    public function addItem(Request $request){
        $a = Article::create([
            'nom_article' => $request->name,
            'description' => $request->description,
            'prix_unitaire' => $request->price,
            'stock' => $request->stock,
            'id_cat' => $request->category
        ]);
        
        //verifier si l'utilisateur a envoye une image pour l'article
        if($request->hasFile('image')){
            $file = $request->file('image');
            //renommer le fichier
            $file_name = $a->id.".".$file->extension();
            //deplacer l'image vers la repertoire images
            $file->move('images', $file_name);
            //modifier le nom de l'image dans la table article
            $a->photo = $file_name;
            $a->save();
        }
        
        $categories = Categories::all();
        $ligne = "<tr id='rowItem_$a->id'>
                    <td>
                        <div class='form-group'>
                            <input id='txtName_$a->id' type='text' class='form-control' 
                                name='txtName_$a->id' value='$a->nom_article'>
                        </div>
                    </td>
                    <td>
                        <div class='form-group'>
                            <input id='txtDescription_$a->id' type='text' class='form-control' 
                                name='txtDescription_$a->id' value='$a->description'>
                        </div>
                    </td>
                    <td>
                        <div class='form-group'>
                            <input id='txtPrix_$a->id' type='number' class='form-control' 
                                name='txtPrix_$a->id' value='$a->prix_unitaire'>
                        </div>
                    </td>
                    <td>
                        <div class='form-group'>
                            <input id='txtStock_$a->id' type='number' class='form-control' 
                                name='txtStock_$a->id' value='$a->stock'>
                        </div>
                    </td>
                    <td align='center'>
                        <div class='form-group'>";
                    
                    if($a->photo != null and file_exists(public_path()."/images/$a->photo"))
                        $ligne.= "<img src='".asset('/images/'.$a->photo)."' alt='' width='100'>";
                    else
                        $ligne .= "<input id='txtPhoto_$a->id' type='file' class='form-control' 
                                name='txtPhoto_$a->id' value=''>";
                    $ligne .="</div>
                    </td>
                    <td>
                        <div class='form-group'>
                            <select name='cmbCategorie_$a->id' id='cmbCategorie_$a->id' class='form-control'>";
                    foreach($categories as $c){
                        $ligne .= "<option value='$c->id'";
                        if($a->id_cat == $c->id)
                            $ligne .= " selected";
                        $ligne.= ">$c->nom_cat</option>";
                    }
                    $ligne .= "</select>
                </div>
                </td>
                <td>
                    <button type='button' class='btn btn-primary' id='btnUpdate_$a->id'
                        onclick='updateItem($a->id)'>Update</button>
                    <button type='button' class='btn btn-primary' id='btnDelete_$a->id'
                        onclick='deleteItem($a->id)'>Delete</button>
                </td>
            </tr>";
                    
                    //$ligne="<tr><td>test</td></tr>";
        return response()->json([
            'success' => 'Item has been added',
            'row' => $ligne ]);
    }

    public function updateItem(Request $request){
        $a = Article::find($request->id);
        $a->nom_article = $request->name;
        $a->description = $request->description;
        $a->prix_unitaire = $request->price;
        $a->stock = $request->stock;
        $a->id_cat= $request->category;
        
        $flag = false;
        if($request->hasFile('image')){
            $file = $request->file('image');
            //renommer le fichier
            $file_name = $a->id.".".$file->extension();
            //deplacer l'image vers la repertoire images
            $file->move('images', $file_name);
            //modifier le nom de l'image dans la table article
            $a->photo = $file_name;
            $flag = true;
        }
        $a->save();

        return Response()->json([
            'success' => 'Item has been updated',
            'image' => $flag
        ]);
    }

    public function deleteItem(Request $req){
        $c = Article::find($req->id);
        $c->delete();
        return response()->json(['success'=>'Item has been deleted']);
    }

    public function displayItemsByCategory(Request $request){
        $cat = Categories::find($request->id);
        if($cat == null)
            $nom = "Category does not exist";
        else{
            $nom = $cat->nom_cat;
        }
        
        $items = Article::where('id_cat', '=' , $request->id)->get();
        return view('itemsByCategory', ['items' => $items, 'cat_name'=>$nom]);
    }
}
