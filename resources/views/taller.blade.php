<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taller PHP Avanzado Andres Gonzalez- Andres Gonzalez lopez</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-linear-to-br from-slate-100 to-slate-300 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white/80 backdrop-blur-md shadow-2xl rounded-3xl p-8 w-full max-w-lg border border-white">
        <h1 class="text-3xl font-black text-slate-800 mb-2 text-center">Taller PHP Avanzado</h1>
        <p class="text-slate-500 text-center mb-8 italic">Cristian Camilo Echeverri - 2026-1</p>

        <form action="/procesar-taller" method="POST" class="space-y-6">
            @csrf
            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                <h2 class="font-bold text-blue-600 mb-3 underline">Datos del Estudiante (Punto 1)</h2>
                <div class="space-y-3">
                    <input type="text" name="nombre" placeholder="Nombre completo" required 
                        class="w-full px-4 py-2 rounded-lg border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    
                    <div class="grid grid-cols-2 gap-3">
                        <input type="number" name="nota" step="0.1" placeholder="Nota (0.0 - 5.0)" required 
                            class="px-4 py-2 rounded-lg border-slate-300 focus:ring-2 focus:ring-blue-500 outline-none">
                        <select name="carrera" class="px-4 py-2 rounded-lg border-slate-300 outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="Sistemas">Sistemas</option>
                            <option value="Civil">Civil</option>
                            <option value="Industrial">Industrial</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-slate-50 p-4 rounded-xl border border-slate-200">
                <h2 class="font-bold text-green-600 mb-3 underline">Cálculo de Salario (Punto 5)</h2>
                <input type="number" name="salario_base" placeholder="Salario básico (ej: 2000000)" required 
                    class="w-full px-4 py-2 rounded-lg border-slate-300 focus:ring-2 focus:ring-green-500 outline-none">
            </div>

            <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg hover:shadow-blue-300 transition-all transform active:scale-95">
                GENERAR REPORTE PDF
            </button>
        </form>
    </div>

</body>
</html>