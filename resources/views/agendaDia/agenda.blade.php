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
			<td>
				{{ $horario['hora'] }}
			</td>
			<td>
				{{ $horario['nome_paciente'] }}
			</td>
			<td>
				{{ $horario['nome_profissional'] }}
			</td>
			<td>
				{{ $horario['status'] }}
			</td>
			<td class='funcoes'>
				@if ( !empty( $horario['id_agenda_dia'] ) && empty( $horario['id_atendimento'] ) )
					<a href="/agenda/agenda_dia/iniciar_atendimento/{{ $horario['id_agenda_dia'] }}" class='actions confirmar_presenca'>
						<span class='glyphicon glyphicon-ok'></span>
					</a>
					<a href='#' class='actions delete'>
						<span class='glyphicon glyphicon-trash'></span>
					</a>
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