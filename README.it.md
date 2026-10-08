# Curriculo.online - Gestione Fasi e Generatore di Modelli di Curriculum Lattes

> **Lingue disponibili / Available languages / Idiomas disponíveis / Idiomas disponibles:**  
> [English (EN)](README.md) | [Español (ES)](README.es.md) | [Português (PT-BR)](README.pt.md) | **Italiano (IT)**

---

Sistema web completo sviluppato in **HTML, CSS, JavaScript, React Web, PHP e MySQL**, ideato partendo dai backup storici (`#bkp/0.1` e `#bkp/0.3`) ed esteso per la generazione di molteplici modelli di **Curriculum Lattes / Accademico CNPq**.

L'architettura del progetto segue una separazione modulare a cartelle ispirata al progetto di riferimento `ESP32 Urna Eletronica`.

---

## 📁 Struttura delle Cartelle del Progetto

```text
curiculo.online/
├── frontend/               # Interfaccia Utente React Web (Vite, CSS Moderno, Simulatore A4)
│   ├── src/                # Codice sorgente (Componenti, Template Lattes, Hooks, Stili)
│   │   ├── components/     # WizardSteps, EtapasManager, TemplateGallery, ResumePreview
│   │   │   └── templates/  # 5 Modelli Lattes (Tradizionale, Moderno, Sintetico, Ibrido, Minimalista)
│   │   ├── data/           # Fasi predefinite, dati di esempio e catalogo modelli
│   │   ├── services/       # Client API REST con fallback su localStorage
│   │   └── styles/         # Design System (token CSS, modalità scura/chiara, @media print)
│   ├── dist/               # Bundle compilato ottimizzato per la produzione
│   ├── package.json        # Dipendenze frontend
│   └── vite.config.js      # Configurazione Vite con proxy verso il backend PHP
│
├── backend/                # API RESTful in PHP 8.3
│   ├── config/             # Connessione PDO con supporto MySQL e fallback locale JSON
│   ├── models/             # Modelli di dati (Etapa, Modelo, Curriculo)
│   ├── data_storage/       # Archiviazione locale resiliente
│   └── index.php           # Router REST dell'API con risposte JSON
│
├── db/                     # Livello Database MySQL (100% PHP)
│   ├── schema.php          # Struttura completa delle tabelle e seed in puro PHP
│   ├── install.php         # Script PHP per la creazione automatica di database e tabelle
│   └── seed.php            # Script PHP per la verifica e il caricamento iniziale dei dati
│
├── devops/                 # Infrastruttura, Orchestrazione e Server
│   ├── kubernetes/         # Manifest K8s dichiarativi, Kustomize, Deployment, Servizi e Ingress
│   ├── docker/             # Dockerfile (Backend/Frontend), docker-compose e .dockerignore
│   ├── podman/             # Supporto container rootless (podman play kube e script)
│   ├── localserver/        # Script per PHP integrato, Apache vhost, Nginx e diagnostica
│   └── config/             # Configurazioni centrali (.env.example, php.ini, nginx.conf)
│
├── docs/                   # Documentazione Tecnica del Progetto
│   ├── arquitetura.md      # Panoramica dell'architettura del sistema
│   ├── etapas_curriculo.md # Mappatura dettagliata delle fasi basata sui backup
│   └── modelos_lattes.md   # Descrizione dei 5 modelli di curriculum Lattes
│
├── teste/                  # Test Automatizzati
│   ├── run_tests.php       # Suite di test automatizzati in PHP
│   └── run_tests.ps1       # Script di esecuzione rapida per PowerShell
│
├── #bkp/                   # Backup storici originali preservati (0.1 e 0.3)
├── index.php               # Router principale unificato (API + SPA)
├── router.php              # Router per il server integrato di PHP (`php -S`)
└── .htaccess               # Configurazione Apache mod_rewrite
```

---

## 🚀 Come Eseguire il Progetto

### Opzione 1: Server Integrato PHP (Consigliato)
Per eseguire l'applicazione completa (API REST + Frontend compilato):
```bash
php -S localhost:8000 router.php
```
Accedi nel browser su: **http://localhost:8000**

### Opzione 2: Modalità Sviluppo React (Hot-Reload)
```bash
cd frontend
npm run dev
```
Accedi nel browser su: **http://localhost:3000** (le richieste `/api` vengono reindirizzate automaticamente alla porta `8000`).

### Opzione 3: Tramite Docker Compose
```bash
cd devops
docker-compose up -d
```

---

## 🗄️ Database MySQL (`db/`)

Il progetto opera con un'architettura di database **100% PHP** senza file `.sql` esterni:
```bash
# Installazione automatica delle tabelle e caricamento iniziale (seed):
php db/install.php

# Verifica e sincronizzazione dei seed:
php db/seed.php
```

---

## 🧪 Test Automatizzati (`teste/`)

Per eseguire la suite di test del backend e del database:
```bash
php teste/run_tests.php
# Oppure in PowerShell:
.\teste\run_tests.ps1
```

---

## 📑 5 Modelli di Curriculum Lattes

1. **Lattes Tradizionale (Ufficiale CNPq)**: Formato canonico con intestazione istituzionale, dati tabellari, sommario biografico continuo, formazione cronologica e citazioni in formato ABNT.
2. **Lattes Esecutivo Moderno**: Layout a 2 colonne con barra laterale per fotografia, identificatori accademici (ORCID, ID Lattes), contatti e cronologia di carriera.
3. **Lattes Sintetico / Pocket**: Impaginazione compatta ad alta densità informativa, ideale per bandi e selezioni con limite di pagine.
4. **Lattes Ibrido & Aziendale (R&D / Industria)**: Unisce pubblicazioni e progetti scientifici all'esperienza sul mercato tecnologico.
5. **Lattes Minimalista Monocromatico**: Tipografia classica con grazie, ampio respiro editoriale e contrasto neutro per stampe cartacee impeccabili.
