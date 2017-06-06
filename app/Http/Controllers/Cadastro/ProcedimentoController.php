<?php

namespace App\Http\Controllers\Cadastro;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Procedimento;
use App\Http\Requests\Cadastro\ProcedimentoFormRequest;
use Illuminate\Support\Facades\DB;

class ProcedimentoController extends Controller
{

    public function __construct()
    {
        
        $this->procedimento = new Procedimento();

        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $procedimentos = $this->procedimento->all();


        $title = 'Listagem de procedimentos';

        return view('procedimento.list', compact('procedimentos', 'title'));
    }

    public function search(Request $request) {

        $data = $request->all();
        $validator = NULL;
        $title = 'Listagem de procedimentos';

        if ( empty( $data['descricao_busca'] ) ) {
            
            return $this->index();

        } else {

            if ($data['tipo_busca'] != 'id') {

                $procedimentos = DB::table('procedimentos')->where($data['tipo_busca'], 'ilike', $data['descricao_busca'] . '%')->orderby('descricao')->get();

            } else if ($data['tipo_busca'] == 'id') {

                $validator = $this->validate($request, [
                    'descricao_busca' => 'numeric',
                ]);

                $procedimentos = DB::table('procedimentos')->where($data['tipo_busca'], $data['descricao_busca'])->orderby('descricao')->get();

            }

            return view('procedimento.list', compact('procedimentos', 'title'))->withErrors($validator);; 

        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $title = "Cadastrar Procedimento";

        return view('procedimento.create-edit', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProcedimentoFormRequest $request)
    {

        // Pega todos os dados.
        $dataForm = $request->all();

        $insert = $this->procedimento->create($dataForm);

        if ( $insert ) {
            return redirect()->route('procedimento.index')->with('status', 'Procedimento criado com sucesso!');
        } else {
            return redirect()->route('procedimento.create')->withErrors(['msg' => 'Falha ao remover procedimento!']);
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
        $procedimento = $this->procedimento->find($id);

        $title = "Editar Procedimento: {$procedimento->descricao}";

        return view('procedimento.create-edit', compact('title', 'procedimento'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProcedimentoFormRequest $request, $id)
    {
        // Recupera todos os dados do formulário.
        $dataForm = $request->all();

        // Recupera o item para editar.
        $procedimento = $this->procedimento->find($id);

        // Altera o item.
        $update = $procedimento->update($dataForm);

        // Verifica se editou.
        if ( $update ) {
            return redirect()->route('procedimento.index')->with('status', 'Procedimento editado com sucesso!');
        } else {
            return redirect()->route('procedimento.edit', $id)->withErrors(['msg' => 'Falha ao editar procedimento!']);
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
        // Verifica se procedimento está em algum atendimento.
        $procedimento = Procedimento::find($id);

        $procedimentoAtendimento = $procedimento->procedimentoAtendimento()->first();

        if ( isset( $procedimentoAtendimento ) ) {
            return redirect()->route('procedimento.index')->withErrors(['msg'=>'Procedimento não pode ser deletado, está inserido em um atendimento. Favor remover os vínculos antes de realizar esta operação.']);
        }


        $delete = $procedimento->delete();

        if ( $delete ) {

            return redirect()->route('procedimento.index')->with('status', 'Procedimento removido com sucesso!');

        } else {
            
            return redirect()->route('procedimento.index', $id)->withErrors(['msg' => 'Falha ao excluir procedimento!']);

        }

    }


    public function buscaAutocomplete(Request $request) 
    {

        $desc = $request->input('term');

        $procedimentos = Procedimento::where('descricao', 'ilike', $desc.'%')->get();

        // Verifica se trouxe algum registro.
        if (!empty($procedimentos)) {

            return Response()->json($procedimentos);

        } else {

            return NULL;

        }

    }

}
