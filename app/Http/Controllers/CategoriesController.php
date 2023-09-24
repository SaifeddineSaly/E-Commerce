<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Categories;

class CategoriesController extends Controller
{
    public function displayCategories(){
        $cats = Categories::all();
        return view('liste_categories', ['categories' => $cats]);
    }

    public function addCategory(Request $request){
        $c = Categories::create(['nom_cat' => $request->name]);
        return response()->json([
            'success' => 'Category has been added',
            'row' => "<tr id='rowCat_$c->id'>
                        <td>
                            <div class='form-group'>
                                <input id='txtName_$c->id' type='text' class='form-control' 
                                    name='txtName_$c->id' value='$c->nom_cat'>
                            </div>
                        </td>
                        <td>
                            <button type='button' class='btn btn-primary' id='btnUpdate_$c->id'
                                onclick='updateCategory($c->id)'>Update</button>
                            <button type='button' class='btn btn-primary' id='btnDelete_$c->id'
                                onclick='deleteCategory($c->id)'>Delete</button>
                        </td>
                    </tr>"
        ]);
    }

    public function updateCategory(Request $request){
        $c = Categories::find($request->id);
        $c->nom_cat = $request->name;
        $c->save();
        return response()->json(['success'=>'Category has been updated']);
    }

    public function deleteCategory(Request $req){
        $c = Categories::find($req->id);
        $c->delete();
        return response()->json(['success'=>'Category has been deleted']);
    }

    public function getCategories(){
        $cats = Categories::all();
        return view('home', ['categories' => $cats]);
    }

}
