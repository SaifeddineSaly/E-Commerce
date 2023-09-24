<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;

class UtilisateurController extends Controller
{
    public function afficherFormulaire(){
        return view('register');
    }

    public function traiterFormulaire(){
        request()->validate([
            'txtEmail' => ['required', 'email'],
            'txtPwd' =>['required', 'confirmed', 'min:8'],
            'txtPwd_confirmation' =>['required'],
        ]);
        
        $u = new Utilisateur();
        $u->email = request('txtEmail');
        $u->mot_de_passe = bcrypt(request('txtPwd'));
        $u->save();
        return 'Vous avez inscrire en utilisant email ' . request('txtEmail');
    }
}
