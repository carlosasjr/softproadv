@extends('adminlte::page')

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/css/default.css') }}">
@stop

@section('title_postfix', ' - Cadastrar Nova Atividade')

@section('adminlte_css')
    <link rel="stylesheet" href={{ asset('vendor/alertify/css/alertify.core.css') }} />
    <link rel="stylesheet" href={{ asset('vendor/alertify/css/alertify.default.css') }} />
@stop

@section('content_header')
    <div class="container-fluid">
        @include('tenants.includes.breadcrumbs',  ['title' => $title,
                               'breadcrumbs' => [
                               'Atividades' => route('events.index'),
                                isset($data->id) ? 'Editar' : 'Cadastrar', ]
                              ])
    </div><!-- /.container-fluid -->
@stop


@section('content')
    @include('tenants.includes.alerts')

    <div class="alert alert-warning" style="display: none">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-exclamation"></i> Atenção!</h4>
        <div id="warning"></div>
    </div>

    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title">
                Identificação
                <small>Atividade</small>
            </h3>
            <!-- tools box -->
        @include('tenants.includes.toolsBox')
        <!-- /. tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body pad">
            @include('tenants.events.partials.form')
        </div>
        <!-- /.card-body -->
    </div>
@stop

@section('js')
    <script>
        var submitAjaxPut = "{{ route('events.update', isset($data->id) ? $data->id : 0 ) }}"
        var submitAjax = "{{ route('events.store') }}";
        var routeProcessAjax = "{{ route('processes.select') }}"
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
    <script src="{{ url('vendor/jquery/jquery.validate.min.js') }}"></script>
    <script src="{{ url('vendor/jquery/additional-methods.js') }}"></script>
    <script src="{{ url('vendor/jquery/messages_pt_BR.min.js') }}"></script>
    <script src="{{ url('vendor/jquery/jquery.mask.min.js') }}"></script>
    <script type="text/javascript" src={{ asset('vendor/alertify/js/alertify.min.js') }}></script>
    <script type="text/javascript" src={{ asset('assets/js/events/validation.js') }}></script>
@stop


