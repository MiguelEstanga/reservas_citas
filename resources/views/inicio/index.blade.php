@extends('layout.app')

@section('content')
    <div class="calendario-container">
        <div style="col-md-6">
            <div>
                <h2>Calendario</h2>
            </div>
            <div id="calendar"></div>
        </div>
        <div class="ml-4" style="position: relative; top: 105px;">
            <h3>Listado de eventos por asistir</h3>
            <div class="d-flex justify-content-end">
                <a class="flecha" href="?page={{ $currentPage - 1 }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="var(--color_menu)" class="bi bi-caret-up-fill" viewBox="0 0 16 16">
                        <path d="m7.247 4.86-4.796 5.481c-.566.647-.106 1.659.753 1.659h9.592a1 1 0 0 0 .753-1.659l-4.796-5.48a1 1 0 0 0-1.506 0z"/>
                      </svg>
                </a>
            </div>
            <div class="container_eventos_lista p-2">
                @if (count($eventos) > 0)
                    @foreach ($eventos as $evento)
                        <div class="evento">
                            <div class="icon">

                            </div>
                            <div class="d-flex flex-column justify-content-start align-items-start" style=" height: 100%; width: 100%;">
                                <span class="font-weight-bold" style="font-size: 20px;">{{ $evento['title'] }}</span>
                                <span>{{ $evento['description'] }}</span>
                            </div>

                        </div>
                    @endforeach
                @else
                    <p>No hay eventos para mostrar.</p>
                @endif
            </div>
            <div class="d-flex justify-content-end">
                <a href="?page={{ $currentPage + 1 }}" class="flecha">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="var(--color_menu)" class="bi bi-caret-down-fill" viewBox="0 0 16 16">
                        <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                      </svg>
                </a>
            </div>
            

        </div>
    </div>

    <style>
        .calendario-container {
            display: grid;
            grid-template-columns: 70% 30%;
            gap: 60px;
        }


        .eventos-lista {
            width: 30%;

            border-radius: 5px;
            padding: 10px;
        }

        .container_eventos_lista {
            display: grid;
            border: solid 1px black;
            height: 450px;
        }

        .evento {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            gap: 10px;
            border-bottom: solid 1px black;
        }

        .icono {
            font-size: 24px;
            margin-right: 10px;
        }

        .paginacion {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
      

        .fc-event {
            background-color: yellow;
            color: black;
            border: none;
            padding: 2px;
            border-radius: 3px;
        }

        .icon {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: var(--color_menu);
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <script defer>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: {!! json_encode($allEvents) !!}, // Usar todos los eventos para FullCalendar
                locale: 'es'
            });
            calendar.render();
        });
    </script>
@endsection
