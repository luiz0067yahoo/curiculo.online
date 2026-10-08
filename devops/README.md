# 🛠️ DevOps & Infrastructure - Curriculo.online

Esta pasta reúne todos os recursos de infraestrutura, orquestração, conteinerização e servidores locais para o projeto **Curriculo.online**, organizada em 5 módulos:

```text
devops/
├── config/              # Configurações globais e modelos (.env.example, php.ini, nginx.conf)
├── docker/              # Dockerfiles otimizados, docker-compose.yml e .dockerignore
├── kubernetes/          # Manifestos K8s nativos, Kustomization, Deployments, Services e Ingress
├── localserver/         # Scripts para execução local (PHP built-in, Apache vhost, Nginx e diagnóstico)
└── podman/              # Orquestração rootless com Podman (podman play kube, compose e scripts)
```

---

## 1. ☸️ Kubernetes (`devops/kubernetes/`)

Manifestos declarativos prontos para implantação em clusters Kubernetes (**Minikube**, **k3s**, **Kind** ou nuvem **EKS/GKE/AKS**):

- `00-namespace.yaml`: Isolamento no namespace `curriculo-online`.
- `01-configmap-secrets.yaml`: Variáveis de ambiente e credenciais seguras.
- `02-mysql.yaml`: Deployment do MySQL 8.0 com PersistentVolumeClaim (PVC 5Gi) e Service.
- `03-backend.yaml`: Deployment replicado (2 pods) da API REST PHP 8.3 com probes de *liveness* e *readiness*.
- `04-frontend.yaml`: Deployment replicado (2 pods) do Frontend React Nginx com healthcheck.
- `05-ingress.yaml`: Ingress controller roteando `/api` para o backend e `/` para a SPA.
- `kustomization.yaml`: Kustomize para aplicação completa com um único comando.

**Como implantar:**
```bash
kubectl apply -k devops/kubernetes/
```

---

## 2. 🐳 Docker (`devops/docker/`)

Suporte completo a contêineres Docker:

- `Dockerfile.backend`: Imagem PHP 8.3 CLI com extensões PDO MySQL instaladas e código montado.
- `Dockerfile.frontend`: Build multi-stage (Node.js 20 para compilação do Vite + Nginx Alpine para servir estáticos).
- `docker-compose.yml`: Orquestração multi-contêiner conectando frontend (porta 3000), backend (porta 8000) e MySQL (porta 3306).
- `.dockerignore`: Exclusão de arquivos temporários e dependências pesadas no contexto de build.

**Como executar:**
```bash
docker compose -f devops/docker/docker-compose.yml up -d
```

---

## 3. 🦭 Podman (`devops/podman/`)

Suporte nativo e rootless (sem privilégios root / sem daemon central) via Podman:

- `curriculo-pod.yaml`: Manifesto de Pod compatível com `podman play kube` (executa todo o stack no mesmo Pod).
- `podman-compose.yml`: Orquestração compatível com podman-compose.
- `podman-pod-run.sh` / `podman-pod-run.bat`: Scripts automatizados para criar pod rootless e executar os contêineres.

**Como executar via Podman Kube:**
```bash
podman play kube devops/podman/curriculo-pod.yaml
```

**Ou via Script:**
```bash
# Windows:
devops\podman\podman-pod-run.bat

# Linux / macOS:
./devops/podman/podman-pod-run.sh
```

---

## 4. 💻 Local Server (`devops/localserver/`)

Execução em máquina local sem necessidade de contêineres:

- `setup-localserver.php`: Script de diagnóstico de ambiente PHP (versão, extensões pdo/json/mbstring, diretórios de armazenamento e integridade).
- `start-php-builtin.bat` / `start-php-builtin.sh`: Inicializador do servidor embutido do PHP (`php -S 127.0.0.1:8000 router.php`) com abertura automática do navegador.
- `apache-vhost.conf`: Configuração de `VirtualHost` do Apache com regras de `mod_rewrite` e roteamento unificado.
- `nginx-localserver.conf`: Configuração de bloco de servidor Nginx para integração local com PHP-FPM.

**Diagnóstico de ambiente local:**
```bash
php devops/localserver/setup-localserver.php
```

---

## 5. ⚙️ Config (`devops/config/`)

Centralização das configurações e modelos:

- `.env.example`: Modelo completo de variáveis de ambiente com documentação de cada chave (`DB_*`, `SERVER_*`, `DEFAULT_LANG`, etc.).
- `php.ini`: Diretivas recomendadas de memória, tamanho de upload, tratamento de sessão e timezone.
- `nginx.conf`: Configuração otimizada para Nginx de produção com compressão Gzip, cabeçalhos de segurança HTTP e proxy reverso `/api/`.
