<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable = [
        'identidad',
        'nombre',
        'apellido',
        'cargo',
        'salario',
        'codigo_empleado',
        'fecha_ingreso',
    ];
    protected $casts = [
        'fecha_ingreso' => 'date',
    ];

    public static function reglas($id = null)
    {
        return [
            'identidad' => 'required|digits:13|unique:empleados,identidad,' . $id,
            'nombre' => 'required|max:255',
            'apellido' => 'required|max:255',
            'cargo' => 'required',
            'salario' => 'required|numeric|min:0|max:9999999',
            'codigo_empleado' => 'required|digits:13|unique:empleados,codigo_empleado,' . $id,
            'fecha_ingreso' => 'required|date',
        ];
    }
}