<?php

namespace App\Http\Controllers;

use App\Dependente;
use App\Pessoa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PessoasController extends Controller
{

    public function redirectPessoas(){
        return redirect('/pessoas');
    }

    public function index(){
        $pessoas = Pessoa::all();
        return view('pessoas.index')->with(['pessoas' => $pessoas]);
    }

    public function getCadastrar(){
        return view('pessoas.cadastrar');
    }

    public function getRemover($arrayPessoasId){
        foreach (json_decode($arrayPessoasId) as $item){
           $pessoa = Pessoa::find($item);
           if($pessoa){
             Dependente::where('pessoa_id', $pessoa->id)->delete();
             if($pessoa->url_foto){
                 File::delete('img/pessoas/'.$pessoa->id.'.jpg');
             }
             $pessoa->delete();
           }
        }
        return redirect()->back();
    }

    public function postCadastrar(Request $request){
        $request->validate([
            'nome' => 'required|max:200',
            'data_de_nascimento' => 'required|date|date_format:Y-m-d',
            'email' => 'required|max:100|email',
            'foto' => 'nullable|max:200'
        ]);

        if($request->hasFile('foto')){
            if($request->file('foto')->getClientOriginalExtension() != 'jpg'){
                return redirect()->back()->withErrors(['foto' => 'Formato inválido'])->withInput();
            }
        }

        $pessoa = new Pessoa;
        $pessoa->nome = $request->nome;
        $pessoa->data_de_nascimento = $request->data_de_nascimento;
        $pessoa->email = $request->email;
        $pessoa->status = 1;
        $pessoa->save();

        if($request->hasFile('foto')){
            $image      = $request->file('foto');
            $fileName   = $pessoa->id . '.' . $image->getClientOriginalExtension();
            $request->foto->move(public_path('img/pessoas/'), $fileName);
            $path = '/img/pessoas/'.$fileName;
            $pessoa->url_foto = url($path);
            $pessoa->save();
        }

        return redirect('/pessoas');

    }

    public function getAtivarPessoa($idPessoa){
        $pessoa = Pessoa::find($idPessoa);
        if($pessoa){
            $pessoa->status = 1;
            $pessoa->save();
        }
        return redirect('/pessoas');
    }

    public function getDesativarPessoa($idPessoa){
        $pessoa = Pessoa::find($idPessoa);
        if($pessoa){
            $pessoa->status = 0;
            $pessoa->save();
        }
        return redirect('/pessoas');
    }

    public function getAdicionarDependente($idPessoa){
        $pessoa = Pessoa::find($idPessoa);
        if($pessoa){
            return view('dependentes.index')->with(['pessoa' => $pessoa]);
        }
        return redirect('/pessoas');
    }

    public function getEditar($idPessoa){
        $pessoa = Pessoa::find($idPessoa);
        if($pessoa){
            return view('pessoas.editar')->with(['pessoa' => $pessoa]);
        }
        return redirect('/pessoas');
    }


    public function postEditar(Request $request){
        $request->validate([
            'nome' => 'required|max:200',
            'data_de_nascimento' => 'required|date|date_format:Y-m-d',
            'email' => 'required|max:100|email',
            'foto' => 'nullable|max:200'
        ]);

        $pessoa = Pessoa::find($request->id);
        if($pessoa) {
            if($request->hasFile('foto')){
                if($request->file('foto')->getClientOriginalExtension() != 'jpg'){
                    return redirect()->back()->withErrors(['foto' => 'Formato inválido'])->withInput();
                }
            }
            if($request->hasFile('foto')){
                $image      = $request->file('foto');
                $fileName   = $pessoa->id . '.' . $image->getClientOriginalExtension();
                $request->foto->move(public_path('img/pessoas/'), $fileName);
                $path = '/img/pessoas/'.$fileName;
                $pessoa->url_foto = url($path);
            }
            $pessoa->nome = $request->nome;
            $pessoa->data_de_nascimento = $request->data_de_nascimento;
            $pessoa->email = $request->email;
            $pessoa->save();
        }


        return redirect('/pessoas');
    }
}
