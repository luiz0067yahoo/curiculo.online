# Curriculo.online - Cadastro de Etapas & Gerador de Modelos de Currículo Lattes

> **Idiomas disponíveis / Available languages / Idiomas disponibles / Lingue disponibili:**  
> [English (EN)](README.md) | [Español (ES)](README.es.md) | **Português (PT-BR)** | [Italiano (IT)](README.it.md)

---

Sistema web completo desenvolvido com **HTML, CSS, JavaScript, React Web, PHP e MySQL**, concebido a partir dos backups históricos (`#bkp/0.1` e `#bkp/0.3`) com extensão para múltiplos modelos de **Currículo Lattes / Acadêmico CNPq**.

A arquitetura do projeto segue a separação modular de diretórios inspirada no projeto de referência `ESP32 Urna Eletronica`.

---

## 📁 Estrutura de Pastas do Projeto

```text
curiculo.online/
├── frontend/               # Interface em React Web (Vite, CSS Moderno, Simulador A4)
│   ├── src/                # Código-fonte (Componentes, Templates Lattes, Hooks, Estilos)
│   │   ├── components/     # WizardSteps, EtapasManager, TemplateGallery, ResumePreview
│   │   │   └── templates/  # 5 Modelos Lattes (Tradicional, Moderno, Resumido, Híbrido, Minimalista)
│   │   ├── data/           # Etapas padrão do backup, dados de exemplo e modelos
│   │   ├── services/       # Cliente API REST com fallback localStorage
│   │   └── styles/         # Design System (tokens CSS, dark/light mode, @media print)
│   ├── dist/               # Bundle compilado otimizado para produção
│   ├── package.json        # Dependências do frontend
│   └── vite.config.js      # Configuração do Vite com proxy para o backend PHP
│
├── backend/                # API RESTful em PHP 8.3
│   ├── config/             # Conexão PDO com suporte a MySQL e fallback JSON
│   ├── models/             # Modelos de dados (Etapa, Modelo, Curriculo)
│   ├── data_storage/       # Armazenamento local resiliente
│   └── index.php           # Roteador REST da API com endpoints JSON
│
├── db/                     # Camada de Banco de Dados MySQL (100% PHP)
│   ├── schema.php          # Estrutura completa das tabelas e seeds em PHP puro
│   ├── install.php         # Script PHP para criação automatizada do banco e tabelas
│   └── seed.php            # Script PHP para verificação e carga de dados iniciais
│
├── devops/                 # Infraestrutura, Orquestração e Servidores
│   ├── kubernetes/         # Manifestos K8s, Kustomize, Deployments, Services e Ingress
│   ├── docker/             # Dockerfiles (Backend/Frontend), docker-compose e .dockerignore
│   ├── podman/             # Suporte a contêineres rootless (podman play kube e scripts)
│   ├── localserver/        # Scripts para PHP embutido, Apache vhost, Nginx e diagnóstico
│   └── config/             # Configurações centrais (.env.example, php.ini, nginx.conf)
│
├── docs/                   # Documentação Técnica do Projeto
│   ├── arquitetura.md      # Visão geral da arquitetura do sistema
│   ├── etapas_curriculo.md # Mapeamento detalhado das etapas com base no backup
│   └── modelos_lattes.md   # Descrição dos 5 modelos de currículo Lattes
│
├── teste/                  # Testes Automatizados
│   ├── run_tests.php       # Suíte de testes automatizados PHP
│   └── run_tests.ps1       # Script de execução rápida para PowerShell
│
├── #bkp/                   # Backups originais do projeto preservados (0.1 e 0.3)
├── index.php               # Roteador principal unificado (API + SPA)
├── router.php              # Roteador para servidor embutido do PHP (`php -S`)
└── .htaccess               # Configuração Apache mod_rewrite
```

---

## 🚀 Como Executar o Projeto

### Opção 1: Servidor Integrado PHP (Recomendado)
Para executar a aplicação completa (API REST + Frontend compilado):
```bash
php -S localhost:8000 router.php
```
Acesse no navegador: **http://localhost:8000**

### Opção 2: Modo Desenvolvimento React (Hot-Reload)
```bash
cd frontend
npm run dev
```
Acesse no navegador: **http://localhost:3000** (as requisições `/api` serão encaminhadas automaticamente para a porta `8000`).

### Opção 3: Via Docker Compose
```bash
cd devops
docker-compose up -d
```

---

## 🗄️ Banco de Dados MySQL (`db/`)

O projeto opera com arquitetura **100% PHP** (sem arquivos `.sql` externos), permitindo migrações e seeds diretamente pelo código:
```bash
# Executar instalação automatizada das tabelas e carga inicial:
php db/install.php

# Executar verificação e sincronização de seeds:
php db/seed.php
```

---

## 🧪 Testes Automatizados (`teste/`)

Para executar os testes automatizados da API e banco de dados:
```bash
php teste/run_tests.php
# Ou no PowerShell:
.\teste\run_tests.ps1
```

---

## 📑 5 Modelos de Currículo Lattes

1. **Lattes Tradicional (Padrão CNPq)**: Formato canônico oficial com cabeçalho institucional, dados cadastrais em tabela, resumo biográfico contínuo, formação acadêmica cronológica e citações bibliográficas no padrão ABNT.
2. **Lattes Executivo Moderno**: Layout em 2 colunas com sidebar elegante para foto, identificadores acadêmicos (ORCID, ID Lattes), contatos, métricas e timeline.
3. **Lattes Resumido / Pocket**: Diagramação compacta de alta densidade informativa, ideal para editais com restrição de páginas.
4. **Lattes & Corporativo (P&D / Indústria)**: Integra rigor científico e publicações com competências corporativas e experiência técnica no mercado.
5. **Lattes Minimalista Monocromático**: Estilo editorial com tipografia serifada limpa, espaçamento arejado e contraste neutro para impressão em alta resolução.

---

## 📄 Licença e Direitos
Desenvolvido para fins acadêmicos e profissionais com base nos backups do repositório `curiculo.online`.
