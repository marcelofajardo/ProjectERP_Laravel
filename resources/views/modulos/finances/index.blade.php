@extends('home')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Checar Finanças</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('finances.create') }}"> Novo</a>
            </div>
        </div>
    </div>

    @if(session()->has('message'))
        <div class="uk-alert-success" uk-alert style="text-align: center; position: fixed; top: 0%; left: 18%; z-index: 1; width: 1000px">
            <a class="uk-alert-close" uk-close></a>
            <strong> {{ session('message') }} </strong>
        </div>
    @endif

    <ul class="nav nav-tabs">
        <li class="nav-item">
          <a class="nav-link active" href="{{ route('finances.index') }}">Recebimentos</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{ route('pagamentos.index') }}">Pagamentos</a>
        </li>
    </ul>

    <div class="tabela">
    <table class="table table-bordered">
        <tr>
            <th>Código</th>
            <th width="auto">Cliente</th>
            <th width="auto">Fatura</th>
            <th width="auto">Data</th>
            <th width="auto">Situação</th>
            <th>Valor</th>
            <th width="200px">Ação</th>
        </tr>
        @foreach ($finances ?? '' as $finance)
        <tr>
            <td>{{ $finance->id }}</td>
            <td>{{ $finance->cliente }}</td>
            <td>{{ $finance->fatura }}</td>
            <td>{{ date("d/m/Y", strtotime($finance->datacompetencia)) }}</td>
            <td>{{ $finance->operacao }}</td>
            <td>R$ {{ number_format($finance->valor, 2, ',', '.') }}</td>
            <td>
                <form action="{{ route('finances.destroy',$finance->id) }}" method="POST">

                    <a class="btn btn-primary" href="{{ route('finances.edit',$finance->id) }}">Visualizar</a>

                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Deletar</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    {!! $finances->links() !!}
    </div>

@endsection
