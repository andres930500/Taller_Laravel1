<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taller PHP Avanzado Andres Gonzalez lopez - Laravel 12</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Estilos para centrar el diálogo y animarlo */
        dialog {
            border: none;
            outline: none;
        }
        
        /* Posicionamiento central absoluto */
        dialog[open] {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            margin: 0;
            animation: fadeIn 0.3s ease-out;
        }

        /* Animación de entrada */
        @keyframes fadeIn {
            from { opacity: 0; transform: translate(-50%, -45%) scale(0.95); }
            to { opacity: 1; transform: translate(-50%, -50%) scale(1); }
        }

        /* Oscurecer el fondo */
        dialog::backdrop {
            background-color: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(4px);
        }
    </style>
</head>
<body class="bg-gray-50 font-sans antialiased">
    <div class="max-w-5xl mx-auto py-12 px-4">

        <header class="mb-10 text-center">
            <h1 class="text-4xl font-extrabold tracking-tight text-slate-800">Taller PHP Avanzado</h1>
            <p class="text-lg text-gray-600">Gestión de Datos y Análisis Dinámico</p>
        </header>

        <div class="space-y-12">
            
            {{-- SECCIÓN 1: ESTUDIANTES --}}
            <section class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-indigo-600 flex items-center">
                        <span class="mr-2">🎓</span> 1. Análisis de Estudiantes
                    </h2>
                    <button onclick="document.getElementById('modalEstudiante').showModal()" class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-indigo-700 transition flex items-center gap-2 text-sm">
                        <span>➕</span> Ingresar Dato
                    </button>
                </div>

                <div class="mb-6 overflow-hidden border border-slate-200 rounded-lg shadow-inner">
                    <table class="w-full text-left bg-slate-50">
                        <thead class="bg-slate-100 text-slate-600 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-6 py-3">Nombre Estudiante</th>
                                <th class="px-6 py-3">Carrera</th>
                                <th class="px-6 py-3 text-center">Calificación</th>
                                <th class="px-6 py-3 text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-200">
                            @forelse($customStudents as $s)
                            <tr class="hover:bg-white transition-colors bg-indigo-50/30">
                                <td class="px-6 py-3 font-medium text-slate-700">{{ $s['nombre'] }}</td>
                                <td class="px-6 py-3 text-slate-600">{{ $s['carrera'] }}</td>
                                <td class="px-6 py-3 text-center font-bold text-indigo-600">{{ number_format($s['calificacion'], 1) }}</td>
                                <td class="px-6 py-3 text-right">
                                    <a href="{{ route('data.delete', ['type' => 'student', 'id' => $s['id']]) }}" class="text-red-500 hover:text-red-700 font-bold">Eliminar</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-slate-400 italic">No hay datos. Usa "Ingresar Dato".</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <form action="{{ route('taller.procesar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="avg_carrera">
                        <button type="submit" class="w-full bg-indigo-50 border border-indigo-200 text-indigo-700 font-semibold py-3 px-4 rounded-xl hover:bg-indigo-600 hover:text-white transition-all">📊 Promedios</button>
                    </form>
                    <form action="{{ route('taller.procesar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="hardest_carrera">
                        <button type="submit" class="w-full bg-slate-50 border border-slate-200 text-slate-700 font-semibold py-3 px-4 rounded-xl hover:bg-slate-800 hover:text-white transition-all">📉 Más Difícil</button>
                    </form>
                    <form action="{{ route('taller.procesar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="top_students">
                        <button type="submit" class="w-full bg-emerald-50 border border-emerald-200 text-emerald-700 font-semibold py-3 px-4 rounded-xl hover:bg-emerald-600 hover:text-white transition-all">🏆 Estudiantes Top</button>
                    </form>
                </div>
            </section>

            {{-- SECCIÓN 2: ENVÍOS --}}
            <section class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-bold text-orange-600 flex items-center">
                        <span class="mr-2">🚚</span> 2. Control de Envíos
                    </h2>
                    <button onclick="document.getElementById('modalEnvio').showModal()" class="bg-orange-600 text-white px-4 py-2 rounded-lg font-bold hover:bg-orange-700 transition flex items-center gap-2 text-sm">
                        <span>➕</span> Ingresar Dato
                    </button>
                </div>

                <div class="mb-6 overflow-x-auto border border-slate-200 rounded-lg shadow-inner">
                    <table class="w-full text-left bg-slate-50">
                        <thead class="bg-slate-100 text-slate-600 text-xs uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-2">Ciudad</th>
                                <th class="px-4 py-2">Transportista</th>
                                <th class="px-4 py-2 text-center">Peso</th>
                                <th class="px-4 py-2">Estado</th>
                                <th class="px-4 py-2 text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-200">
                            @forelse($customShipments as $envio)
                            <tr class="bg-orange-50/30">
                                <td class="px-4 py-2 font-medium">{{ $envio['ciudad'] }}</td>
                                <td class="px-4 py-2">{{ $envio['transportista'] }}</td>
                                <td class="px-4 py-2 text-center">{{ $envio['peso'] }}kg</td>
                                <td class="px-4 py-2 font-bold {{ $envio['estado'] == 'Entregado' ? 'text-green-600' : 'text-blue-600' }}">{{ $envio['estado'] }}</td>
                                <td class="px-4 py-2 text-right">
                                    <a href="{{ route('data.delete', ['type' => 'shipment', 'id' => $envio['id']]) }}" class="text-red-500 font-bold">Eliminar</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-slate-400 italic">Sin registros de envíos.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <form action="{{ route('taller.procesar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="shipment_cost">
                        <button type="submit" class="w-full bg-orange-50 border border-orange-200 text-orange-700 font-semibold py-3 px-4 rounded-xl hover:bg-orange-600 hover:text-white transition-all">💰 Costos</button>
                    </form>
                    <form action="{{ route('taller.procesar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="shipment_weight">
                        <button type="submit" class="w-full bg-orange-50 border border-orange-200 text-orange-700 font-semibold py-3 px-4 rounded-xl hover:bg-orange-600 hover:text-white transition-all">⚖️ Mayor Peso</button>
                    </form>
                    <form action="{{ route('taller.procesar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="action" value="shipment_carrier">
                        <button type="submit" class="w-full bg-orange-50 border border-orange-200 text-orange-700 font-semibold py-3 px-4 rounded-xl hover:bg-orange-600 hover:text-white transition-all">🏆 Estrella</button>
                    </form>
                </div>
            </section>

            {{-- SECCIÓN MATEMÁTICA --}}
            <form action="{{ route('taller.procesar') }}" method="POST">
                @csrf
                <input type="hidden" name="action" value="math">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <section class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                        <h2 class="text-xl font-bold mb-4 text-green-600 italic">💰 Salario Neto</h2>
                        <input type="number" name="salary" required class="block w-full rounded-lg border-gray-300 shadow-sm border p-3 text-green-700 font-bold focus:ring-green-500" placeholder="Ej: 2000000">
                    </section>

                    <section class="bg-white p-6 rounded-xl shadow-sm border border-gray-200">
                        <h2 class="text-xl font-bold mb-4 text-blue-600 italic">⚡ Velocidad</h2>
                        <input type="number" name="speed" required class="block w-full rounded-lg border-gray-300 shadow-sm border p-3 text-blue-700 font-bold focus:ring-blue-500" placeholder="Ej: 100">
                    </section>
                </div>
                <div class="mt-8 flex justify-center">
                    <button type="submit" class="bg-slate-800 hover:bg-black text-white font-bold py-4 px-12 rounded-full transition shadow-xl transform hover:scale-105 flex items-center">
                        <span class="mr-2">🚀</span> Ejecutar Cálculos
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL ESTUDIANTE --}}
    <dialog id="modalEstudiante" class="rounded-2xl p-0 shadow-2xl">
        <div class="p-6 w-96 bg-white border border-slate-200 rounded-2xl">
            <h3 class="text-xl font-black mb-4 text-indigo-700">Nuevo Estudiante</h3>
            <form action="{{ route('data.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="type" value="student">
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-500">Nombre</label>
                    <input type="text" name="nombre" class="w-full border p-2 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" required>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-500">Carrera</label>
                    <select name="carrera" class="w-full border p-2 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none">
                        <option>Ingeniería</option>
                        <option>Medicina</option>
                        <option>Artes</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold uppercase text-slate-500">Calificación (0.0 - 5.0)</label>
                    <input type="number" step="0.1" max="5" min="0" name="calificacion" class="w-full border p-2 rounded-lg focus:ring-2 focus:ring-indigo-500 outline-none" required>
                </div>
                <div class="flex gap-2 pt-2">
                    <button type="button" onclick="this.closest('dialog').close()" class="flex-1 bg-slate-100 py-2 rounded-lg font-bold text-slate-600 hover:bg-slate-200 transition">Cancelar</button>
                    <button type="submit" class="flex-1 bg-indigo-600 py-2 rounded-lg font-bold text-white hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">Guardar</button>
                </div>
            </form>
        </div>
    </dialog>

    {{-- MODAL ENVÍO --}}
    <dialog id="modalEnvio" class="rounded-2xl p-0 shadow-2xl">
        <div class="p-6 w-96 bg-white border border-slate-200 rounded-2xl">
            <h3 class="text-xl font-black mb-4 text-orange-700">Nuevo Envío</h3>
            <form action="{{ route('data.store') }}" method="POST" class="space-y-4">
                @csrf
                <input type="hidden" name="type" value="shipment">
                <input type="text" name="ciudad" placeholder="Ciudad Destino" class="w-full border p-2 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none" required>
                <input type="text" name="transportista" placeholder="Nombre Transportista" class="w-full border p-2 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none" required>
                <div class="flex gap-2">
                    <input type="number" step="0.1" name="peso" placeholder="Peso kg" class="w-1/2 border p-2 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none" required>
                    <input type="number" name="costo_kg" placeholder="Costo/kg" class="w-1/2 border p-2 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none" required>
                </div>
                <select name="estado" class="w-full border p-2 rounded-lg focus:ring-2 focus:ring-orange-500 outline-none">
                    <option value="Entregado">Entregado</option>
                    <option value="En ruta">En ruta</option>
                    <option value="Pendiente">Pendiente</option>
                </select>
                <div class="flex gap-2 pt-2">
                    <button type="button" onclick="this.closest('dialog').close()" class="flex-1 bg-slate-100 py-2 rounded-lg font-bold text-slate-600 hover:bg-slate-200 transition">Cancelar</button>
                    <button type="submit" class="flex-1 bg-orange-600 py-2 rounded-lg font-bold text-white hover:bg-orange-700 transition shadow-lg shadow-orange-200">Guardar</button>
                </div>
            </form>
        </div>
    </dialog>

</body>
</html>