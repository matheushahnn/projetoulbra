<?php

namespace App\Http\Controllers\Atendimento;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Atendimento;
use App\Models\ProcedimentoAtendimento;
use App\Http\Requests\Atendimento\AtendimentoFormRequest;
use Carbon;

use Illuminate\Support\Facades\DB;

class AtendimentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $atendimentos = DB::table('atendimentos as a')
                              ->leftJoin('pacientes as p', 'p.id', '=', 'a.id_paciente')
                              ->leftJoin('profissionais as prof', 'prof.id', '=', 'a.id_profissional')
                              ->leftJoin('pessoas as p_pac', 'p_pac.id', '=', 'p.id_pessoa')
                              ->leftJoin('pessoas as p_prof', 'p_prof.id', '=', 'prof.id_pessoa')
                              ->select('p_pac.nome AS nome_paciente', 'p_prof.nome AS nome_profissional', 'a.id', 'a.data', 'a.hora')
                              ->get();

        $title = "Atendimentos";

        return view('atendimento.list', compact('title', 'atendimentos'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Cadastrar Atendimento";

        $data = Carbon\Carbon::now()->format( 'd/m/Y' );
        $hora = Carbon\Carbon::now()->format( 'h:i' );

        return view('atendimento.create-edit', compact('title', 'atendimento', 'data', 'hora'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AtendimentoFormRequest $request)
    {
        $dataAtendimento = Array();
        $dataProcedimento = Array();
        $dataAtendimento['id_paciente'] = $request->input('id_paciente');
        $dataAtendimento['id_profissional'] = $request->input('id_profissional');
        $dataAtendimento['data'] = $request->input('data');
        $dataAtendimento['hora'] = $request->input('hora');
        $dataAtendimento['id_agenda_dia'] = $request->input('id_agenda_dia');
        $dataProcedimento = $request->input('procedimento_atendimentos');

        // Início commit
        DB::beginTransaction();

        // Insere atendimento.
        $insertAtendimento = Atendimento::create($dataAtendimento);
        // Insere os procedimentos.
        $atendimento = Atendimento::find($insertAtendimento->id);
        // Verifica se existem procedimentos antes de salvá-los.
        if ( !empty( $dataProcedimento )) {
            $insertProcedimento = $atendimento
                                    ->procedimento()
                                    ->saveMany( array_map( function ($dataProcedimento) {
                                        return new ProcedimentoAtendimento($dataProcedimento);
                                    }, $dataProcedimento ) );
        } else {
            $insertProcedimento = TRUE;
        }

        DB::commit();


        if ( $insertProcedimento ) {
            return redirect()->route('atendimento.index');
        } else {
            return redirect()->route('atendimento.create');
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
        
        $atendimento_query = DB::table('atendimentos AS a')
                            ->leftJoin('procedimento_atendimentos AS pa', 'pa.id_atendimento', '=', 'a.id')
                            ->leftJoin('procedimentos AS p', 'p.id', '=', 'pa.id_procedimento')
                            ->leftJoin('pessoas AS p_pac', 'p_pac.id', '=', 'a.id_paciente')
                            ->leftJoin('pessoas AS p_prof', 'p_prof.id', '=', 'a.id_profissional')
                            ->where('a.id', '=', $id);

        $procedimento_list = $atendimento_query->select('p.descricao',  'p.id', 'pa.quantidade', 'pa.observacao')->get();
        $atendimento       = $atendimento_query->select('a.*', 'p_pac.nome AS nome_paciente', 'p_prof.nome AS nome_profissional')->first();

        $title = "Editando atendimento";

        return view('atendimento.create-edit', compact('title', 'atendimento', 'procedimento_list'));
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
        $dataAtendimento                    = Array();
        $dataProcedimento                   = Array();
        $dataAtendimento['id_paciente']     = $request->input('id_paciente');
        $dataAtendimento['id_profissional'] = $request->input('id_profissional');
        $dataAtendimento['data']            = $request->input('data');
        $dataAtendimento['hora']            = $request->input('hora');
        $dataProcedimento                   = $request->input('procedimento_atendimentos');

        // Início commit
        DB::beginTransaction();

        // Captura registro do atendimento.
        $atendimentoUpdate = Atendimento::find($id);

        // Atualiza atendimento.
        $updateAtendimento = $atendimentoUpdate->update($dataAtendimento);

        // Remove todos os procedimentos que possuem vínculo.
        $procedimentos_atendimento = ProcedimentoAtendimento::where('id_atendimento', '=', $id);
        $procedimentos_atendimento->delete();

        // Insere os procedimentos.
        $atendimento = Atendimento::find($id);
        // Verifica se existem procedimentos antes de salvá-los.
        if ( !empty( $dataProcedimento )) {
            $insertProcedimento = $atendimento
                                    ->procedimento()
                                    ->saveMany( array_map( function ($dataProcedimento) {
                                        return new ProcedimentoAtendimento($dataProcedimento);
                                    }, $dataProcedimento ) );
        } else {
            $insertProcedimento = TRUE;
        }

        DB::commit();


        if ( $insertProcedimento ) {
            return redirect()->route('atendimento.index');
        } else {
            return redirect()->route('atendimento.create');
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
        
        $atendimento = Atendimento::find($id);

        $delete = $atendimento->delete();

        if ( $delete ) {

            return redirect()->route('atendimento.index', $id);

        } else {

            return redirect()->route('atendimento.index', $id)->with('Falha ao excluir atendimento.');

        }


    }
}
