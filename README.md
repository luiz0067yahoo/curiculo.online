# Curriculo.online - Curriculum Stages Management & Lattes Resume Generator

> **Available Languages / Idiomas Disponíveis / Idiomas Disponibles / Lingue Disponibili:**  
> **[English (EN)](README.md)** | [Español (ES)](README.es.md) | [Português (PT-BR)](README.pt.md) | [Italiano (IT)](README.it.md)

---

A full-stack, enterprise-grade web application built with **HTML, CSS, JavaScript, React Web, PHP, and MySQL**. Conceived from historical project backups (`#bkp/0.1` and `#bkp/0.3`) and extended into a versatile platform for generating multiple **Lattes / CNPq Academic Curriculum Vitae** models.

The project architecture features a clean, decoupled folder structure inspired by the reference project `ESP32 Urna Eletronica`.

---

## 📁 Repository Directory Structure

```text
curiculo.online/
├── frontend/               # React Web Application (Vite, Modern CSS Design System, A4 Simulator)
│   ├── src/                # Source code (Components, Lattes Templates, Hooks, Styles)
│   │   ├── components/     # WizardSteps, EtapasManager, TemplateGallery, ResumePreview
│   │   │   └── templates/  # 5 Lattes Templates (Traditional, Modern, Pocket, Hybrid, Minimalist)
│   │   ├── data/           # Default backup stages, sample academic profile, template catalog
│   │   ├── services/       # REST API client with transparent localStorage fallback
│   │   └── styles/         # CSS design tokens, dark/light themes, @media print A4 layout
│   ├── dist/               # Production-ready compiled assets
│   ├── package.json        # Frontend dependencies and npm scripts
│   └── vite.config.js      # Vite build configuration with backend proxy
│
├── backend/                # RESTful API in PHP 8.3
│   ├── config/             # Database connection (PDO MySQL + resilient JSON fallback)
│   ├── models/             # Data models (Etapa, Modelo, Curriculo)
│   ├── data_storage/       # Local file storage fallback
│   └── index.php           # REST routing entry point with JSON output & CORS
│
├── db/                     # MySQL Database Layer (100% PHP)
│   ├── schema.php          # Pure PHP table definitions and seed arrays (No .sql files)
│   ├── install.php         # Automated CLI/Web database creation and migration script
│   └── seed.php            # Seed data validator and loader script
│
├── devops/                 # Containerization, Orchestration & Servers
│   ├── kubernetes/         # Declarative K8s manifests, Kustomize, Deployments, Services & Ingress
│   ├── docker/             # Dockerfiles (Backend/Frontend), docker-compose & .dockerignore
│   ├── podman/             # Rootless container support (podman play kube, compose & scripts)
│   ├── localserver/        # Local PHP built-in server, Apache vhost, Nginx & diagnostics
│   └── config/             # Central configurations (.env.example, php.ini, nginx.conf)
│
├── docs/                   # Technical Documentation
│   ├── arquitetura.md      # System architecture and layer boundaries
│   ├── etapas_curriculo.md # Backup-to-Lattes stage mapping specification
│   └── modelos_lattes.md   # Design rationale for the 5 Lattes CV models
│
├── teste/                  # Automated Test Suite
│   ├── run_tests.php       # PHP automated assertion test suite
│   └── run_tests.ps1       # One-click PowerShell test runner
│
├── #bkp/                   # Preserved original historical backups (0.1 and 0.3)
├── index.php               # Unified entry point & router (API + SPA)
├── router.php              # PHP built-in web server router (`php -S`)
├── .htaccess               # Apache mod_rewrite rules
└── README.md               # English project documentation (this file)
```

---

## ⚡ Quick Start & Execution

### Option 1: Integrated PHP Server (Recommended for Fast Testing)
Runs both the PHP REST API and the compiled React frontend through the built-in router:
```bash
php -S localhost:8000 router.php
```
Open in your browser: **http://localhost:8000**

