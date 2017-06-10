<?php

namespace App\Http\Controllers\Cadastro;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AgendaProfissional;
use App\Models\Profissional;
use App\Http\Requests\Cadastro\AgendaProfissionalFormRequest;
use Illuminate\Support\Facades\DB;

class AgendaProfissionalController extends Controller
{

    public function __construct() {

        $this->agendaProfissional = new AgendaProfissional();

        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $select = Array(
          'p.nome AS nome_profissional', 
          'ap.id',
          'ap.data_inicial',
          'ap.hora_inicial',
          'ap.data_final',
          'ap.hora_final',
          DB::raw("CASE WHEN ap.status IS TRUE THEN 'Ativo' ELSE 'Inativo' END AS status"),
        );

        $agendas = DB::table('agenda_profissionais AS ap')
                        ->leftJoin('profissionais AS prof', 'prof.id', '=', 'ap.id_profissional')
                        ->leftJoin('pessoas AS p', 'p.id', '=', 'prof.id_pessoa')
                        ->select($select)
                        ->where('ap.status', '1')
                        ->get();


        $title = "Odonto System | Listagem de agendas";

        return view('agendaProfissional.list', compact('title', 'agendas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Odonto System | Cadastrar Agenda Profissional";

        return view('agendaProfissional.create-edit', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgendaProfissionalFormRequest $request)
    {
        $data_inicial = date_format( date_create_from_format('d/m/Y', $request->input('data_inicial') ), 'Y-m-d' );
        $data_final = date_format( date_create_from_format('d/m/Y', $request->input('data_final') ), 'Y-m-d');
        // Horas
        $hora_inicial = $request->input('hora_inicial');
        $hora_final   = $request->input('hora_final');
        
        // Verifica se a hora final é menor que a hora incial.
        if ( strtotime( $hora_inicial ) > strtotime( $hora_final ) ) {
          // Retorna a tela de cadastro para corrigir os horários.
          return redirect()->route('agenda_profissional.create')->withInput($request->input())->withErrors(['msg' => 'A hora inicial não pode ser maior que a hora final!']);
        }

        // Verifica se datas e horários já foram usados.
        $countMesmoHorario = DB::table('agenda_profissionais')
                              ->where(function ($query) use ($data_inicial, $data_final) {
                                  $query->where("data_inicial", "<=", $data_inicial)
                                        ->where("data_final", ">=", $data_inicial)
                                        ->orWhere(function ($query2) use ($data_final) {
                                          $query2->where("data_inicial", "<=", $data_final)
                                                 ->where("data_final", ">=", $data_final);
                                        });
                              })
                              ->where(function ($query) use ($hora_inicial, $hora_final) {
                                  $query->where("hora_inicial", "<=", "'$hora_inicial'")
                                        ->where("hora_final", ">=", "'$hora_final'")
                                        ->orWhere(function ($query2) use ($hora_inicial, $hora_final) {
                                          $query2->where("hora_inicial", "<=", "'$hora_final'")
                                                 ->where("hora_final", ">=", "'$hora_inicial'");
                                        });
                              })
                              ->select(DB::raw("COUNT(id) AS count"))->first();
            
        if ($countMesmoHorario->count) {
          // Retorna a tela de cadastro para corrigir os horários.
          return redirect()->route('agenda_profissional.create')->withInput($request->input())->withErrors(['msg' => 'Período de datas e horas já utilizado, informe outro!']);          
        }

        $dataPost = Array();
        $dataPost['id_profissional'] = $request->input('id_profissional');
        $dataPost['data_inicial']    = $data_inicial;
        $dataPost['data_final']      = $data_final;
        $dataPost['hora_inicial']    = $hora_inicial;
        $dataPost['hora_final']      = $hora_final;
        $dataPost['status']          = $request->input('status');
        $dataPost['duracao']         = $request->input('duracao');

        // Salva agendaprofissional
        $insert = AgendaProfissional::create($dataPost);
        
        if ( $insert ) {
            return redirect()->route('agenda_profissional.index')->with('status', 'Agenda do profissional criada com sucesso!');
        } else {
            return redirect()->route('agenda_profissional.create')->withErrors(['msg' => 'Falha ao criar agenda do profissional!']);
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
        
        // Recupera a agenda do prodissional pelo id.
        $agenda_profissional = $this->agendaProfissional->find($id);
        // Profissional.
        $profissional = Profissional::find($agenda_profissional->id_profissional);
        
        $title = "Odonto System | Editar agenda do profissional: {$profissional->pessoa->nome}";

        return view('agendaProfissional.create-edit', compact('title', 'agenda_profissional', 'profissional'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AgendaProfissionalFormRequest $request, $id)
    {
        
        $data_inicial = date_create_from_format('d/m/Y', $request->input('data_inicial'));
        $data_final = date_create_from_format('d/m/Y', $request->input('data_final'));
        // Horas
        $hora_inicial = $request->input('hora_inicial');
        $hora_final   = $request->input('hora_final');
        
        // Verifica se a hora final é menor que a hora incial.
        if ( strtotime( $hora_inicial ) > strtotime( $hora_final ) ) {
          // Retorna a tela de cadastro para corrigir os horários.
          return redirect()->route('agenda_profissional.create')->withErrors(['msg' => 'A hora inicial não pode ser maior que a hora final!']);
        }
        
        $dataPost = Array();
        $dataPost['id_profissional'] = $request->input('id_profissional');
        $dataPost['data_inicial']    = date_format( $data_inicial, 'Y-m-d' );
        $dataPost['data_final']      = date_format($data_final, 'Y-m-d');
        $dataPost['hora_inicial']    = $hora_inicial;
        $dataPost['hora_final']      = $hora_final;
        $dataPost['status']          = $request->input('status');
        $dataPost['duracao']         = $request->input('duracao');

        // Recupera o item para editar.
        $agenda_profissional = $this->agendaProfissional->find($id);

        // Altera agenda profissional.
        $update = $agenda_profissional->update($dataPost);
        
        if ( $update ) {
            return redirect()->route('agenda_profissional.index')->with('status', 'Agenda do profissional atualizada com sucesso!');
        } else {
            return redirect()->route('agenda_profissional.create')->withErrors(['msg' => 'Falha ao criar agenda do profissional!']);
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

        $agendaProfissional = AgendaProfissional::find($id);
        // Busca agendaDia vinculadas a essa agenda do profissional.
        $agendaDia = $agendaProfissional->agendaDia()->first();

        // Verifica se agenda do profissional está em algum agendaDia.
        if ( isset( $agendaDia ) ) {
            return redirect()->route('agenda_profissional.index')->withErrors(['msg'=>'Agenda do profissional não pode ser deletada, possui agendamento. Favor remover os vínculos antes de realizar esta operação.']);
        }

        $delete = $agendaProfissional->delete();

        if ( $delete ) {

            return redirect()->route('agenda_profissional.index')->with('status', 'Agenda do profissional removida com sucesso!');

        } else {
            
            return redirect()->route('agenda_profissional.index', $id)->withErrors(['msg' => 'Falha ao excluir agenda_profissional!']);

        }
    }
}
