#!/usr/bin/env bash
# ========================================================================
# Curriculo.online - Multi-Language Launcher / Iniciador / Iniziatore
# Supported: English, Español, Português, Italiano
# ========================================================================

# Color definitions
CYAN='\033[0;36m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
BOLD='\033[1m'
NC='\033[0m' # No Color

# Find PHP command
PHP_CMD="php"
if ! command -v php &> /dev/null; then
    echo -e "${YELLOW}[WARN] PHP command not found in PATH. Please install PHP or set PATH.${NC}"
fi

select_language() {
    clear
    echo -e "${CYAN}========================================================================${NC}"
    echo -e "${BOLD}   Curriculo.online - Launcher / Iniciador / Iniziatore${NC}"
    echo -e "${CYAN}========================================================================${NC}"
    echo ""
    echo "  Please select your language / Seleccione su idioma:"
    echo "  Selecione seu idioma / Seleziona la lingua:"
    echo ""
    echo -e "    ${GREEN}[1]${NC} English (Default / Preferential)"
    echo -e "    ${GREEN}[2]${NC} Español"
    echo -e "    ${GREEN}[3]${NC} Português"
    echo -e "    ${GREEN}[4]${NC} Italiano"
    echo ""
    read -p "Enter choice [1-4] (Default: 1): " LANG_CHOICE
    LANG_CHOICE=${LANG_CHOICE:-1}

    case "$LANG_CHOICE" in
        1) menu_en ;;
        2) menu_es ;;
        3) menu_pt ;;
        4) menu_it ;;
        *) menu_en ;;
    esac
}

# ------------------------------------------------------------------------
# 1. ENGLISH MENU (DEFAULT)
# ------------------------------------------------------------------------
menu_en() {
    while true; do
        clear
        echo -e "${CYAN}========================================================================${NC}"
        echo -e "${BOLD}   Curriculo.online - Control Panel [English]${NC}"
        echo -e "${CYAN}========================================================================${NC}"
        echo ""
        echo -e "    ${GREEN}[1]${NC} Start Integrated Application (PHP API + React on port 8000)"
        echo -e "    ${GREEN}[2]${NC} Start React Frontend in Development Mode (Vite port 3000)"
        echo -e "    ${GREEN}[3]${NC} Install / Migrate MySQL Database (db/install.php)"
        echo -e "    ${GREEN}[4]${NC} Run Automated Test Suite (teste/run_tests.php)"
        echo -e "    ${GREEN}[5]${NC} Start Docker Containers (devops/docker-compose.yml)"
        echo -e "    ${GREEN}[6]${NC} View Documentation (README.md)"
        echo -e "    ${GREEN}[7]${NC} Change Language"
        echo -e "    ${RED}[0]${NC} Exit"
        echo ""
        read -p "Select an option [0-7]: " OPT
        case "$OPT" in
            1)
                echo -e "${GREEN}Starting server at http://localhost:8000 ...${NC}"
                xdg-open http://localhost:8000 2>/dev/null || open http://localhost:8000 2>/dev/null &
                $PHP_CMD -S 0.0.0.0:8000 router.php
                ;;
            2)
                echo -e "${GREEN}Starting Vite dev server...${NC}"
                cd frontend && npm run dev
                cd ..
                ;;
            3)
                echo -e "${GREEN}Running MySQL database installer...${NC}"
                $PHP_CMD db/install.php
                read -p "Press Enter to continue..."
                ;;
            4)
                echo -e "${GREEN}Running automated tests...${NC}"
                $PHP_CMD teste/run_tests.php
                read -p "Press Enter to continue..."
                ;;
            5)
                echo -e "${GREEN}Starting Docker containers...${NC}"
                cd devops && docker-compose up -d && cd ..
                read -p "Press Enter to continue..."
                ;;
            6)
                cat README.md | less 2>/dev/null || cat README.md
                ;;
            7)
                select_language
                return
                ;;
            0)
                exit 0
                ;;
            *)
                echo -e "${RED}Invalid option.${NC}"
                sleep 1
                ;;
        esac
    done
}

