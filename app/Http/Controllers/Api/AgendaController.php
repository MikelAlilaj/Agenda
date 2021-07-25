<?php

namespace App\Http\Controllers\Api;

use App\Models\Agenda;
use Exception;
use Illuminate\Http\Request;
use App\Validator\AgendaValidator;

class AgendaController
{
    /**
     * @var AgendaValidator
     */
    protected $agendaValidator;

    public function __construct(
        AgendaValidator  $agendaValidator
    ) {

        $this->agendaValidator = $agendaValidator;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $agendas = Agenda::all();
            return response()->json([
                'agendas' => $agendas
            ], 200);
        } catch (Exception $e) {
            abort(response()->json(['message' => 'Internal server error'], 500));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            $inputs = $this->agendaValidator->validateAgenda($request);


            $note = new Agenda();
            $note->name = $inputs['name'];
            $note->description = $inputs['description'];
            $note->status =$inputs['status'];
            $note->date = date("Y-m-d", strtotime($inputs['date']));
            // $note->date =$inputs['date'];
            $note->created_at=date("Y-m-d H:i:s");
           if($note->save()){
            return response()->json([
                'message' => 'Success',
            ], 200);
           }
        } catch (\Exception $e) {
            // dd($e);
            abort(response()->json(['message' => 'Something went wrong'], 500));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
