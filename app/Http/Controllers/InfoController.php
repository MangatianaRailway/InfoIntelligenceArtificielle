<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InfoController extends Controller
{
    public function insertForm()
    {
        return view('addInfo');
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
        return redirect('addInfo')->with('status', "Insert successfully");
    }

    public function home()
    {
        $infos = DB::select('select * from info join utilisateur on utilisateur.idutilisateur=info.idutilisateur where statut = 1 order by dateajout desc');
        return view('home', ['infos' => $infos]);
    }

    public function showToUpdate($id)
    {
        $infos = DB::select('select * from info join utilisateur on utilisateur.idutilisateur=info.idutilisateur where idinfo = ?', [$id]);
        return view('updateInfo', ['infos' => $infos]);
    }

    public function listeNonConfirm()
    {
        $infos = DB::select('select * from info join utilisateur on utilisateur.idutilisateur=info.idutilisateur where statut = 0 order by dateajout desc');
        return view('confirmInfo', ['infos' => $infos]);
    }

    public function publier($id) {
        DB::update('update info set statut = 1 where idinfo = ?',[$id]);
        $infos = DB::select('select * from info join utilisateur on utilisateur.idutilisateur=info.idutilisateur where statut=1 order by dateajout desc');
        return view('home', ['infos' => $infos]);
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
        return view("resultSearch",['infos' => $infos]);
        //return $select;
    }
}
