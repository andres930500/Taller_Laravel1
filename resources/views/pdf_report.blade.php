<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte Taller PHP</title>
    <style>
        body { font-family: sans-serif; color: #333; line-height: 1.4; }
        .header { text-align: center; border-bottom: 2px solid #4f46e5; padding-bottom: 10px; margin-bottom: 20px; }
        .section-title { background: #f1f5f9; padding: 8px 12px; font-weight: bold; margin-top: 25px; border-left: 5px solid #4f46e5; color: #1e293b; text-transform: uppercase; font-size: 14px; }
        .summary-box { border: 1px solid #e2e8f0; padding: 15px; margin-top: 10px; border-radius: 5px; background-color: #fcfcfc; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #e2e8f0; padding: 10px; text-align: left; font-size: 12px; }
        th { background: #f8fafc; color: #64748b; font-weight: bold; }
        .highlight { font-weight: bold; color: #4f46e5; font-size: 14px; }
        .text-green { color: #16a34a; font-weight: bold; }
        .footer { margin-top: 30px; text-align: center; font-size: 10px; color: #94a3b8; border-top: 1px solid #e2e8f0; padding-top: 10px; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Reporte de Resultados</h1>
        <small>Módulo: <strong>{{ strtoupper(str_replace('_', ' ', $action)) }}</strong></small><br>
        <small>Generado el: {{ $date }}</small>
    </div>

    {{-- SECCIÓN ACADÉMICA: Solo aparece si hay datos de estudiantes --}}
    @if($students)
        <div class="section-title">Análisis Académico</div>
        <div class="summary-box">
            <p><strong>Carrera de mayor dificultad:</strong> <span class="highlight">{{ $students['hardestCarrera'] }}</span></p>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Carrera Universitaria</th>
                    <th>Promedio Calificación</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students['averages'] as $carrera => $avg)
                <tr>
                    <td>{{ $carrera }}</td>
                    <td class="highlight">{{ number_format($avg, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if(isset($students['topStudents']) && count($students['topStudents']) > 0)
            <p style="font-size: 11px; margin-top: 15px; color: #475569;"><strong>Estudiantes Destacados (Sobre el promedio):</strong></p>
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Carrera</th>
                        <th>Calificación</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($students['topStudents'] as $student)
                    <tr>
                        <td>{{ $student['nombre'] }}</td>
                        <td>{{ $student['carrera'] }}</td>
                        <td class="text-green">{{ number_format($student['calificacion'], 1) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif

    {{-- SECCIÓN LOGÍSTICA: Solo aparece si hay datos de envíos --}}
    @if($shipments)
        <div class="section-title">Logística de Envíos</div>
        <table>
            <thead>
                <tr>
                    <th>Concepto</th>
                    <th>Resultado</th>
                </tr>
            </thead>
            <tbody>
                @if(isset($shipments['totalCostEntregados']))
                <tr>
                    <td>Costo Total (Entregados)</td>
                    <td class="highlight">${{ number_format($shipments['totalCostEntregados'], 0) }}</td>
                </tr>
                @endif
                
                @if(isset($shipments['topCity']))
                <tr>
                    <td>Ciudad con Mayor Peso</td>
                    <td class="highlight">{{ $shipments['topCity'] }}</td>
                </tr>
                @endif

                @if(isset($shipments['topCarrier']))
                <tr>
                    <td>Transportista Estrella</td>
                    <td class="text-green">{{ $shipments['topCarrier'] }}</td>
                </tr>
                @endif
            </tbody>
        </table>
    @endif

    {{-- SECCIÓN MATEMÁTICA: Solo aparece si hay datos de salario o velocidad --}}
    @if($salary || $velocity)
        <div class="section-title">Cálculos Financieros y Conversiones</div>
        <div class="summary-box">
            @if($salary)
                <p><strong>Salario Neto:</strong> <span class="highlight">${{ number_format($salary['net'], 0) }}</span></p>
                <p style="font-size: 11px; color: #64748b;">Deducciones aplicadas (8%): ${{ number_format($salary['deductions'], 0) }}</p>
            @endif
            
            @if($velocity)
                <p style="margin-top: 10px;"><strong>Velocidad convertida:</strong> <span class="highlight">{{ $velocity }} m/s</span></p>
                <p style="font-size: 11px; color: #64748b;">Dato original: {{ request('speed') }} Km/h</p>
            @endif
        </div>
    @endif

    <div class="footer">
        Este documento es un reporte automático generado por el Sistema de Análisis Laravel 12.
    </div>

</body>
</html>