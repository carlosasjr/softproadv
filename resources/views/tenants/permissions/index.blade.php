@extends('adminlte::page')

@include('tenants.includes.dataTableCss')

@section('title_postfix', ' - Permissões')

@section('content_header')

    @include('tenants.includes.breadcrumbs',  ['title' => 'Gestão de Permissões' ,
                                               'breadcrumbs' => [
                                               'Permissões', ]
                                              ])
@stop

@section('content')

    @include('tenants.includes.alerts')

    <div class="content">
        <!--TABELA -->
    @include('tenants.permissions.partials.table')
    <!--TABELA -->
    </div>
@stop

@section('js')
    <script src="{{ url('vendor/jquery/jquery.min.js') }}"></script>

    @include('tenants.includes.dataTableJs')

    <script>
        var urlAjax = '{{ route('permissions.index') }}';

        var columns = [
            {data: "id"},
            {data: "label"},
            {
                data: 'action',
                orderable: false
            }
        ]
    </script>
    <script type="text/javascript" src={{ asset('assets/js/all/table-default.js') }}></script>
@stop




