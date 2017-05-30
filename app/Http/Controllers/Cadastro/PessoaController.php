<?php

namespace App\Http\Controllers\Cadastro;

use Illuminate\Http\Request;
use App\Models\Pessoa;
use App\Models\Paciente;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Cadastro\PacienteController;
use App\Http\Requests\Cadastro\PessoaFormRequest;
use App\Http\Requests\Cadastro\PacienteFormRequest;

class PessoaController extends Controller
{


    public function __construct(Pessoa $pessoa) {

        $this->pessoa = $pessoa;
        $this->paciente = new Paciente();

        $this->middleware('auth');

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storePessoa(PessoaFormRequest $request)
    {

        // Pega todos os dados.
        $dataForm = $request->all();

        $dataPaciente = new PacienteFormRequest();
        $dataPaciente = $dataPaciente->all();

        $insert = $this->pessoa->create($dataForm);
        if ( $insert ) {
            $dataPaciente['id_pessoa'] = $insert->id;
            $dataPaciente['ficha_atendimento'] = $dataForm['ficha_atendimento'];
            dd($dataPaciente);
            $this->paciente->create($dataPaciente);
        } else {
            return 'Erro';
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
