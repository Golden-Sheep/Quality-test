@extends('adminlte::page')
@section('title', 'Quality-Sistemas | Dependentes')
@section('content_header')
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <div style="height: 15rem;  background-image: url('/img/avatar-default.jpg'); background-repeat: no-repeat; background-size:100% 100%;">

                    </div>
                </div>
                <div class="col-9">
                    <div>
                        <b>Nome</b> {{$pessoa->nome}}
                    </div>
                    <div>
                        <b>Data de Nascimento </b> {{date_format(date_create($pessoa->data_de_nascimento), 'd/m/Y')}}
                    </div>
                    <div>
                        <b>E-mail</b> {{$pessoa->email}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('content')
    <div class="content">
        <div class="col-xs-12">
            <div class="card">
                <form role="form" action="{{url('dependentes/cadastrar')}}" method="post" autocomplete="off">
                    {!! csrf_field() !!}
                    <input type="hidden" name="pessoa_id" value="{{$pessoa->id}}">
                    <div class="card-header with-border">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group ">
                                    <label>Nome</label>
                                    <input type="text" name="nome"
                                           class="form-control {{$errors->has('nome') ? 'is-invalid' : '' }}"
                                           value="{{old('nome')}}" required>
                                    @if($errors->has('nome'))
                                        <span class="help-block text-red">
                                        <strong>{{ $errors->first('nome') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-5">
                                <div class="form-group ">
                                    <label>Data de Nascimento</label>
                                    <input type="date" min="{{date_format(date_create("-120 years"), 'Y-m-d')}}"
                                           max="{{date('Y-m-d')}}"
                                           name="data_de_nascimento"
                                           class="form-control {{$errors->has('data_de_nascimento') ? 'is-invalid' : '' }}"
                                           value="{{old('data_de_nascimento')}}"
                                           required>
                                    @if($errors->has('data_de_nascimento'))
                                        <span class="help-block text-red">
                                        <strong>{{ $errors->first('data_de_nascimento') }}</strong>
                                </span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-sm-2">
                                <div><label>&nbsp;</label></div>
                                <div>
                                    <button type="submit" class="btn btn-block btn-primary">Adicionar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="card-body">
                    <table class="table table-striped" id="t_dependentes">
                        <thead>
                        <tr>
                            <th>Nome do Dependente</th>
                            <th>Data de Nascimento</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody id="body_t_dependentes">
                        @foreach($pessoa->dependentes as $dependente)
                            <tr>
                                <td>{{$dependente->nome}}</td>
                                <td>{{date_format(date_create($dependente->data_de_nascimento), 'd/m/Y')}}</td>
                                <td><i onclick="removerDependente({{$dependente->id}})" style="cursor: pointer;" class="fas fa-minus-circle text-red"></i></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>


@stop
@section('css')

@stop
@section('js')
    <script>

        $(document).ready(function () {
            $("#t_dependentes").DataTable({
                "language": {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    }
                }
            });
        });

        function removerDependente(idDependete){
            Swal.fire({
                title: 'Você tem certeza?',
                text: "Você não poderá reverter isso!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, remover dependente'
            }).then((result) => {
                if (result.value) {
                    $(location).attr('href', '/dependentes/remover/'+idDependete);
                }
            })
        }
    </script>
@stop