<?php

namespace App\Http\Controllers\Agendas;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AgendaDia;
use App\Models\Pessoa;
use App\Models\AgendaProfissional;
use App\Http\Requests\Agendas\AgendaDiaRequest;
use App\Http\Requests\Agendas\AgendaDiaFormRequest;

use Illuminate\Support\Facades\DB;

class AgendaDiaController extends Controller
{

    public function __construct() 
    {

        $this->agendaDia = new AgendaDia();

        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $agendas = $this->agendaDia->all();

        $title = "Agenda";

        return view('agendaDia.list', compact('title', 'agendas'));

    }

    public function iniciarAtendimento($id_agendamento) 
    {

        $agendaDia    = AgendaDia::find($id_agendamento);
        $paciente     = $agendaDia->paciente()->first();
        $profissional = $agendaDia->agendaProfissional()->first()->profissional()->first();
        $nomeProfissional = $profissional->pessoa()->first()->nome;
        $nomePaciente = $paciente->pessoa()->first()->nome;

        $data_agenda  = $agendaDia->data;
        $hora_agenda  = $agendaDia->hora;

        $title = "Iniciar atendimento da agenda";

        // Muda os status do agendamento.
        $dataAgendaDia = Array(
            'status' => 1
        );
        $agendaDia->update($dataAgendaDia);

        return view('atendimento.create-edit', compact(
                                                    'title', 'agendaDia', 'atendimento', 
                                                    'agendaDia', 'nomePaciente' ,'nomeProfissional',
                                                    'paciente', 'profissional'
                                                ));


    }

    public function busca_agenda(Request $request) {

        $dia             = $request->dia_selecionado;
        $id_profissional = $request->id_profissional;
        
        $agendaProfissional = new AgendaProfissional();
        
        $agendas = DB::table('agenda_profissionais AS ag_prof')
                        ->leftJoin('profissionais AS prof', 'prof.id', '=', 'ag_prof.id_profissional')
                        ->leftJoin('pessoas', 'prof.id_pessoa', '=', 'pessoas.id')
                        ->select('ag_prof.id AS id_agenda_prof', 'ag_prof.hora_inicial', 'ag_prof.hora_final', 'ag_prof.duracao')
                        ->where('prof.id', '=', $id_profissional)
                        ->where('data_inicial', '<=', "'$dia'")
                        ->where('data_final', '>=', "'$dia'")
                        ->orderby('ag_prof.hora_inicial')
                        ->get();

        $horarios = Array();
        
        foreach($agendas as $agenda) {

            $id_agenda_profissional = $agenda->id_agenda_prof;

            $agendados = DB::table('agenda_dias AS ad')
                 ->leftJoin('pacientes AS p', 'p.id', '=', 'ad.id_paciente')
                 ->leftJoin('agenda_profissionais AS ag_prof', 'ag_prof.id', '=', 'ad.id_agenda_profissional')
                 ->leftJoin('atendimentos AS at', 'at.id_agenda_dia', '=', 'ad.id')
                 ->leftJoin('profissionais AS prof', 'prof.id', '=', 'ag_prof.id_profissional')
                 ->leftJoin('pessoas AS p_pac', 'p_pac.id', '=', 'p.id_pessoa')
                 ->leftJoin('pessoas AS p_prof', 'p_prof.id', '=', 'prof.id_pessoa')
                 ->select(
                    'ad.id AS id_agenda_dia', 
                    'ad.observacao',
                    DB::raw("CASE 
                        WHEN ad.status = 1 THEN 'Compareceu'
                        ELSE 'Não Compareceu'
                    END AS status
                    "), 
                    'p_prof.nome AS nome_profissional', 
                    'p_pac.nome AS nome_paciente', 
                    "ad.hora",
                    'at.id AS id_atendimento'
                 )
                 ->where('ag_prof.id', '=', $id_agenda_profissional)
                 ->where('ad.data', '=', "'$dia'")
                 ->orderby('ad.hora')
                 ->get();



            $horaControle = substr($agenda->hora_inicial, 0, -3);
            $i = 0;
            while($horaControle < $agenda->hora_final) {

                $horarios[$i] = $this->_cria_horario($horaControle);

                // Laço nos registros agendados 'agenda_dias'.
                foreach($agendados as $agendado) {

                    $hora_formatada = substr($agendado->hora, 0, -3);

                    // Verifica se hora da agenda do profissional é a mesma que a agenda do dia.
                    if ( $hora_formatada == $horaControle ) {
                        
                        $horarios[$i] = $this->_cria_horario( $hora_formatada, $agendado->id_agenda_dia, $agendado->nome_paciente, $agendado->nome_profissional, $agendado->status, $agendado->observacao, $agendado->id_atendimento );

                    }

                }

                // Somo 5 minutos (resultado em int)
                $horaControle = strtotime("$horaControle + $agenda->duracao minutes");
                $horaControle = date("H:i", $horaControle);

                $i++;

            }

        }

        return view('agendaDia.agenda', compact('title', 'horarios', 'id_agenda_profissional'));

    }

    /**
     * Cria o array com os dados do horário.
     */
    private function _cria_horario( $hora = '', $id_agenda_dia = '', $nome_paciente = '', $nome_profissional = '', $status = '', $observacao = '', $id_atendimento = '' ) {

        $horario = Array(
            'id_agenda_dia'     => $id_agenda_dia,
            'status'            => $status,
            'nome_paciente'     => $nome_paciente,
            'nome_profissional' => $nome_profissional,
            'hora'              => $hora,
            'observacao'        => $observacao,
            'id_atendimento'    => $id_atendimento
        );

        return $horario;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $title = "Cadastrar Agendamento do Dia";

        $agendaDia = $request->all();

        
        $profissional = DB::table("agenda_profissionais AS ap")
                            ->leftJoin('profissionais AS prof', 'prof.id', '=', 'ap.id_profissional')
                            ->leftJoin('pessoas AS p_prof', 'p_prof.id', '=', 'prof.id_pessoa')
                            ->select('ap.id AS id_agenda_profissional')
                            ->where('ap.id', '=', $agendaDia['id_agenda_profissional'])
                            ->first();
        
        return view('agendaDia.create-edit', compact('title', 'agendaDia', 'profissional'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AgendaDiaFormRequest $request)
    {

        $data = date_create_from_format('d/m/Y', $request->input('data'));
        
        $dataAgendaDia['id_paciente']            = $request->input('id_paciente');
        $dataAgendaDia['id_agenda_profissional'] = $request->input('id_agenda_profissional');
        $dataAgendaDia['data']                   = date_format($data, 'Y-m-d');
        $dataAgendaDia['hora']                   = $request->input('hora');
        $dataAgendaDia['observacao']             = $request->input('observacao');


        $insert = $this->agendaDia->create($dataAgendaDia);

        if ( $insert ) {
            return redirect()->route('agenda_dia.index')->with('status', 'Agendamento criado com sucesso!');
        } else {
            return redirect()->route('agenda_dia.create')->withErrors(['msg' => 'Falha ao criar agendamento!']);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $agendaDia = agendaDia::find($id);

        // Deleta agendaDia.
        $delete = $agendaDia->delete();

        if ( $delete ) {

            return redirect()->route('agenda_dia.index')->with('status', 'Agendamento removido com sucesso!');

        } else {
            
            return redirect()->route('agenda_dia.index', $id)->withErrors(['msg' => 'Falha ao excluir agendamento!']);

        }
    }
}
