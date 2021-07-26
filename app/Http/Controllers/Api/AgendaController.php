<?php

namespace App\Http\Controllers\Api;

use App\Models\Agenda;
use Exception;
use Illuminate\Http\Request;
use App\Validator\AgendaValidator;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
            $agenda = new Agenda();
            $agenda->name = $inputs['name'];
            $agenda->description = $inputs['description'];
            $agenda->status = $inputs['status'];
            $agenda->date = date("Y-m-d", strtotime($inputs['date']));
            $agenda->created_at = date("Y-m-d H:i:s");
            if ($agenda->save()) {
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
        try {
            $agenda = Agenda::find($id);
            if (!$agenda)  throw new ModelNotFoundException('Agenda not found');
            return response()->json([
                'agenda' => $agenda
            ], 200);
        } catch (ModelNotFoundException $e) {
            abort(
                response()->json(['message' => $e->getMessage()], 404)
            );
        } catch (Exception $e) {
            abort(response()->json(['message' => 'Internal server error'], 500));
        }
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


        try {
            $inputs = $this->agendaValidator->validateAgenda($request);
            $agenda = Agenda::findOrFail($id);
            $agenda->name = $inputs['name'];
            $agenda->description = $inputs['description'];
            $agenda->status = $inputs['status'];
            $agenda->date = date("Y-m-d", strtotime($inputs['date']));
            $agenda->created_at = date("Y-m-d H:i:s");
            if ($agenda->save()) {
                return response()->json([
                    'message' => 'Success',
                ], 200);
            }
        } catch (Exception $e) {
            // dd($e);
            abort(response()->json(['message' => $e], 500));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $agenda = Agenda::find($id);
            if (!$agenda)  throw new ModelNotFoundException('Agenda not found');
            if ($agenda->delete()) {
                return response()->json([
                    'message' => 'Success',
                ], 200);
            }
        } catch (ModelNotFoundException $e) {
            abort(
                response()->json(['message' => $e->getMessage()], 404)
            );
        } catch (Exception $e) {
            abort(response()->json(['message' => 'Internal server error'], 500));
        }
    }

    public function import(Request $request)
    {
        try {
            $inputs = $this->agendaValidator->validateImportAgenda($request);

            if(empty($inputs)){
                return response()->json([
                    'message' => 'Something went wrong',
                ], 500);
              }
            foreach ($inputs as $input) {

                $agenda = new Agenda();
                $agenda->name = $input['name'];
                $agenda->description = $input['description'];
                $agenda->status = $input['status'];
                $agenda->date = date("Y-m-d", strtotime($input['date']));
                $agenda->created_at = date("Y-m-d H:i:s");
                $agenda->save();
            }
            return response()->json([
                'message' => 'Success',
            ], 200);
        } catch (Exception $e) {
            abort(response()->json(['message' => 'Internal server error'], 500));
        }
    }
}
