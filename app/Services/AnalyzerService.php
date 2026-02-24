<?php

namespace App\Services;

class AnalyzerService {
    
    /**
     * Arreglos inicializados vacíos.
     */
    protected array $students = [];
    protected array $shipments = [];

    /**
     * Sincroniza los datos de la sesión con las propiedades de la clase.
     */
    public function setCustomData(array $customStudents, array $customShipments): void {
        $this->students = $customStudents;
        $this->shipments = $customShipments;
    }

    // --- MÉTODOS PUNTO 1 (ESTUDIANTES) ---

    public function getAverages(): array {
        return collect($this->students)
            ->groupBy('carrera')
            ->map(fn($group) => $group->avg('calificacion'))
            ->toArray();
    }

    public function getHardestCarrera(): string {
        $averages = collect($this->getAverages());
        if ($averages->isEmpty()) return 'Sin datos';
        
        return $averages->sort()->keys()->first();
    }

    public function getTopStudents(): array {
        $averages = $this->getAverages();
        return collect($this->students)->filter(function($student) use ($averages) {
            return $student['calificacion'] > ($averages[$student['carrera']] ?? 0);
        })->values()->toArray();
    }

    // --- MÉTODOS PUNTO 2 (ENVÍOS) ---

    public function getShipments(): array {
        return $this->shipments;
    }

    public function getTotalCostEntregados(): float {
        return collect($this->shipments)
            ->where('estado', 'Entregado')
            ->sum(fn($s) => (float)$s['peso'] * (float)($s['costo_kilo'] ?? $s['costo_kg'] ?? 0));
    }

    public function getCityWithMostWeight(): string {
        $result = collect($this->shipments)
            ->groupBy('ciudad')
            ->map(fn($group) => $group->sum('peso'))
            ->sortDesc()
            ->keys()
            ->first();
            
        return $result ?? 'Sin datos';
    }

    public function getTopCarrier(): string {
        $result = collect($this->shipments)
            ->where('estado', 'Entregado')
            ->groupBy('transportista')
            ->map(fn($group) => $group->count())
            ->sortDesc()
            ->keys()
            ->first();
            
        return $result ?? 'Sin datos';
    }

}