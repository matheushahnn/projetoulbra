<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

# Grupo de Atendimentos.
Route::group(['namespace' => 'Atendimento','prefix' => 'atendimento', 'middleware' => 'auth'], function() {
	Route::get('/', function() {
		return 'Atendimentos';
	});

	// Atendimentos.
	Route::post('/atendimento/search', 'AtendimentoController@search')->name('atendimento.search');
	Route::resource('/atendimento', 'AtendimentoController');

});

# Grupo de Agendas.
Route::group(['namespace' => 'Agendas','prefix' => 'agenda', 'middleware' => 'auth'], function() {
	Route::get('/', function() {
		return 'Agendas';
	});

	// Agenda do dia.
	Route::get('/agenda_dia/iniciar_atendimento/{id_agendamento}', 'AgendaDiaController@iniciarAtendimento')->name('agenda_dia.iniciar_atendimento');
	Route::post('/agenda_dia/busca_agenda', 'AgendaDiaController@busca_agenda')->name('agenda_dia.busca_agenda');
	Route::post('/agenda_dia/create', 'AgendaDiaController@create')->name('agenda_dia.create');
	Route::resource('/agenda_dia', 'AgendaDiaController');

});

# Grupo de Cadastros.
Route::group(['namespace' => 'Cadastro','prefix' => 'cadastro', 'middleware' => 'auth'], function() {
	Route::get('/', function() {
		return 'Cadastros';
	});
	// Procedimentos
	Route::post('/procedimento/search', 'ProcedimentoController@search')->name('procedimento.search'); #->middleware('auth')
	Route::resource('/procedimento', 'ProcedimentoController'); #->middleware('auth')

	// Profissionais.
	Route::post('/profissional/search', 'ProfissionalController@search')->name('profissional.search');
	Route::resource('/profissional', 'ProfissionalController');

	// Agenda Profissional.
	Route::post('/agenda_profissional/search', 'AgendaProfissionalController@search')->name('agenda_profissional.search');
	Route::resource('/agenda_profissional', 'AgendaProfissionalController');

	// Pacientes.
	Route::resource('/paciente', 'PacienteController');
	Route::post('/paciente/search', 'PacienteController@search')->name('paciente.search');

	Route::resource('/pessoa', 'PessoaController');
	Route::post('/pessoa/storePessoa', 'PessoaController@storePessoa')->name('pessoa.storePessoa');

});	

# Grupo de Relatório.
Route::group(['prefix' => 'relatorios'], function() {
	Route::get('/atendimentos', function() {
		return 'Relatório de Atendimentos';
	});
});	

Route::get('/', function () {
    return view('welcome');
});

# Rota de Autenticação.
Auth::routes();

Route::get('/home', 'HomeController@index');

Route::post('/procedimento/busca_autocomplete', 'Cadastro\\ProcedimentoController@buscaAutocomplete')->name('procedimento.buscaAutocomplete');
Route::post('/profissional/busca_autocomplete', 'Cadastro\\ProfissionalController@buscaAutocomplete')->name('profissional.buscaAutocomplete');
Route::post('/paciente/busca_autocomplete', 'Cadastro\\PacienteController@buscaAutocomplete')->name('paciente.buscaAutocomplete');
