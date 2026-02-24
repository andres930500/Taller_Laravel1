# 📚 Taller PHP Avanzado - Laravel 12

Proyecto desarrollado para la asignatura de Programación PHP, aplicando conceptos de arquitectura MVC, servicios y manipulación de datos.

## 🚀 Requerimientos Implementados

### 1. Gestión de Estudiantes y Envíos
* **Análisis de Estudiantes:** Cálculo de promedios por carrera, identificación de la carrera con mayor dificultad y listado de alumnos destacados.
* **Logística de Envíos:** Cálculo de costos totales de entregas, peso acumulado por ciudad y estadísticas de transportistas.

### 2. Arquitectura y Lógica (MVC)
* **Modelo:** Clase `CalculadoraProceso` para lógica matemática pura.
* **Controlador:** `DashboardController` para la gestión de peticiones.
* **Servicios:** `AnalyzerService` para el procesamiento de colecciones de datos.

### 3. Operaciones Matemáticas (Punto 5)
* **Salario Neto:** Cálculo basado en deducciones de ley en Colombia (8%).
* **Conversión de Unidades:** Transformación de velocidad de Km/h a m/s.

### 4. Tecnologías y Librerías
* **Framework:** Laravel 12.
* **Frontend:** Tailwind CSS para un diseño usable y responsivo.
* **Generación de PDF:** Implementación de la librería `barryvdh/laravel-dompdf`.
* **Gestión de Dependencias:** Composer con autocarga PSR-4.

## 💻 Instalación Local
1. `git clone https://github.com/andres930500/Taller_Laravel1.git`
2. `composer install`
3. `cp .env.example .env`
4. `php artisan key:generate`
5. `php artisan serve`