# ------------------------------------------------------------------------
# 2. SPANISH MENU
# ------------------------------------------------------------------------
menu_es() {
    while true; do
        clear
        echo -e "${CYAN}========================================================================${NC}"
        echo -e "${BOLD}   Curriculo.online - Panel de Control [Español]${NC}"
        echo -e "${CYAN}========================================================================${NC}"
        echo ""
        echo -e "    ${GREEN}[1]${NC} Iniciar Aplicación Integrada (API PHP + React en puerto 8000)"
        echo -e "    ${GREEN}[2]${NC} Iniciar Frontend React en Modo Desarrollo (Vite puerto 3000)"
        echo -e "    ${GREEN}[3]${NC} Instalar / Migrar Base de Datos MySQL (db/install.php)"
        echo -e "    ${GREEN}[4]${NC} Ejecutar Pruebas Automatizadas (teste/run_tests.php)"
        echo -e "    ${GREEN}[5]${NC} Iniciar Contenedores Docker (devops/docker-compose.yml)"
        echo -e "    ${GREEN}[6]${NC} Ver Documentación (README.es.md)"
        echo -e "    ${GREEN}[7]${NC} Cambiar Idioma"
        echo -e "    ${RED}[0]${NC} Salir"
        echo ""
        read -p "Seleccione una opción [0-7]: " OPT
        case "$OPT" in
            1)
                echo -e "${GREEN}Iniciando servidor en http://localhost:8000 ...${NC}"
                xdg-open http://localhost:8000 2>/dev/null || open http://localhost:8000 2>/dev/null &
                $PHP_CMD -S 0.0.0.0:8000 router.php
                ;;
            2)
                echo -e "${GREEN}Iniciando servidor Vite...${NC}"
                cd frontend && npm run dev
                cd ..
                ;;
            3)
                echo -e "${GREEN}Instalando base de datos MySQL...${NC}"
                $PHP_CMD db/install.php
                read -p "Presione Enter para continuar..."
                ;;
            4)
                echo -e "${GREEN}Ejecutando pruebas...${NC}"
                $PHP_CMD teste/run_tests.php
                read -p "Presione Enter para continuar..."
                ;;
            5)
                echo -e "${GREEN}Iniciando contenedores Docker...${NC}"
                cd devops && docker-compose up -d && cd ..
                read -p "Presione Enter para continuar..."
                ;;
            6)
                cat README.es.md | less 2>/dev/null || cat README.es.md
                ;;
            7)
                select_language
                return
                ;;
            0)
                exit 0
                ;;
            *)
                echo -e "${RED}Opción inválida.${NC}"
                sleep 1
                ;;
        esac
    done
}

