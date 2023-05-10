<?php

namespace App\Http\Controllers;

use App\Http\Requests\MainRequest;
use App\Http\Services\MainService;
use Illuminate\Http\Request;



class MainController extends Controller
{



    /**
     * 
     * 
     */
    public function index()
    {

        return view('welcome');

    }




    /**
     * 
     * 
     */
    public function project()
    {

        return view('project');

    }




    /**
     * 
     * 
     */
    public function cool()
    {

        $n = 'numero';

        $minimo = 'minimo';
        $maximo = 'maximo';


        return view(
            'cool',
            compact(
                'n',
                'minimo',
                'maximo',
            )
        );

    }





    /**
     * 
     * 
     */
    public function ejecutar(MainRequest $request)
    {

        $n      = $request->input('n');

        $minimo = $request->input('minimo');
        $maximo = $request->input('maximo');
        $float  = ! $request->input('float') ?? false;

        $numerosGenerados = (new MainService())->generarNumerosAleatorios(
            $n,
            $minimo,
            $maximo,
            $float
        );

        $testAleatoriedadMonoBits = (new MainService())->ejecutarTestAleatoriedadMonoBits(
            $numerosGenerados,
            $minimo,
            $maximo
        );

        // dd($numerosGenerados , $testAleatoriedadMonoBitsAprobado);

        return view(
            'test-aleatoriedad',
            [
                'resultado'         => $testAleatoriedadMonoBits['resultado'],
                'sumatoriaValores'  => $testAleatoriedadMonoBits['sumatoriaValores'],
                'resultadoERFC'     => $testAleatoriedadMonoBits['resultadoERFC'],
                'arrayConvertido'   => $testAleatoriedadMonoBits['arrayConvertido'],
                'cantidadMenosUnos' => $testAleatoriedadMonoBits['cantidadMenosUnos'],
                'cantidadUnos'      => $testAleatoriedadMonoBits['cantidadUnos'],
            ]
        )->with(compact(
            'n',
            'minimo',
            'maximo',
            'numerosGenerados'
        ));

    }


}
