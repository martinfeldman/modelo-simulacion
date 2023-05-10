<?php

namespace App\Http\Services;





class MainService
{



    /**
     *  
     *  
     */
    public function generarNumerosAleatorios(
        int     $n      = 10,
        float   $minimo = 1,
        float   $maximo = 1000,
        bool    $float  = true)
    {

        $decimals = 2;

        $numerosGenerados = [];

        for ($i = 0; $i < $n; $i++) {

            $numeroGenerado = $float
                            ? rand($minimo * 100, $maximo * 100) / 100
                            : rand($minimo, $maximo);

            $numerosGenerados[] = $float
                            ? round($numeroGenerado, $decimals)
                            : $numeroGenerado;

        }

        return $numerosGenerados;

    }




    public function ejecutarTestAleatoriedadMonoBits(
        $numerosGenerados,
        $minimo,
        $maximo)
    {
        
        // Convertir los números del array en 1 y -1
        $arrayConvertido = [];

        foreach ($numerosGenerados as $numero) {
            $arrayConvertido[] = $numero > (($minimo + $maximo)/2) ? 1 : -1;
        }
        

        $sumatoria_valores = array_sum($arrayConvertido);

        $resultadoERFC = self::erfc($sumatoria_valores / sqrt(2));



        $cantidadMenosUnos = 0;
        $cantidadUnos = 0;

        foreach ($arrayConvertido as $valor) {
            if ($valor == -1) {
                $cantidadMenosUnos++;
            } elseif ($valor == 1) {
                $cantidadUnos++;
            }
        }

        return [
            'resultado'         => $resultadoERFC > 0.01,
            'sumatoriaValores'  => $sumatoria_valores,
            'resultadoERFC'     => $resultadoERFC,
            'arrayConvertido'   => $arrayConvertido,
            'cantidadMenosUnos' => $cantidadMenosUnos,
            'cantidadUnos'      => $cantidadUnos
        ];
        

    }













    // * Funciones matemáticas, wuh!
    // * Funciones matemáticas, wuh!
    // * Funciones matemáticas, wuh!

    public static function errorFunction(float $x): float
    {
        if ($x == 0) {
            return 0;
        }

        $p  = 0.3275911;
        $t  = 1 / ( 1 + $p * \abs($x) );

        $a₁ = 0.254829592;
        $a₂ = -0.284496736;
        $a₃ = 1.421413741;
        $a₄ = -1.453152027;
        $a₅ = 1.061405429;

        $error = 1 - ( $a₁ * $t + $a₂ * $t ** 2 + $a₃ * $t ** 3 + $a₄ * $t ** 4 + $a₅ * $t ** 5 ) * \exp(-\abs($x) ** 2);

        return ( $x > 0 ) ? $error : -$error;
    }




    public static function erf(float $x): float
    {
        return self::errorFunction($x);
    }



    public static function erfc(float $x): float
    {
        return 1 - self::erf($x);
    }

}