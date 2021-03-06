$( document ).ready(function() {
		$( ".campo_data, #datepicker_agenda" ).datepicker({
		  dayNamesMin: [ "D", "S", "T", "Q", "Q", "S", "S" ],
    	monthNames: [ "Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro" ],
    	dateFormat: "dd/mm/yy",
		});

		$.ajaxSetup({
		  headers: {
		    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		});


		// Click em algum horário da agenda do dia.
		$( "#datepicker_agenda" ).datepicker( 'option', 'onSelect', function(date) {

				var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

				// POST para verificar horários do profissional e montar a agenda do dia.
				$.ajax({
          type: "POST",
          url: '/agenda/agenda_dia/busca_agenda',
          data: {
          	dia_selecionado: date,
          	id_profissional: $('#form_dia_profissional').find('#id_profissional').val(),
          },
          success: function( response ) {
						var $horario_agenda = $( "#horarios_dia_profissional" ); // agenda do dia.
          	// Insere a agenda do dia no espaço apropriado.
          	$horario_agenda.html( response );

            // Click no horário para inserir agendamento.
            // Click em algum horário da agenda do dia.
            $horario_agenda.find( ".horario_agenda td:not(.funcoes)" ).click( function() {

								var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

								var hora = $(this).closest('tr').attr('data-hora');

								// Verifica se profissional possui agenda.
								var id_agenda_profissional = $('#agenda_dia_profissional').attr('data-id-agenda-prof');

								if ( !id_agenda_profissional ) {
									alert('Profissional não possui agenda para este dia.');
									return false;
								}

								// POST para verificar horários do profissional e montar a agenda do dia.
								$.ajax({
				          type: "POST",
				          url: '/agenda/agenda_dia/create',
				          data: {
				          	dia_selecionado: date,
				          	hora_selecionada: hora,
				          	id_agenda_profissional: $('#agenda_dia_profissional').attr('data-id-agenda-prof'),
				          },
				          success: function( response ) {
				          	$('.janela').html(response);
				            carregaAutocompletePaciente();
				          }
				      	});
			    	});

          }
      	});
    	});

    $( ".campo_data, #datepicker_agenda" ).datepicker();
    //$( '.campo_data, #datepicker_agenda' ).datepicker( 'option',  );
    // Agenda inline.
    $( '#datepicker_agenda' ).datepicker({});

    // $('.mask_numero').keydown( function(evt) {
    // 	  var theEvent = evt || window.event;
			 //  var key = theEvent.keyCode || theEvent.which;
			 //  key = String.fromCharCode( key );
			 //  var regex = /[0-9]|\./;
			 //  var codigo_permitidos = Array( 8, 9, 35, 36, 37, 38, 39,40,45,46 );

			 //  if ( $.inArray( evt.keyCode, codigo_permitidos ) == 0 ) {
    //     	return true;
    //     } else if( !regex.test(key) ) {
			 //    theEvent.returnValue = false;
			 //    if(theEvent.preventDefault) theEvent.preventDefault();
			 //  }
    // }	);
    $( '.campo_data' ).mask( "99/99/9999" );
    // Expressão regular.
    $( '.campo_hora' ).mask( "AB:CD",  {'translation': {
																					A: { pattern: /[0-2*]/ },
																					B: { pattern: /[0-9*]/ },
																					C: { pattern: /[0-6*]/ },
																					D: { pattern: /[0-9*]/ },
																				}
																			 }
														);
    // Valida hora.
    $( '.campo_hora ').change(function() {
    	var $hora = $(this);
    	var hora_completa = $hora.val();
    	var hora_split = hora_completa.split(':');

    	// Verifica primeira parte hora.
    	if( ( hora_split[0] > 23 ) || ( hora_split[1] > 59 ) ) {
    		// Limpa campo hora.
    		$hora.val('');
    		return false;

    	}

    });

    // content do atendimento.
  	var $content_atendimento = $( '#create_atendimento' );

    /*
     * Remover procedimento.
     */
    // Click no ícone da lixeira.
    $content_atendimento.on( 'click', '.remover_procedimento', function() {
      // Remove linha do registro do procedimento.
      $( this ).closest( 'tr' ).remove();
    });

    // Adicionar Procedimento.
    $content_atendimento.find( "#btn_adicionar_procedimento" ).click( function() {

      var id_procedimento = $content_atendimento.find( '#id_procedimento' ).val();
    	var procedimento = $content_atendimento.find( '#procedimento' ).val();
    	var quantidade = $content_atendimento.find( '#quantidade' ).val();
    	var obs_procedimento = $content_atendimento.find( '#observacao_procedimento' ).val();

      // Validações.
      // Verifica se procedimento foi informado.
      if ( !id_procedimento ) {
        alert('É necessário informar um procedimento válido.');
        return false;
      }

      // Verifica se quantidade foi informada.
      if ( !quantidade ) {
        alert("É necessário informar a quantidade de procedimentos realizados.");
        return false;
      }

    	// Limpa campos procedimento.
    	$content_atendimento.find( '#procedimento, #id_procedimento, #observacao_procedimento, #quantidade' ).val('');

    	// Quantidade de procedimentos inseridos no atendimento. Controle do index do name.
    	var i = $content_atendimento.find( '#tabela_procedimentos_atendimento tbody tr' ).length;

    	var html  = '<tr>';
    	    html +=   '<td>';
    	    html +=     '<input type="hidden" name="procedimento_atendimentos['+i+'][id_procedimento]" value="'+id_procedimento+'" />';
    	    html +=     procedimento;
    	    html +=   '</td>';
    	    html +=   '<td>';
    	    html +=     '<input type="hidden" name="procedimento_atendimentos['+i+'][quantidade]" value="'+quantidade+'" />';
    	    html +=     quantidade;
    	    html +=   '</td>';
          html +=   '<td>';
          html +=     '<input type="hidden" name="procedimento_atendimentos['+i+'][observacao]" value="'+obs_procedimento+'"/>';
          html +=     obs_procedimento;
          html +=   '</td>';
          html +=   '<td>';
          html +=     '<span title="Remover procedimento" class="pointer text-center remover_procedimento fa fa-trash"></span>';
          html +=   '</td>';
          html += '</tr>';

    	$content_atendimento.find( '#tabela_procedimentos_atendimento' ).append( html );

      // Quantidade continua como 1.
      $content_atendimento.find( '#quantidade' ).val( 1 );

    });


    // Autocomplete para profissionais.
    $( ".autocomplete-profissional" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
        	type: 'POST',
          url: "/profissional/busca_autocomplete",
          dataType: "json",
          data: {
            term: request.term
          },
          success: function( data ) {
            response($.map(data, function (item) {
		            return {
		                label: item.nome,
		                value: item.id
		            };
		        }));
          }
        });
      },
      minLength: 0,
      select: function( event, ui ) {
          this.value = ui.item.label;
          $('.codigo_profissional_autocomplete').val(ui.item.value);
          return false;
      },
      open: function() {
        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    });


    // Autocomplete para pacientes.
    $( ".autocomplete-procedimento" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
        	type: 'POST',
          url: "/procedimento/busca_autocomplete",
          dataType: "json",
          data: {
            term: request.term
          },
          success: function( data ) {
            response($.map(data, function (item) {
		            return {
		                label: item.descricao,
		                value: item.id
		            };
		        }));
          }
        });
      },
      minLength: 0,
      select: function( event, ui ) {
          this.value = ui.item.label;
          $('.codigo_procedimento_autocomplete').val(ui.item.value);
          return false;
      },
      open: function() {
        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
      }
    });


    carregaAutocompletePaciente();


    function carregaAutocompletePaciente() {

	    // Autocomplete para pacientes.
	    $( ".autocomplete-paciente" ).autocomplete({
	      source: function( request, response ) {
	        $.ajax({
	        	type: 'POST',
	          url: "/paciente/busca_autocomplete",
	          dataType: "json",
	          data: {
	            term: request.term
	          },
	          success: function( data ) {
	            response($.map(data, function (item) {
			            return {
			                label: item.nome,
			                value: item.id
			            };
			        }));
	          }
	        });
	      },
	      minLength: 0,
	      select: function( event, ui ) {
	          this.value = ui.item.label;
	          $('.codigo_paciente_autocomplete').val(ui.item.value);
	          return false;
	      },
	      open: function() {
	        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
	      },
	      close: function() {
	        $( this ).removeClass( "ui-corner-top" ).addClass( "ui-corner-all" );
	      }
	    });

    }

    $('.dataTables-example').DataTable({
        pageLength: 10,
        responsive: true,
        language: {
            search: "Buscar:",
            info: "Exibindo _START_ até _END_ de _TOTAL_ resultados",
            lengthMenu: 'Exibir _MENU_ resultados &nbsp;',
            infoEmpty:      "Nenhum registro encontrado",  
            infoFiltered:   "(filtrado _MAX_ total)",
            emptyTable:     "Nenhum registro",
            zeroRecords:    "Nenhum registro",
            paginate: {
            first:      "Primeira",
            previous:   "Anterior",
            next:       "Próxima",
            last:       "Última",
            infoFiltered:   "(_MAX_ total)",
          },

          // processing:     "Traitement en cours...",
          // search:         "Rechercher&nbsp;:",
          // lengthMenu:    "Afficher _MENU_ &eacute;l&eacute;ments",
          // info:           "Affichage de l'&eacute;lement _START_ &agrave; _END_ sur _TOTAL_ &eacute;l&eacute;ments",
          // infoEmpty:      "Affichage de l'&eacute;lement 0 &agrave; 0 sur 0 &eacute;l&eacute;ments",
          // infoFiltered:   "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
          // infoPostFix:    "",
          // loadingRecords: "Chargement en cours...",
          // zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
          // emptyTable:     "Aucune donnée disponible dans le tableau",
          // paginate: {
          //     first:      "Premier",
          //     previous:   "Pr&eacute;c&eacute;dent",
          //     next:       "Suivant",
          //     last:       "Dernier"
          // },
          // aria: {
          //     sortAscending:  ": activer pour trier la colonne par ordre croissant",
          //     sortDescending: ": activer pour trier la colonne par ordre décroissant"
          // }

        },
        dom: '<"html5buttons"B>lTfgitp',
          buttons: [
            { extend: 'copy'},
            {extend: 'csv'},
            {extend: 'excel', title: 'ExampleFile'},
            {extend: 'pdf', title: 'ExampleFile'},
            {extend: 'print',
             customize: function (win){
                $(win.document.body).addClass('white-bg');
                $(win.document.body).css('font-size', '10px');
                $(win.document.body).find('table')
                        .addClass('compact')
                        .css('font-size', 'inherit');
            }
            }
        ]

    });

});
