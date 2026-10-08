# Curriculo.online - Registro de Etapas y Generador de Modelos de Currículum Lattes

> **Idiomas disponibles / Available languages / Idiomas disponíveis / Lingue disponibili:**  
> [English (EN)](README.md) | **Español (ES)** | [Português (PT-BR)](README.pt.md) | [Italiano (IT)](README.it.md)

---

Sistema web integral desarrollado con **HTML, CSS, JavaScript, React Web, PHP y MySQL**, concebido a partir de las copias de seguridad históricas (`#bkp/0.1` y `#bkp/0.3`) y extendido para generar múltiples modelos de **Currículum Lattes / Académico CNPq**.

La arquitectura del proyecto sigue una separación modular por carpetas inspirada en el proyecto de referencia `ESP32 Urna Eletronica`.

---

## 📁 Estructura de Carpetas del Proyecto

```text
curiculo.online/
├── frontend/               # Interfaz de Usuario en React Web (Vite, CSS Moderno, Simulador A4)
│   ├── src/                # Código fuente (Componentes, Plantillas Lattes, Hooks, Estilos)
│   │   ├── components/     # WizardSteps, EtapasManager, TemplateGallery, ResumePreview
│   │   │   └── templates/  # 5 Modelos Lattes (Tradicional, Moderno, Resumido, Híbrido, Minimalista)
│   │   ├── data/           # Etapas por defecto, datos de ejemplo y catálogo de modelos
│   │   ├── services/       # Cliente API REST con respaldo en localStorage
│   │   └── styles/         # Design System (tokens CSS, modo claro/oscuro, @media print)
│   ├── dist/               # Paquete compilado optimizado para producción
│   ├── package.json        # Dependencias del frontend
│   └── vite.config.js      # Configuración de Vite con proxy hacia el backend PHP
│
├── backend/                # API RESTful en PHP 8.3
│   ├── config/             # Conexión PDO con soporte MySQL y respaldo local JSON
│   ├── models/             # Modelos de datos (Etapa, Modelo, Curriculo)
│   ├── data_storage/       # Almacenamiento local resiliente
│   └── index.php           # Enrutador REST de la API con respuestas JSON
│
├── db/                     # Capa de Base de Datos MySQL (100% PHP)
│   ├── schema.php          # Estructura completa de tablas y seeds en PHP puro
│   ├── install.php         # Script PHP para instalación automatizada de base de datos y tablas
│   └── seed.php            # Script PHP para verificación y carga de datos iniciales
│
├── devops/                 # Infraestructura, Orquestación y Servidores
│   ├── kubernetes/         # Manifiestos K8s declarativos, Kustomize, Deployments, Services e Ingress
│   ├── docker/             # Dockerfiles (Backend/Frontend), docker-compose y .dockerignore
│   ├── podman/             # Soporte de contenedores rootless (podman play kube y scripts)
│   ├── localserver/        # Scripts para PHP embebido, Apache vhost, Nginx y diagnóstico
│   └── config/             # Configuraciones centrales (.env.example, php.ini, nginx.conf)
│
├── docs/                   # Documentación Técnica del Proyecto
│   ├── arquitetura.md      # Visión general de la arquitectura del sistema
│   ├── etapas_curriculo.md # Mapeo detallado de etapas basado en el respaldo
│   └── modelos_lattes.md   # Descripción de los 5 modelos de currículum Lattes
│
├── teste/                  # Pruebas Automatizadas
│   ├── run_tests.php       # Suite de pruebas automatizadas en PHP
│   └── run_tests.ps1       # Script de ejecución rápida en PowerShell
│
├── #bkp/                   # Copias de seguridad originales del proyecto (0.1 y 0.3)
├── index.php               # Enrutador principal unificado (API + SPA)
├── router.php              # Enrutador para el servidor embebido de PHP (`php -S`)
└── .htaccess               # Configuración Apache mod_rewrite
```

---

## 🚀 Cómo Ejecutar el Proyecto

### Opción 1: Servidor Integrado PHP (Recomendado)
Para ejecutar la aplicación completa (API REST + Frontend compilado):
```bash
php -S localhost:8000 router.php
```
Acceda en el navegador a: **http://localhost:8000**

### Opção 2: Modo Desarrollo React (Hot-Reload)
```bash
cd frontend
npm run dev
```
Acceda en el navegador a: **http://localhost:3000** (las peticiones `/api` se redirigen automáticamente al puerto `8000`).

### Opción 3: Vía Docker Compose
```bash
cd devops
docker-compose up -d
```

---

## 🗄️ Base de Datos MySQL (`db/`)

El proyecto cuenta con una arquitectura de base de datos **100% PHP** sin archivos `.sql` externos:
```bash
# Instalación automatizada de tablas y carga inicial (seed):
php db/install.php

# Verificación y sincronización de seeds:
php db/seed.php
```

---

## 🧪 Pruebas Automatizadas (`teste/`)

Para ejecutar la suite de pruebas del backend y base de datos:
```bash
php teste/run_tests.php
# O en PowerShell:
.\teste\run_tests.ps1
```

---

## 📑 5 Modelos de Currículum Lattes

1. **Lattes Tradicional (Oficial CNPq)**: Formato canónico oficial con encabezado institucional, datos tabulados, resumen biográfico corrido, formación cronológica y citas en formato ABNT.
2. **Lattes Ejecutivo Moderno**: Diseño en dos columnas con barra lateral para fotografía, identificadores académicos (ORCID, ID Lattes), contactos y línea de tiempo profesional.
3. **Lattes Resumido / Pocket**: Maquetación densa y concisa ideal para convocatorias con límite estricto de páginas.
4. **Lattes Híbrido & Corporativo (I+D / Industria)**: Conecta publicaciones científicas y proyectos de investigación con experiencia en el mercado tecnológico.
5. **Lattes Minimalista Monocromático**: Tipografía serifada elegante, amplio espacio en blanco y contraste neutro para impresión física de alta definición.
