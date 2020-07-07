<?php

namespace App\Http\Controllers;

use App\Pagamentos;
use Illuminate\Http\Request;

class PagamentosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagamentos = Pagamentos::latest()->paginate(4);
        //return view('modulos.finances.index');
        return view('modulos.finances.pagamentos.index',compact('pagamentos'))->with('i', (request()->input('page',1)-1)*5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $codLancamento = Pagamentos::max('id')+1;
        return view('modulos.finances.pagamentos.create', compact('codLancamento'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'fornecedor' => 'required|string|regex:/^[\p{L}\s-]+$/|max:255',
            'notafiscal' => 'required|unique:pagamentos',
            'valor' => 'required|numeric',
            'codFornecedor' => 'required|numeric',
            'descricao' => 'required|alpha',
            'cddespesa' => 'required|numeric',
            'operacao' => 'required|numeric',
            'datacompetencia' => 'required'
        ]);

        Pagamentos::create($request->all());

        return redirect()->route('pagamentos.index')
                        ->with('success','Lançado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pagamentos  $pagamentos
     * @return \Illuminate\Http\Response
     */
    public function show(Pagamentos $pagamentos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Pagamentos  $pagamentos
     * @return \Illuminate\Http\Response
     */
    public function edit(Pagamentos $pagamentos)
    {
        return view('modulos.finances.pagamentos.edit',compact('pagamentos'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pagamentos  $pagamentos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pagamentos $pagamentos)
    {
        $request->validate([
            'fornecedor' => 'required|string|regex:/^[\p{L}\s-]+$/|max:255',
            'notafiscal' => 'required|unique:pagamentos',
            'valor' => 'required|numeric',
            'codFornecedor' => 'required|numeric',
            'descricao' => 'required|alpha',
            'cddespesa' => 'required|numeric',
            'operacao' => 'required|numeric',
            'datacompetencia' => 'required'
        ]);

        $pagamentos->update($request->all());

        return redirect()->route('pagamentos.index')
                        ->with('success','Atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pagamentos  $pagamentos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pagamentos $pagamentos)
    {
        $pagamentos->delete();

        return redirect()->route('pagamentos.index')->with('message','Lançamento excluído com sucesso.')->withErrors('message','erro ao excluir');
    }
}
