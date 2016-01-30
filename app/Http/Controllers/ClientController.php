<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;

use CodeProject\Http\Requests;
use CodeProject\Http\Controllers\Controller;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return \CodeProject\Client::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (\CodeProject\Client::create($request->all()))
        {
            return 'Inserido com sucesso!';
        }
        return 'Ocorreu um erro durante a inserção';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return \CodeProject\Client::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
         if ($produto = \CodeProject\Client::find($id)->update($request->all()))
         {
            return 'Alterado com sucesso';
         }
         return 'Não foi possivel gravar a alteração';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (\CodeProject\Client::find($id)->delete())
        {
            return 'Exclusão com sucesso!';
        }
        return 'Um erro ocorreu durante a exclusão!';
    }
}
