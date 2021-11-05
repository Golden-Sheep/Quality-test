@extends('adminlte::page')
@section('title', 'Quality-Sistemas | Pessoas')
@section('content_header')
    <h1>Pessoas </h1><small>Todas as pessoas cadastradas </small>
@stop
@section('content')
    <div class="content">
        <div class="col-xs-12">
            @if ($errors->has('error'))
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first('error') }}
                </div>
            @endif
            <div class="card">
                <div class="card-header with-border">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-lg-3">
                            <a href="/pessoas/cadastrar">
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>Nova</h3>
                                        <p>Pessoa</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <span class="small-box-footer">Cadastrar <i
                                                class="fa fa-arrow-circle-right"></i></span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="t_pessoas">
                        <thead>
                        <tr>
                            <th>
                                <input type="checkbox" id="selecionar-todos">
                            </th>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Data de nascimento</th>
                            <th>Email</th>
                            <th style="text-align: center;">Dependentes</th>
                            <th style="text-align: center;">Status</th>
                        </tr>
                        </thead>
                        <tbody id="body_t_pessoas">
                        @foreach($pessoas as $pessoa)
                            <tr>
                                <th>
                                    <input type="checkbox" class="box-pessoa" class="add-pessoa-inarray" data-id="{{$pessoa->id}}">
                                </th>
                                <td>{{$pessoa->id}}</td>
                                <td>
                                    <img class="user-image img-size-32" width="30px" height="30px" src="{{$pessoa->getPathImg()}}">
                                    <a href="/pessoas/editar/{{$pessoa->id}}" style="text-decoration:none; color: inherit;">{{$pessoa->nome}}</a>
                                </td>
                                <td>{{date_format(date_create($pessoa->data_de_nascimento), 'd/m/Y')}}</td>
                                <td>{{$pessoa->email}}</td>
                                <td style="text-align: center;">
                                    <a href="/pessoas/adicionar/dependentes/{{$pessoa->id}}">
                                    <i class="fas fa-plus-circle"></i>
                                    </a>
                                </td>
                                <td style="text-align: center;">
                                    @if($pessoa->status)
                                        <a href="/pessoas/desativar/{{$pessoa->id}}"><i class="far fa-circle text-green"></i></a>
                                    @else
                                        <a href="/pessoas/ativar/{{$pessoa->id}}"><i class="far fa-circle text-red"></i></a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                   <div class="btn btn-danger" onclick="removerPessoas()">Remover pessoas selecionadas</div>
                </div>
            </div>

        </div>
    </div>


@stop
@section('css')

@stop
@section('js')
    <script>
        $('#selecionar-todos').change(function() {
            if(this.checked) {
                console.log('entrei');
                $('.box-pessoa').prop('checked', true);
            }else{
                $('.box-pessoa').prop('checked', false);
            }
        });
        $(document).ready(function () {
            $("#t_pessoas").DataTable({
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

        function removerPessoas() {
            let array = [];
            $('.box-pessoa').each(function () {
                if(this.checked){
                    array.push($(this).data("id"));
                }
            });
            if(array.length > 0){
                Swal.fire({
                    title: 'Você tem certeza?',
                    text: "Você não poderá reverter isso!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sim, remover todas as pessoas selecionadas'
                }).then((result) => {
                    if (result.value) {
                        $(location).attr('href', '/pessoas/remover/'+JSON.stringify(array));
                    }
                })
            }else{
                Swal.fire({
                    icon: 'error',
                    title: 'Nenhuma pessoa selecionada',
                    text: 'Selecione ao menos uma pessoa para prosseguir come essa operação',
                })
            }
        }

    </script>
@stop