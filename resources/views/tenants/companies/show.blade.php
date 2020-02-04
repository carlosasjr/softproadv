@extends('adminlte::page')

@section('title_postfix', ' - Detalhes da Empresa')

@section('content_header')
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">Empresas</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('tenants') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('companies.index') }}">Empresas</a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('companies.show', $company->id) }}" class="active">Detalhes</a>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
@stop


@section('content')
    @include('tenants.includes.alerts')

    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title">
                Identificação
                <small>Empresa</small>
            </h3>
            <!-- tools box -->
        @include('tenants.includes.toolsBox')
        <!-- /. tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body pad">
            <p><strong>ID: </strong>{{  $company->id }}</p>
            <p><strong>Nome: </strong>{{  $company->name }}</p>
            <p><strong>SubDominio: </strong>{{  $company->subdomain }}</p>
            <p><strong>Host: </strong>{{  $company->db_host }}</p>
            <p><strong>User: </strong>{{  $company->db_username }}</p>
        </div>
        <!-- /.card-body -->
    </div>

    {!! Form::model($company, ['route' => ['companies.destroy', $company->id], 'class' => 'form', 'method' => 'delete' ]) !!}
    {!! Form::submit('Deletar', ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop



