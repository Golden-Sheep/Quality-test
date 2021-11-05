<?php

namespace App\Http\Controllers;

use App\Dependente;
use Illuminate\Http\Request;

class DependentesController extends Controller
{
    public function postCadastrar(Request $request){
        $request->validate([
            'nome' => 'required|max:100',
            'data_de_nascimento' => 'required|date|date_format:Y-m-d',
        ]);

        $dependente = new Dependente;
        $dependente->nome = $request->nome;
        $dependente->data_de_nascimento = $request->data_de_nascimento;
        $dependente->pessoa_id = $request->pessoa_id;
        $dependente->save();

        return redirect('/pessoas/adicionar/dependentes/'.$request->pessoa_id);
    }

    public function getRemoverDependente($idDependente){
        $dependente = Dependente::find($idDependente);
        if($dependente){
            $dependente->delete();
        }
        return redirect()->back();
    }
}
