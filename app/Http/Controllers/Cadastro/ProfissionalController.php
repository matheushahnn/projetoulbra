<?php

namespace App\Http\Controllers\Cadastro;

use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Models\Profissional;
use App\Http\Controllers\Controller;
use App\Http\Requests\Cadastro\ProfissionalFormRequest;
use Illuminate\Support\Facades\DB;

class ProfissionalController extends Controller
{


    public function __construct(Pessoa $pessoa) {

        $this->pessoa = new Pessoa;
        $this->profissional = new Profissional();

        $this->middleware('auth');

    }

    public function search(Request $request) {

        $data = $request->all();
        $validator = NULL;

        if ( empty( $data['busca'] ) ) {
            
            return $this->index();

        } else {

            if ($data['tipo_busca'] != 'id') {

                $profissionais = DB::table('profissionais AS prof')
    						            ->leftJoin('pessoas', 'prof.id_pessoa', '=', 'pessoas.id')
    						            ->select('pessoas.nome AS nome', 'prof.codigo_cadastro', 'prof.id')
    						            ->where($data['tipo_busca'], 'ilike', $data['busca'] . '%')
    						            ->orderby('nome')
    						            ->get();

            } else if ($data['tipo_busca'] == 'id') {

                $validator = $this->validate($request, [
                    'busca' => 'numeric',
                ]);

                $profissionais =  DB::table('profissionais AS prof')
							            ->leftJoin('pessoas', 'prof.id_pessoa', '=', 'pessoas.id')
							            ->select('pessoas.nome AS nome', 'prof.codigo_cadastro', 'prof.id')
							            ->where('prof.'.$data['tipo_busca'], '=', $data['busca'])
							            ->orderby('nome')
							            ->get();

            }

            $title = "Listagem de profissionais";

            return view('profissional.list', compact('profissionais', 'title'))->withErrors($validator);; 

        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $profissionais =  DB::table('profissionais AS prof')
        			            ->leftJoin('pessoas', 'prof.id_pessoa', '=', 'pessoas.id')
        			            ->select('pessoas.nome AS nome', 'prof.codigo_cadastro', 'prof.id')
        			            ->get();

        $title = "Listagem de profissionais";

        return view('profissional.list', compact('title', 'profissionais'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Cadastrar Profissional";

        return view('profissional.create-edit', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProfissionalFormRequest $request)
    {
		$dataPessoa = Array();
		$dataProfissional = Array();

        // Pega os dados para preencher a tabela pessoas.
        $dataPessoa['nome'] = $request->nome;
        $dataPessoa['dtnasc'] = $request->dtnasc;
        // Início commit
        DB::beginTransaction();

      	// Salva pessoa
      	$insert = $this->pessoa->create($dataPessoa);
      	
      	$dataProfissional['id_pessoa'] = $insert->id;
      	$dataProfissional['codigo_cadastro'] = $request->codigo_cadastro;

      	$this->profissional->create($dataProfissional);

        DB::commit();

        if ( $insert ) {
            return redirect()->route('profissional.index');
        } else {
            return redirect()->route('profissional.create');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Recupera procedimento pelo id.
        $profissional = DB::table('profissionais AS prof')
			            ->leftJoin('pessoas', 'prof.id_pessoa', '=', 'pessoas.id')
			            ->select('pessoas.nome AS nome', 'pessoas.dtnasc', 'prof.codigo_cadastro', 'prof.id')
			            ->where('prof.id', '=', $id)
			            ->limit(1)
			            ->first();        

        $title = "Editar profissional: {$profissional->nome}";

        return view('profissional.create-edit', compact('title', 'profissional'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfissionalFormRequest $request, $id)
    {
        // Recupera todos os dados do formulário.
        $dataForm = $request->all();

        // Recupera o item para editar.
        $profissional = $this->profissional->find($id);

        $pessoa = $this->pessoa->find($profissional->id_pessoa);

        // Altera o item.
        $updatePessoa = $pessoa->update($dataForm);
        $updateProfissional = $profissional->update($dataForm);

        // Verifica se editou.
        if ( $updateProfissional && $updatePessoa ) {
            return redirect()->route('profissional.index');
        } else {
            return redirect()->route('profissional.edit', $id)->with('Falha ao editar.');
        }
    }

    public function buscaAutocomplete(Request $request) {

        $dataForm = $request->all();
        
        $profissionais = DB::table('profissionais AS prof')
            ->leftJoin('pessoas', 'prof.id_pessoa', '=', 'pessoas.id')
            ->select('pessoas.nome AS nome', 'pessoas.dtnasc', 'prof.codigo_cadastro', 'prof.id')
            ->where('pessoas.nome', 'ilike', "%{$dataForm['term']}%")
            ->get();    

        // Verifica se trouxe algum registro.
        if (!empty($profissionais)) {

            return Response()->json($profissionais);

        } else {

            return NULL;

        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
