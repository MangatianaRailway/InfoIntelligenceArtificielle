<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FOLoginController extends Controller
{

    function loginAdmin(Request $request)
    {
        $nom = $request->input('nom');
        $motdepasse = $request->input('motdepasse');
        $result = DB::table('utilisateur')->where('nom', $nom)->where('motdepasse', $motdepasse)->where('acces', 0)->first();

        if ($result) {
            $users = DB::select('select * from utilisateur where nom=? and motdepasse=?', [$nom,$motdepasse]);
            //$infos = DB::select('select * from info where statut = 1');
            $infos = DB::select('select * from info join utilisateur on utilisateur.idutilisateur=info.idutilisateur where statut=1 order by dateajout desc');
            $idutilisateur = 0;
            foreach($users as $user)
            {
                $idutilisateur=$user->idutilisateur;
            }
            session()->put('idutilisateur',$idutilisateur);
            return view('homeFO',compact("idutilisateur","infos"));
        } else {
            return redirect('/')->with('failed','Veuillez reessayer');
        }
    }
}
