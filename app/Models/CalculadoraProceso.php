<?php

namespace App\Models;

class CalculadoraProceso {
    /**
     * Punto 5: Cálculo de salario neto (Deducciones de ley Colombia)
     */
    public static function calcularSalarioNeto(float $bruto): array {
        $salud = $bruto * 0.04;
        $pension = $bruto * 0.04;
        
        // Cambiamos las llaves para que coincidan con la vista
        return [
            'bruto' => $bruto,
            'deductions' => $salud + $pension, // Cambiado de 'deducciones'
            'net' => $bruto - ($salud + $pension) // Cambiado de 'neto'
        ];
    }

    /**
     * Punto 5: Conversión de unidades de velocidad (km/h a m/s)
     */
    public static function convertirVelocidad(float $kmh): float {
        return round($kmh / 3.6, 2);
    }
}   