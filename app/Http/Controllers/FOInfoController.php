<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FOInfoController extends Controller
{
    public function insertForm()
    {
        return view('addInfoFO');
    }

    public function insert(Request $request)
    {
        $photo=$request->file('photo');
        $filename=time().'.'.$photo->getClientOriginalName();
        $photo->move(public_path('imgs'),$filename);
        $idutilisateur =  session()->get('idutilisateur');
        $titre = $request->input('titre');
        $contenu = $request->input('contenu');
        $data = array('titre' => $titre, 'contenu' => $contenu,'idutilisateur' => $idutilisateur,'photo' => $filename);
        DB::table('info')->insert($data);
        return redirect('addInfoFO')->with('status', "Insert successfully");
    }

    public function home()
    {
        $infos = DB::select('select * from info join utilisateur on utilisateur.idutilisateur=info.idutilisateur where statut = 1 order by dateajout desc');
        return view('homeFO', ['infos' => $infos]);
    }

    public function search(Request $request)
    {
        $search = $request->input('search');
        $searchAfterSplit = explode(" ", $search);
        $select = "select * from info join utilisateur on utilisateur.idutilisateur=info.idutilisateur where";
        foreach($searchAfterSplit as $term)
        {
            $select = $select."( titre like '%$term%' or contenu like '%$term%' or nom like '%$term%') and ";
        }
        $select=$select." statut=1 order by dateajout desc";
        $infos = DB::select($select);
        return view("resultSearchFO",['infos' => $infos]);
        //return $select;
    }
}