### Option 2: React Development Mode (Hot-Reload)
Run the Vite development server independently:
```bash
cd frontend
npm run dev
```
Open in your browser: **http://localhost:3000**  
*(API requests to `/api` are automatically proxied to port `8000`)*.

### Option 3: Full Docker Compose Environment
Spin up MySQL, PHP 8.3, and Nginx containers simultaneously:
```bash
cd devops
docker-compose up -d
```
Access the application at **http://localhost:3000** (or backend directly at **http://localhost:8000**).

---

## 🗄️ Database Setup (`db/`)

The project follows a **100% PHP database architecture** without external `.sql` files:
```bash
# Automated table creation and initial seed loading:
php db/install.php

# Seed verification and refresh:
php db/seed.php
```

> **Note on Resiliency:** If MySQL is not running, the application automatically switches to a local file storage fallback in `backend/data_storage/`, ensuring zero downtime during frontend development or testing.

---

## 🧪 Automated Testing (`teste/`)

To execute the automated regression test suite covering database connections, stage reordering, resume saving, and Lattes summary generation:

```bash
# Using PHP CLI:
php teste/run_tests.php

# Or using PowerShell on Windows:
.\teste\run_tests.ps1
```

Expected output:
```text
========================================================
   INICIANDO SUÍTE DE TESTES AUTOMATIZADOS              
========================================================

[ PASS ] Carregamento da classe Database
[ PASS ] Recuperação de etapas do currículo
[ PASS ] Recuperação dos modelos de currículo Lattes
[ PASS ] Salvamento de currículo completo
[ PASS ] Recuperação de currículo salvo por UUID
[ PASS ] Reordenação de etapas no backend

========================================================
   RESULTADO FINAL: 6 PASSOU | 0 FALHOU
========================================================
```

---

## 📑 5 Integrated Lattes / Academic Resume Models

1. **Lattes Traditional (Official CNPq Standard)**:
   - Canonical format inspired by the official CNPq Lattes Platform.
   - Features the institutional header, tabular registration data, continuous academic bio summary, chronological education degrees with advisors, professional appointments, and ABNT-formatted scientific publications.
2. **Lattes Executive Modern**:
   - Contemporary 2-column layout with an elegant left sidebar for profile photo, academic identifiers (ORCID, Lattes ID, Scopus), contact info, and metrics.
   - Right column showcases a spaced career timeline, research grants, and highlighted publications.
3. **Lattes Pocket / Condensed**:
   - High-density synthetic layout designed for grant calls with strict page limits and expedited selection committees.
   - Highlights highest academic degree, current institutional affiliation, and top 5 peer-reviewed articles.
4. **Lattes Hybrid & Corporate (R&D / Industry)**:
   - Connects academic rigor, journal publications, and patents with leadership experience, technical stack competencies, and private-sector achievements.
5. **Lattes Minimalist Monochrome**:
   - Classic serif editorial typography, generous white space, and neutral grays. Optimized for razor-sharp physical A4 printing on letterhead paper.

---

## 🌟 Key Features

- **Interactive Wizard**: Step-by-step navigation through all 10 stages extracted from the backup forms (`dados_basicos.html`, `dados_pessoais.html`, `experiencia_profissional.html`, `formacao_academica.html`, `conhecimentos.html`, `cargo_pretendido.html`).
- **Dynamic Stages Manager**: Reorder stages, toggle active/inactive status, set required flags, and create custom stages for specific profile types (Lattes, Corporate, or All).
- **Intelligent Lattes Summary Generator**: Generates standardized CNPq bio summaries automatically based on registered university degrees, advisors, and research areas.
- **A4 Live Sheet Simulator**: Zoom slider (70%–130%), color theme dots, JSON export/import, and optimized clean printing via `@media print`.
- **Pre-loaded Backup Data**: One-click sample loader with realistic academic and scientific data for instant testing across all 5 models.

---

## 📜 License
Developed for educational and professional CV generation purposes based on the `curiculo.online` repository history.
