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
	// Atendimentos.
	Route::post('/atendimento/search', 'AtendimentoController@search')->name('atendimento.search');
	Route::resource('/atendimento', 'AtendimentoController');

});

# Grupo de Agendas.
Route::group(['namespace' => 'Agendas','prefix' => 'agenda', 'middleware' => 'auth'], function() {

	// Agenda do dia.
	Route::get('/agenda_dia/iniciar_atendimento/{id_agendamento}', 'AgendaDiaController@iniciarAtendimento')->name('agenda_dia.iniciar_atendimento');
	Route::post('/agenda_dia/busca_agenda', 'AgendaDiaController@busca_agenda')->name('agenda_dia.busca_agenda');
	Route::post('/agenda_dia/create', 'AgendaDiaController@create')->name('agenda_dia.create');
	Route::resource('/agenda_dia', 'AgendaDiaController');

});

# Grupo de Cadastros.
Route::group(['namespace' => 'Cadastro','prefix' => 'cadastro', 'middleware' => 'auth'], function() {

	// Procedimentos
	Route::resource('/procedimento', 'ProcedimentoController'); #->middleware('auth')

	// Profissionais.
	Route::resource('/profissional', 'ProfissionalController');

	// Agenda Profissional.
	Route::resource('/agenda_profissional', 'AgendaProfissionalController');

	// Pacientes.
	Route::resource('/paciente', 'PacienteController');

});	

# Grupo de Relatório.
Route::group(['prefix' => 'relatorios'], function() {
	Route::get('/atendimentos', function() {
		return 'Relatório de Atendimentos';
	});
});	

Route::get('/', 'HomeController@index')->name('home')->middleware('auth');

# Rota de Autenticação.
Auth::routes();

Route::get('/home', 'HomeController@index')->middleware('auth');

Route::post('/procedimento/busca_autocomplete', 'Cadastro\\ProcedimentoController@buscaAutocomplete')->name('procedimento.buscaAutocomplete');
Route::post('/profissional/busca_autocomplete', 'Cadastro\\ProfissionalController@buscaAutocomplete')->name('profissional.buscaAutocomplete');
Route::post('/paciente/busca_autocomplete', 'Cadastro\\PacienteController@buscaAutocomplete')->name('paciente.buscaAutocomplete');
