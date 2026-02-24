<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AnalyzerService;
use App\Models\CalculadoraProceso; 
use Barryvdh\DomPDF\Facade\Pdf;

class DashboardController extends Controller {

    protected AnalyzerService $analyzer;

    public function __construct(AnalyzerService $analyzer) {
        $this->analyzer = $analyzer;
    }

    public function index() {
        $customStudents = session()->get('students_custom', []);
        $customShipments = session()->get('shipments_custom', []);
        return view('welcome', compact('customStudents', 'customShipments'));
    }

    public function storeData(Request $request) {
        $type = $request->input('type');
        $sessionKey = ($type === 'student') ? 'students_custom' : 'shipments_custom';
        
        $data = session()->get($sessionKey, []);
        $newItem = $request->except(['_token', 'type']);
        $newItem['id'] = uniqid();
        
        $data[] = $newItem;
        session()->put($sessionKey, $data);
        
        return back()->with('success', 'Registro agregado correctamente');
    }

    public function deleteData($type, $id) {
        $sessionKey = ($type === 'student') ? 'students_custom' : 'shipments_custom';
        $data = session()->get($sessionKey, []);
        $filtered = array_filter($data, fn($item) => $item['id'] !== $id);
        
        session()->put($sessionKey, array_values($filtered));
        return back()->with('success', 'Registro eliminado correctamente');
    }

    public function process(Request $request) {
        $action = $request->input('action');
        
        $this->analyzer->setCustomData(
            session()->get('students_custom', []),
            session()->get('shipments_custom', [])
        );

        $studentResults = null;
        $shipmentResults = null;
        $salaryData = null;
        $velocity = null;

        switch ($action) {
            case 'avg_carrera':
                $studentResults = ['averages' => $this->analyzer->getAverages()];
                break;
            case 'hardest_carrera':
                $studentResults = ['hardestCarrera' => $this->analyzer->getHardestCarrera()];
                break;
            case 'top_students':
                $studentResults = ['topStudents' => $this->analyzer->getTopStudents()];
                break;
            case 'shipment_cost':
                $shipmentResults = ['totalCostEntregados' => $this->analyzer->getTotalCostEntregados()];
                break;
            case 'shipment_weight':
                $shipmentResults = ['topCity' => $this->analyzer->getCityWithMostWeight()];
                break;
            case 'shipment_carrier':
                $shipmentResults = ['topCarrier' => $this->analyzer->getTopCarrier()];
                break;
            case 'math':
              
                $salaryData = CalculadoraProceso::calcularSalarioNeto((float)$request->input('salary', 0));
                $velocity = CalculadoraProceso::convertirVelocidad((float)$request->input('speed', 0));
                break;
        }

        return view('results', [
            'students' => $studentResults,
            'shipments' => $shipmentResults,
            'salary' => $salaryData,
            'velocity' => $velocity,
            'action' => $action,
            'allData' => $request->all()
        ]);
    }

    public function downloadPdf(Request $request) {
        $action = $request->input('action');
        
        $this->analyzer->setCustomData(
            session()->get('students_custom', []),
            session()->get('shipments_custom', [])
        );

        $students = null;
        $shipments = null;
        $salary = null;
        $velocity = null;

        if (in_array($action, ['avg_carrera', 'hardest_carrera', 'top_students'])) {
            $students = [
                'averages' => $this->analyzer->getAverages(),
                'hardestCarrera' => $this->analyzer->getHardestCarrera(),
                'topStudents' => $this->analyzer->getTopStudents(),
            ];
        } 
        elseif (in_array($action, ['shipment_cost', 'shipment_weight', 'shipment_carrier'])) {
            $shipments = [
                'totalCostEntregados' => $this->analyzer->getTotalCostEntregados(),
                'topCity' => $this->analyzer->getCityWithMostWeight(),
                'topCarrier' => $this->analyzer->getTopCarrier(),
            ];
        } 
        elseif ($action === 'math') {
           
            $salary = $request->filled('salary') ? CalculadoraProceso::calcularSalarioNeto((float)$request->input('salary')) : null;
            $velocity = $request->filled('speed') ? CalculadoraProceso::convertirVelocidad((float)$request->input('speed')) : null;
        }

        $data = [
            'students' => $students,
            'shipments' => $shipments,
            'salary' => $salary,
            'velocity' => $velocity,
            'date' => now()->format('d/m/Y H:i A'),
            'action' => $action
        ];

        $pdf = Pdf::loadView('pdf_report', $data);
        return $pdf->download('reporte-' . ($action ?? 'analisis') . '.pdf');
    }
}