# ------------------------------------------------------------------------
# 3. PORTUGUESE MENU
# ------------------------------------------------------------------------
menu_pt() {
    while true; do
        clear
        echo -e "${CYAN}========================================================================${NC}"
        echo -e "${BOLD}   Curriculo.online - Painel de Controle [Português]${NC}"
        echo -e "${CYAN}========================================================================${NC}"
        echo ""
        echo -e "    ${GREEN}[1]${NC} Iniciar Aplicação Integrada (API PHP + React na porta 8000)"
        echo -e "    ${GREEN}[2]${NC} Iniciar Frontend React em Modo Desenvolvimento (Vite porta 3000)"
        echo -e "    ${GREEN}[3]${NC} Instalar / Migrar Banco de Dados MySQL (db/install.php)"
        echo -e "    ${GREEN}[4]${NC} Executar Testes Automatizados (teste/run_tests.php)"
        echo -e "    ${GREEN}[5]${NC} Subir Contêineres Docker (devops/docker-compose.yml)"
        echo -e "    ${GREEN}[6]${NC} Ver Documentação (README.pt.md)"
        echo -e "    ${GREEN}[7]${NC} Mudar Idioma"
        echo -e "    ${RED}[0]${NC} Sair"
        echo ""
        read -p "Selecione uma opção [0-7]: " OPT
        case "$OPT" in
            1)
                echo -e "${GREEN}Iniciando servidor em http://localhost:8000 ...${NC}"
                xdg-open http://localhost:8000 2>/dev/null || open http://localhost:8000 2>/dev/null &
                $PHP_CMD -S 0.0.0.0:8000 router.php
                ;;
            2)
                echo -e "${GREEN}Iniciando servidor Vite...${NC}"
                cd frontend && npm run dev
                cd ..
                ;;
            3)
                echo -e "${GREEN}Instalando banco de dados MySQL...${NC}"
                $PHP_CMD db/install.php
                read -p "Pressione Enter para continuar..."
                ;;
            4)
                echo -e "${GREEN}Executando testes...${NC}"
                $PHP_CMD teste/run_tests.php
                read -p "Pressione Enter para continuar..."
                ;;
            5)
                echo -e "${GREEN}Subindo contêineres Docker...${NC}"
                cd devops && docker-compose up -d && cd ..
                read -p "Pressione Enter para continuar..."
                ;;
            6)
                cat README.pt.md | less 2>/dev/null || cat README.pt.md
                ;;
            7)
                select_language
                return
                ;;
            0)
                exit 0
                ;;
            *)
                echo -e "${RED}Opção inválida.${NC}"
                sleep 1
                ;;
        esac
    done
}

# ------------------------------------------------------------------------
# 4. ITALIAN MENU
# ------------------------------------------------------------------------
menu_it() {
    while true; do
        clear
        echo -e "${CYAN}========================================================================${NC}"
        echo -e "${BOLD}   Curriculo.online - Pannello di Controllo [Italiano]${NC}"
        echo -e "${CYAN}========================================================================${NC}"
        echo ""
        echo -e "    ${GREEN}[1]${NC} Avvia Applicazione Integrata (API PHP + React sulla porta 8000)"
        echo -e "    ${GREEN}[2]${NC} Avvia Frontend React in Modalità Sviluppo (Vite porta 3000)"
        echo -e "    ${GREEN}[3]${NC} Installa / Migra Database MySQL (db/install.php)"
        echo -e "    ${GREEN}[4]${NC} Esegui Test Automatizzati (teste/run_tests.php)"
        echo -e "    ${GREEN}[5]${NC} Avvia Container Docker (devops/docker-compose.yml)"
        echo -e "    ${GREEN}[6]${NC} Visualizza Documentazione (README.it.md)"
        echo -e "    ${GREEN}[7]${NC} Cambia Lingua"
        echo -e "    ${RED}[0]${NC} Esci"
        echo ""
        read -p "Seleziona un'opzione [0-7]: " OPT
        case "$OPT" in
            1)
                echo -e "${GREEN}Avvio del server su http://localhost:8000 ...${NC}"
                xdg-open http://localhost:8000 2>/dev/null || open http://localhost:8000 2>/dev/null &
                $PHP_CMD -S 0.0.0.0:8000 router.php
                ;;
            2)
                echo -e "${GREEN}Avvio del server Vite...${NC}"
                cd frontend && npm run dev
                cd ..
                ;;
            3)
                echo -e "${GREEN}Installazione database MySQL...${NC}"
                $PHP_CMD db/install.php
                read -p "Premi Invio per continuare..."
                ;;
            4)
                echo -e "${GREEN}Esecuzione dei test...${NC}"
                $PHP_CMD teste/run_tests.php
                read -p "Premi Invio per continuare..."
                ;;
            5)
                echo -e "${GREEN}Avvio dei container Docker...${NC}"
                cd devops && docker-compose up -d && cd ..
                read -p "Premi Invio per continuare..."
                ;;
            6)
                cat README.it.md | less 2>/dev/null || cat README.it.md
                ;;
            7)
                select_language
                return
                ;;
            0)
                exit 0
                ;;
            *)
                echo -e "${RED}Opzione non valida.${NC}"
                sleep 1
                ;;
        esac
    done
}

# Start script
select_language
