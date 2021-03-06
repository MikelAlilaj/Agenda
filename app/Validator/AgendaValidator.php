<?php

namespace  App\Validator;

use Illuminate\Http\Request;

class AgendaValidator
{
    /**
     * Validate agenda Information Schema
     *
     * @param $request
     * @return response
     */
    public function validateAgenda(Request $request)
    {
        return $request->validate(
            [
                'name' => 'required',
                'description' => 'required',
                'status' => 'required|integer',
                'date' => 'required|date',
            ]
        );
    }

    /**
     * Validate Partner Information Schema
     *
     * @param $request
     * @return response
     */
    public function validateImportAgenda(Request $request)
    {
        return $request->validate(
            [
                '*.name' => 'required',
                '*.description' => 'required',
                '*.status' => 'required|integer',
                '*.date' => 'required|date',
            ]
        );
    }

}
