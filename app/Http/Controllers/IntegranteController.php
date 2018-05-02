<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Integrante;
use App\Proyecto;
use App\User;

class IntegranteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('agregar');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $integrante= new Integrante();
        $integrante->id_usuario=$request->get('id_usuario');
        $integrante->id_proyecto=$request->get('id_proyecto');
        $integrante->leer=$request->get('leer');
        $integrante->escribir=$request->get('escribir');
        $integrante->save();
        
        return redirect('/agregar')->with('success', 'Information has been added');
    }

    public function index($id)
    {
        $proyecto=Proyecto::find($id);
        $usuarios = $proyecto->integrantes->toArray();
        $dueno = $proyecto->dueño;
        array_push($usuarios, $dueno);
        return view('usuarios',compact('usuarios', 'dueno', 'proyecto'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function borrar($usuario, $proyecto)
    {
        $user = User::find($usuario);
        $user->miembroDe()->detach($proyecto);
        return redirect('project/'.$proyecto.'/members');
    }
}
