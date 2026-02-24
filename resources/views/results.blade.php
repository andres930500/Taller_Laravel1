<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados del Taller</title>
    @vite(['resources/css/app.css'])
</head>
<body class="bg-slate-100 p-6 md:p-12">
    <div class="max-w-4xl mx-auto space-y-6">
        
        <div class="flex justify-between items-center border-b-2 border-slate-300 pb-4">
            <h1 class="text-3xl font-black text-slate-800">📊 Reporte de Resultados</h1>
            <a href="{{ route('home') }}" class="bg-slate-200 px-4 py-2 rounded-lg font-bold hover:bg-slate-300 transition">Volver</a>
        </div>

        {{-- SECCIÓN ACADÉMICA --}}
        @if($students)
        <div class="bg-white p-6 rounded-xl shadow-lg border-t-4 border-indigo-500">
            <h2 class="text-xl font-bold text-indigo-700 mb-4 flex items-center">
                <span class="mr-2">🎓</span> Resultado Académico
            </h2>

            @if(isset($students['hardestCarrera']))
                <div class="bg-indigo-50 p-6 rounded-lg text-center">
                    <p class="text-xs text-indigo-600 font-bold uppercase tracking-wider">Carrera con mayor dificultad académica</p>
                    <p class="text-3xl font-black text-indigo-900 mt-2">{{ $students['hardestCarrera'] }}</p>
                </div>
            @endif

            @if(isset($students['averages']))
                <div class="bg-slate-50 p-4 rounded-lg border">
                    <p class="text-xs text-slate-500 font-bold uppercase mb-4 border-b pb-2">Promedios Calculados</p>
                    <div class="space-y-2">
                        @foreach($students['averages'] as $carrera => $avg)
                            <div class="flex justify-between items-center border-b border-slate-200 last:border-0 py-2">
                                <span class="text-slate-700 font-medium">{{ $carrera }}</span>
                                <span class="font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-lg text-lg">{{ number_format($avg, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(isset($students['topStudents']))
                <p class="font-bold text-slate-700 mb-3 text-sm italic">Estudiantes sobre el promedio de su carrera:</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($students['topStudents'] as $student)
                        <div class="bg-emerald-50 border border-emerald-100 p-3 rounded-lg flex justify-between items-center">
                            <div>
                                <p class="text-emerald-900 font-bold">{{ $student['nombre'] }}</p>
                                <p class="text-xs text-emerald-600">{{ $student['carrera'] }}</p>
                            </div>
                            <span class="bg-emerald-500 text-white font-bold px-2 py-1 rounded text-sm">
                                {{ number_format($student['calificacion'], 1) }}
                            </span>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
        @endif

        {{-- SECCIÓN DE LOGÍSTICA (DINÁMICA) --}}
        @if($shipments)
        <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-orange-500">
            <h2 class="text-xl font-bold text-orange-700 mb-4">🚚 Resultado de Logística</h2>
            <div class="flex flex-col items-center justify-center py-4">
                
                @if(isset($shipments['totalCostEntregados']))
                    <div class="text-center">
                        <p class="text-xs font-bold text-orange-600 uppercase tracking-widest">Costo Total de Envíos Entregados</p>
                        <p class="text-5xl font-black text-slate-800 mt-2">${{ number_format($shipments['totalCostEntregados'], 0) }}</p>
                    </div>
                @endif

                @if(isset($shipments['topCity']))
                    <div class="text-center">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Ciudad con mayor peso recibido</p>
                        <p class="text-5xl font-black text-orange-600 mt-2">{{ $shipments['topCity'] }}</p>
                    </div>
                @endif

                @if(isset($shipments['topCarrier']))
                    <div class="text-center">
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest">Transportista con más entregas</p>
                        <p class="text-5xl font-black text-green-700 mt-2">{{ $shipments['topCarrier'] }}</p>
                    </div>
                @endif

            </div>
        </div>
        @endif

        {{-- SECCIÓN FINANCIERA Y MATEMÁTICA --}}
        @if($salary || $velocity)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @if($salary)
            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-green-500">
                <h2 class="text-lg font-bold text-green-700 mb-2">💵 Salario Neto</h2>
                <p class="text-3xl font-black text-green-600">${{ number_format($salary['net'], 0) }}</p>
                <p class="text-xs text-slate-400 mt-1 italic uppercase">Deducciones (8%): ${{ number_format($salary['deductions'], 0) }}</p>
            </div>
            @endif

            @if($velocity)
            <div class="bg-white p-6 rounded-xl shadow-lg border-l-4 border-blue-500">
                <h2 class="text-lg font-bold text-blue-700 mb-2">⚡ Velocidad</h2>
                <p class="text-3xl font-black text-blue-600">{{ $velocity }} <span class="text-sm">m/s</span></p>
                <p class="text-xs text-slate-400 mt-1 italic uppercase">Calculado desde {{ request('speed') }} Km/h</p>
            </div>
            @endif
        </div>
        @endif

        {{-- BOTÓN PDF ACTUALIZADO --}}
        <div class="pt-6">
            <form action="{{ route('taller.pdf') }}" method="POST">
                @csrf
                {{-- CAMBIO CLAVE: Enviamos la acción para que el PDF sepa qué filtrar --}}
                <input type="hidden" name="action" value="{{ $action }}">
                
                @if($salary) <input type="hidden" name="salary" value="{{ request('salary') }}"> @endif
                @if($velocity) <input type="hidden" name="speed" value="{{ request('speed') }}"> @endif

                <button type="submit" class="w-full bg-red-600 text-white py-4 rounded-xl font-bold hover:bg-red-700 transition shadow-lg flex justify-center items-center gap-2">
                    <span>📄</span> Descargar Reporte de este Módulo (PDF)
                </button>
            </form>
        </div>

    </div>
</body>
</html>