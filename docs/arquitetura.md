# Arquitetura do Sistema - Curriculo.online

Este projeto foi estruturado de forma modular e desacoplada, seguindo o padrão estabelecido no projeto de referência (Urna Eletrônica), organizado nas seguintes pastas:

```text
curiculo.online/
├── frontend/        # Interface de usuário (React Web, Vite, CSS moderno, A4 Print)
├── backend/         # API RESTful em PHP 8.3 (rotas, controllers, modelos e fallback)
├── db/              # Scripts de banco de dados MySQL (DDL, install.php e seed.php)
├── devops/          # Configurações de infraestrutura (Docker, Docker-Compose, Nginx)
├── docs/            # Documentação técnica de arquitetura, modelos e endpoints
├── teste/           # Testes automatizados unitários e de integração
├── index.php        # Ponto de entrada / Roteador geral
├── router.php       # Roteador para servidor embutido do PHP (php -S)
└── .htaccess        # Regras de reescrita Apache
```

---

## 1. Frontend (`frontend/`)
- Desenvolvido em **React 18** com ferramental **Vite**.
- **Design System**: Estilos CSS customizados com tokens de cor (Light/Dark mode), glassmorphism, simulador de folha A4 e regras de impressão `@media print` para geração de PDF sem poluição visual.
- **Componentes**:
  - `WizardSteps.jsx`: Formulário em esteira/etapas dinâmicas baseado nos formulários do `#bkp/0.1`.
  - `EtapasManager.jsx`: Painel administrativo de cadastro, reordenação e ativação de etapas.
  - `ResumePreview.jsx`: Prévia com zoom, seletor de paletas e 5 templates Lattes.
  - `TemplateGallery.jsx`: Catálogo dos modelos com cartões informativos.

---

## 2. Backend (`backend/`)
- Desenvolvido em **PHP 8.3**.
- Arquitetura RESTful limpa com suporte nativo a CORS e retorno padronizado em JSON.
- **Camada de Dados Dual**: Suporta conexão nativa PDO MySQL e fallback automático para armazenamento local em `backend/data_storage/` quando o banco não estiver iniciado.

---

## 3. Banco de Dados (`db/`)
- Definição de esquema e seeds em PHP puro: `db/schema.php` (sem arquivos `.sql`).
- Script de instalação e migração automática via CLI/Web: `db/install.php`.
- Script de carga e verificação inicial de seeds: `db/seed.php`.

---

## 4. DevOps (`devops/`)
A infraestrutura está organizada em 5 módulos especializados:
- `devops/kubernetes/`: Manifestos declarativos K8s (Deployments, Services, Ingress, ConfigMaps e Kustomize).
- `devops/docker/`: Dockerfiles otimizados multi-stage, `docker-compose.yml` e regras `.dockerignore`.
- `devops/podman/`: Suporte a contêineres rootless via `podman play kube`, `podman-compose` e scripts de pod.
- `devops/localserver/`: Scripts de diagnóstico do PHP (`setup-localserver.php`), servidores embutidos, vhost Apache e Nginx.
- `devops/config/`: Configurações centralizadas (`.env.example`, `php.ini`, `nginx.conf`).

---

## 5. Testes (`teste/`)
- Scripts PHP de validação para cada endpoint e gerador de resumo Lattes, com executor automatizado `run_tests.php` e `run_tests.ps1`.
