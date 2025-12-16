# 🎄 Sistema de Gestión Navideña - Navidad 2025

Este proyecto es una aplicación web completa desarrollada para la gestión de eventos navideños, específicamente para el registro de niños, entrega de regalos y control de asistencia mediante códigos QR.

![Estado del Proyecto](https://img.shields.io/badge/Estado-Terminado-success)
![Versión](https://img.shields.io/badge/Versión-1.0.0-blue)
![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1)

## 🚀 Características Principales

### 📋 Gestión de Niños
- Registro completo de niños (Nombre, Edad, Género).
- Base de datos optimizada para consultas rápidas.
- Interfaz amigable y festiva.

### 🪪 Carnets Digitales & QR
- **Generación automática de carnets** en formato PDF.
- Diseño "3x3" (9 por página) optimizado para impresión en A4 Horizontal.
- **Códigos QR únicos** para cada niño.
- Estilo visual premium ("Ticket Navideño") con distinción de género (👦/👧).

### 🤳 Control de Asistencia Inteligente
- **Escáner QR integrado** en la aplicación web.
- Registro de asistencia en tiempo real escaneando el carnet del niño.
- Feedback visual y auditivo al escanear (éxito/error).
- Prevención de doble registro (evita marcar asistencia dos veces el mismo día).

### 📊 Estadísticas y Reportes
- Dashboard con métricas en tiempo real (Total niños, Desglose por género, Asistencia hoy).
- Gráficos visuales con Chart.js.
- **Exportación de reportes a PDF** con diseño corporativo/navideño.

### 🕯️ Gestión de Novenas
- Módulo para gestionar el "Compartir" de las novenas.
- Asignación de responsabilidades y seguimiento.

## 🛠️ Tecnologías Utilizadas

- **Backend:** PHP (Arquitectura MVC personalizada).
- **Frontend:** HTML5, JavaScript (Vanilla).
- **Estilos:** Tailwind CSS (diseño moderno y responsivo).
- **Base de Datos:** MySQL.
- **Librerías Clave:**
  - `html5-qrcode`: Para el escaneo de códigos QR.
  - `html2pdf.js`: Para la generación de reportes y carnets en PDF.
  - `qrcode.js`: Para la generación de códigos QR estáticos.
  - `Chart.js`: Para visualización de datos.

## ⚙️ Instalación

1. **Clonar el repositorio** en tu carpeta de servidor web (ej. `htdocs` en XAMPP):
   ```bash
   git clone <url-del-repositorio> navidad
   ```

2. **Base de Datos**:
   - Crea una base de datos en MySQL llamada `navidad`.
   - Importa el archivo `database.sql` (si está disponible) o ejecuta los scripts de creación de tablas para `ninos`, `asistencia`, `usuarios`, etc.

3. **Configuración**:
   - Verifica la conexión a la base de datos en `app/core/Database.php` o el archivo de configuración correspondiente.

4. **Ejecutar**:
   - Abre tu navegador y accede a `http://localhost/navidad`.

## 📖 Uso del Sistema

1. **Registrar Niños**: Ve a la sección de registro y añade los datos de los participantes.
2. **Generar Carnets**:
   - Ve a la lista de niños y haz clic en "Carnets QR".
   - Haz clic en "Descargar Pases 3x3" para obtener el PDF listo para imprimir.
   - Recorta y entrega los carnets.
3. **Tomar Asistencia**:
   - Ve a la sección de Asistencia.
   - Haz clic en "📷 Escanear QR".
   - Escanea el carnet del niño; el sistema marcará automáticamente su asistencia.

## 🤝 Créditos

Desarrollado con ❤️ para la temporada navideña 2025.

**Patrocinado por:**
> **GemetechITServices** - Soluciones Tecnológicas Integrales.

---
*¡Feliz Navidad y Próspero Año Nuevo!* 🎅🎄
