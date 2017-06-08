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

    public function search(Request $request) {

        $data = $request->all();
        
        $data_inicial = $request->input('data_inicial');
        $data_final = $request->input('data_final');
        $hora_inicial = $request->input('hora_inicial');
        $hora_final = $request->input('hora_final');

        $validator = NULL;

        $select = Array(
          'p.nome AS nome_profissional', 
          'ap.id',
          'ap.data_inicial',
          'ap.hora_inicial',
          'ap.data_final',
          'ap.hora_final',
          DB::raw("CASE WHEN ap.status IS TRUE THEN 'Ativo' ELSE 'Inativo' END AS status"),
        );

        // DB::connection()->enableQueryLog();

        if ( empty( $data['busca'] ) ) {
            
            return $this->index();

        } else {

            if ($data['tipo_busca'] != 'id') {
                

                $agendas = DB::table('agenda_profissionais AS ap')
                              ->leftJoin('profissionais AS prof', 'prof.id', '=', 'ap.id_profissional')
                              ->leftJoin('pessoas AS p', 'p.id', '=', 'prof.id_pessoa')
                              ->select($select)
                              ->where($data['tipo_busca'], 'ilike', $data['busca'] . '%')
                              ->when( $data_inicial, function ( $query ) use ( $data_inicial ) {
                                return $query->where( 'ap.data_inicial', '>=', $data_inicial );
                              })
                              ->when( $data_final, function ( $query ) use ( $data_final ) {
                                return $query->where( 'ap.data_final', '<=', $data_final );
                              })
                              ->when( $hora_inicial, function ( $query ) use ( $hora_inicial ) {
                                return $query->where( 'ap.hora_inicial', '>=', $hora_inicial );
                              })
                              ->when( $hora_final, function ( $query ) use ( $hora_final ) {
                                return $query->where( 'ap.hora_final', '<=', $hora_final );
                              })
                              ->orderby('nome')
                              ->get();

                  // dd(DB::getQueryLog());

            } else if ($data['tipo_busca'] == 'id') {

                $validator = $this->validate($request, [
                    'busca' => 'numeric',
                ]);

                $agendas =  DB::table('profissionais AS prof')
                          ->leftJoin('pessoas', 'prof.id_pessoa', '=', 'pessoas.id')
                          ->select($select)
                          ->where('prof.'.$data['tipo_busca'], '=', $data['busca'])
                          ->orderby('nome')
                          ->get();

            }

            $title = "Cadastrar Agenda Profissional";

            return view('agendaProfissional.list', compact('title', 'agendas'))->withErrors($validator);; 

        }

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


        $title = "Listagem de agendas";

        return view('agendaProfissional.list', compact('title', 'agendas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = "Cadastrar Agenda Profissional";

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

        $dataPost = Array();
        $dataPost['id_profissional'] = $request->input('id_profissional');
        $dataPost['data_inicial'] = $request->input('data_inicial');
        $dataPost['hora_inicial'] = $request->input('hora_inicial');
        $dataPost['data_final'] = $request->input('data_final');
        $dataPost['hora_final'] = $request->input('hora_final');
        $dataPost['status'] = $request->input('status');
        $dataPost['duracao'] = $request->duracao('id_profissional');

        dd($dataPost);

        // $dataPost['id_profissional'] = 1;
        // $dataPost['data_inicial'] = '2017-10-10';
        // $dataPost['hora_inicial'] = '08:00';
        // $dataPost['data_final'] = '2017-10-20';
        // $dataPost['hora_final'] = '10:00';
        // $dataPost['status'] = '1';
        // $dataPost['duracao'] = 20;

        // Salva agendaprofissional
        $insert = AgendaProfissional::create($dataPost);
        
        if ( $insert ) {
            return redirect()->route('agenda_profissional.index')->with('status', 'Agenda do profissional criado com sucesso!');
        } else {
            return redirect()->route('agenda_profissional.create')->withErrors(['msg' => 'Falha ao criar agenda profissional!']);
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
        
        $title = "Editar agenda do profissional: {$profissional->pessoa->nome}";

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
        
        $dataForm = $request->all();

        // Recupera o item para editar.
        $agenda_profissional = $this->agendaProfissional->find($id);

        // Altera agenda profissional.
        $update = $agenda_profissional->update($dataForm);
        
        if ( $update ) {
            return redirect()->route('agenda_profissional.index');
        } else {
            return redirect()->route('agenda_profissional.create');
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
