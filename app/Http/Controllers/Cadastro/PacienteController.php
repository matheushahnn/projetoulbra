<?php

namespace App\Http\Controllers\Cadastro;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Paciente;
use App\Models\Pessoa;
use App\Http\Requests\Cadastro\PacienteFormRequest;
use App\Http\Requests\Cadastro\PessoaFormRequest;
use Illuminate\Support\Facades\DB;
use Validator;


class PacienteController extends Controller
{

    public function __construct() {

        $this->paciente = new Paciente();
        $this->pessoa = new Pessoa();

        $this->middleware('auth');

    }

    public function search(Request $request) 
    {

        $data = $request->all();
        $validator = NULL;

        $title = "Odonto System | Listagem de pacientes";

        if ( empty( $data['busca'] ) ) {
            
            return $this->index();

        } else {

            if ($data['tipo_busca'] != 'id') {

                $pacientes = DB::table('pacientes AS pac')
                                  ->leftJoin('pessoas', 'pac.id_pessoa', '=', 'pessoas.id')
                                  ->select('pessoas.nome AS nome','pessoas.dtnasc',  'pac.ficha_atendimento', 'pac.id')
                                  ->where($data['tipo_busca'], 'ilike', $data['busca'] . '%')
                                  ->orderby('nome')
                                  ->get();

            } else if ($data['tipo_busca'] == 'id') {

                $validator = $this->validate($request, [
                    'busca' => 'numeric',
                ]);

                $pacientes =  DB::table('pacientes AS pac')
                                  ->leftJoin('pessoas', 'pac.id_pessoa', '=', 'pessoas.id')
                                  ->select('pessoas.nome AS nome', 'pessoas.dtnasc', 'pac.ficha_atendimento', 'pac.id')
                                  ->where('pac.'.$data['tipo_busca'], '=', $data['busca'])
                                  ->orderby('nome')
                                  ->get();

            }

            return view('paciente.list', compact('title','pacientes'))->withErrors($validator);; 

        }

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pacientes = DB::table('pacientes AS pac')
                        ->leftJoin('pessoas', 'pac.id_pessoa', '=', 'pessoas.id')
                        ->select('pessoas.nome AS nome', 'pessoas.dtnasc', 'pac.ficha_atendimento', 'pac.id')
                        ->get();

        $title = "Odonto System | Listagem de pacientes";

        return view('paciente.list', compact('title', 'pacientes'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Odonto System | Cadastrar Paciente";

        return view('paciente.create-edit', compact('title', 'paciente'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PacienteFormRequest $request)
    {

        $dtnasc = date_create_from_format('d/m/Y', $request->input('dtnasc'));

        $dataPessoa = Array();
        $dataPaciente = Array();

        // Pega os dados para preencher a tabela pessoas.
        $dataPessoa['nome'] = $request->nome;
        $dataPessoa['dtnasc'] = date_format( $dtnasc, 'Y-m-d');
        // Início commit
        DB::beginTransaction();

        // Salva pessoa
        $insert = $this->pessoa->create($dataPessoa);
        
        $dataPaciente['id_pessoa'] = $insert->id;
        $dataPaciente['ficha_atendimento'] = $request->ficha_atendimento;

        $this->paciente->create($dataPaciente);

        DB::commit();

        if ( $insert ) {
            return redirect()->route('paciente.index')->with('status', 'Paciente criado com sucesso!');
        } else {
            return redirect()->route('paciente.create')->withErrors(['msg' => 'Falha ao criar paciente!']);
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
        $paciente = $this->paciente->find($id);
        $pessoa = $paciente->pessoa;
        $title = "Odonto System | Editar paciente: {$pessoa->nome}";

        return view('paciente.create-edit', compact('title', 'paciente', 'pessoa'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PacienteFormRequest $request, $id)
    {

        $dtnasc = date_create_from_format('d/m/Y', $request->input('dtnasc'));


        // Recupera todos os dados do formulário.
        $dataForm = $request->all();
        
        $dataPessoa['dtnasc'] = date_format( $dtnasc, 'Y-m-d');
        $dataPessoa['nome'] = $request->input('nome');

        // Recupera o item para editar.
        $paciente = $this->paciente->find($id);
        $pessoa   = $this->pessoa->find($paciente->id_pessoa);

        // Altera pessoa.
        $updatePessoa = $pessoa->update($dataPessoa);
        // Altera o paciente.
        $update = $paciente->update($dataForm);

        // Verifica se editou.
        if ( $update ) {
            return redirect()->route('paciente.index')->with('status', 'Paciente editado com sucesso!');
        } else {
            return redirect()->route('paciente.edit', $id)->withErrors(['msg' => 'Falha ao editar paciente!']);
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
        
        // Verifica se paciente está em algum atendimento.
        $count_atendimento = DB::table('atendimentos AS a')
                                ->leftJoin('pacientes AS pac', 'pac.id', '=', 'a.id_paciente')
                                ->where('pac.id', '=', $id)
                                ->count();

        if ( $count_atendimento > 0 ) {
            return redirect()->route('paciente.index')->withErrors(['msg'=>'Paciente não pode ser deletado, possui atendimentos/agendamentos. Favor remover os vínculos antes de realizar esta operação.']);
        }

        $paciente = Paciente::find($id);

        $delete = $paciente->delete();

        if ( $delete ) {

            return redirect()->route('paciente.index')->with('status', 'Paciente removido com sucesso!');

        } else {
            
            return redirect()->route('paciente.index', $id)->withErrors(['msg' => 'Falha ao excluir paciente!']);

        }

    }

    public function buscaAutocomplete(Request $request) {

        $dataForm = $request->all();
        
        $pacientes = DB::table('pacientes AS pac')
            ->leftJoin('pessoas', 'pac.id_pessoa', '=', 'pessoas.id')
            ->select('pessoas.nome AS nome', 'pessoas.dtnasc', 'pac.id')
            ->where('pessoas.nome', 'ilike', "%{$dataForm['term']}%")
            ->get();    

        // Verifica se trouxe algum registro.
        if (!empty($pacientes)) {

            return Response()->json($pacientes);

        } else {

            return NULL;

        }

    }
}
