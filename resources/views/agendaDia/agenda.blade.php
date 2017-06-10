<table class='table agenda_dia_profissional' id='agenda_dia_profissional' data-id-agenda-prof='{{ $id_agenda_profissional or ''}}'>
<thead>
	<tr>
		<th>
			Hora
		</th>
		<th>
			Paciente
		</th>
		<th>
			Profissional
		</th>
		<th>
			Status
		</th>
		<th>
			Ações
		</th>
	</tr>
</thead>
	@forelse($horarios as $horario)
		<tr class='horario_agenda' data-hora="{{ $horario['hora'] }}" title='{{ $horario['observacao'] }}' data-id-agenda-dia="{{ $horario['id_agenda_dia'] }}">
			<td class='pointer'>
				{{ $horario['hora'] }}
			</td>
			<td class='pointer'>
				{{ $horario['nome_paciente'] }}
			</td>
			<td class='pointer'>
				{{ $horario['nome_profissional'] }}
			</td>
			<td class='pointer'>
				{{ $horario['status'] }}
			</td>
			<td class='funcoes'>
				@if ( !empty( $horario['id_agenda_dia'] ) && empty( $horario['id_atendimento'] ) )
					<form method='post' action="{{ route('agenda_dia.destroy', $horario['id_agenda_dia']) }}">
				  	{!! method_field('DELETE') !!}
				  	{!! csrf_field() !!}
						<a href="/agenda/agenda_dia/iniciar_atendimento/{{ $horario['id_agenda_dia'] }}" class='actions confirmar_presenca'>
							<span class='fa fa-check'></span>
						</a>
						<button type='submit' class='btn-delete'>
							<span class='fa fa-trash'></span>
						</button>
					</form>
				@elseif( !empty( $horario['id_agenda_dia'] ) && !empty( $horario['id_atendimento'] ) )
					<span>Paciente presente</span>
				@endif
			</td>
		</tr>

	@empty
		<tr>
			<td colspan="5">Profissional não possui agenda para este dia</td>
		</tr>
	@endforelse	



</table>