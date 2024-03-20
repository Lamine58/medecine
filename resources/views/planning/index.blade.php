@extends('layouts.app')

@section('title', "Planning des RDV")

@section('content')
        
    <div class="main-content">

        <div class="page-content">
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                            <h4 class="mb-sm-0">Planning des RDV</h4>

                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a href="javascript: void(0);">Planning</a></li>
                                    <li class="breadcrumb-item active">Planning des RDV</li>
                                </ol>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div id="calendar"></div>
                            </div>
                        </div>
                    </div><!--end col-->
                    
                </div><!--end row-->

            </div>
            <!-- container-fluid -->
            
        </div>

@endsection

@section('script')
    <style>
        .fc .fc-button .fc-icon {
            visibility: hidden;
        }
    </style>

    <link href="assets/libs/fullcalendar/main.min.css" rel="stylesheet" type="text/css" />
    <script src="assets/libs/fullcalendar/main.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.0/locale/fr.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                initialView: 'dayGridMonth',
                events: [
                    @foreach(App\Models\Exam::all() as $exam)
                        {
                            title: '{{$exam->type_exam->name}}',
                            start: '{{$exam->date ?? $exam->created_at}}',
                        },
                    @endforeach
                ],
                eventClick: function(event) {
                },
                locale: 'fr',
                buttonText: {
                    today: 'Aujourd\'hui',
                    month: 'Mois',
                    week: 'Semaine',
                    day: 'Jour' 
                }
            });

            calendar.render();
        });

    </script>

@endsection 