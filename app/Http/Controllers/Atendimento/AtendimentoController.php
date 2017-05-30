<?php

namespace App\Http\Controllers\Atendimento;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Atendimento;
use App\Models\ProcedimentoAtendimento;
use App\Http\Requests\Atendimento\AtendimentoFormRequest;

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
                              ->leftJoin('procedimento_atendimentos as pa', 'pa.id_atendimento', '=', 'a.id')
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

        return view('atendimento.create-edit', compact('title', 'atendimento'));
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
        $dataProcedimento = $request->input('procedimento_atendimentos');

        // Início commit
        DB::beginTransaction();

        // Insere atendimento.
        $insertAtendimento = Atendimento::create($dataAtendimento);
        // Insere os procedimentos.
        $atendimento = Atendimento::find($insertAtendimento->id);
        $insertProcedimento = $atendimento->procedimento()->saveMany(array_map(function ($dataProcedimento) {
                                    return new ProcedimentoAtendimento($dataProcedimento);
                                }, $dataProcedimento));

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
        //
    }
}
