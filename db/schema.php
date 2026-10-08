<?php
/**
 * Definições de Estrutura do Banco de Dados e Carga Inicial (100% PHP)
 * Sistema de Cadastro de Etapas e Modelos de Currículo Lattes
 * 
 * Sem dependência de arquivos .sql externos - totalmente executável via PHP / PDO
 */

class DatabaseSchema {

    /**
     * Retorna array com os comandos DDL de criação de tabelas
     */
    public static function getTables(): array {
        return [
            'users' => "
                CREATE TABLE IF NOT EXISTS `users` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `name` VARCHAR(255) NOT NULL,
                    `username` BLOB NOT NULL,
                    `password` BLOB NOT NULL,
                    `e_mail` VARCHAR(255) DEFAULT NULL,
                    `e_mail_crypto` BLOB NOT NULL,
                    `cell_phone` VARCHAR(20) DEFAULT NULL,
                    `telephone` VARCHAR(20) DEFAULT NULL,
                    `code` BLOB DEFAULT NULL,
                    `code_time` DATETIME DEFAULT NULL,
                    `attempts` INT(11) DEFAULT 0,
                    `date_insert` DATETIME DEFAULT CURRENT_TIMESTAMP,
                    `date_update` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ",

            'logs' => "
                CREATE TABLE IF NOT EXISTS `logs` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `user_id` INT(11) DEFAULT NULL,
                    `token` VARCHAR(255) NOT NULL,
                    `username` BLOB NOT NULL,
                    `start_session` DATETIME NOT NULL,
                    `end_session` DATETIME DEFAULT NULL,
                    `ip_address` VARCHAR(45) DEFAULT NULL,
                    `date_insert` DATETIME DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ",

            'curriculo_etapas' => "
                CREATE TABLE IF NOT EXISTS `curriculo_etapas` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `slug` VARCHAR(60) NOT NULL UNIQUE,
                    `titulo` VARCHAR(100) NOT NULL,
                    `subtitulo` VARCHAR(255) DEFAULT NULL,
                    `descricao` TEXT DEFAULT NULL,
                    `ordem` INT(11) NOT NULL DEFAULT 1,
                    `obrigatoria` TINYINT(1) NOT NULL DEFAULT 1,
                    `ativo` TINYINT(1) NOT NULL DEFAULT 1,
                    `icone` VARCHAR(50) DEFAULT 'FileText',
                    `tipo_perfil` ENUM('todos', 'lattes', 'corporativo') DEFAULT 'todos',
                    `date_insert` DATETIME DEFAULT CURRENT_TIMESTAMP,
                    `date_update` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ",

            'curriculo_etapa_campos' => "
                CREATE TABLE IF NOT EXISTS `curriculo_etapa_campos` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `etapa_id` INT(11) NOT NULL,
                    `slug` VARCHAR(60) NOT NULL,
                    `label` VARCHAR(100) NOT NULL,
                    `tipo` VARCHAR(30) NOT NULL DEFAULT 'text',
                    `placeholder` VARCHAR(255) DEFAULT NULL,
                    `opcoes_json` JSON DEFAULT NULL,
                    `obrigatorio` TINYINT(1) NOT NULL DEFAULT 0,
                    `ordem` INT(11) NOT NULL DEFAULT 1,
                    `date_insert` DATETIME DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    CONSTRAINT `fk_etapa_campos` FOREIGN KEY (`etapa_id`) 
                        REFERENCES `curriculo_etapas` (`id`) ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ",

            'curriculo_modelos' => "
                CREATE TABLE IF NOT EXISTS `curriculo_modelos` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `slug` VARCHAR(50) NOT NULL UNIQUE,
                    `nome` VARCHAR(100) NOT NULL,
                    `descricao` TEXT NOT NULL,
                    `categoria` VARCHAR(50) DEFAULT 'Lattes / Acadêmico',
                    `badge` VARCHAR(30) DEFAULT 'Oficial',
                    `cor_padrao` VARCHAR(20) DEFAULT '#1e3a8a',
                    `thumbnail` VARCHAR(255) DEFAULT NULL,
                    `ativo` TINYINT(1) NOT NULL DEFAULT 1,
                    `ordem` INT(11) NOT NULL DEFAULT 1,
                    `date_insert` DATETIME DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ",

            'curriculos' => "
                CREATE TABLE IF NOT EXISTS `curriculos` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `uuid` VARCHAR(64) NOT NULL UNIQUE,
                    `user_id` INT(11) DEFAULT NULL,
                    `titulo` VARCHAR(150) NOT NULL,
                    `nome_completo` VARCHAR(150) NOT NULL,
                    `email` VARCHAR(150) DEFAULT NULL,
                    `modelo_slug` VARCHAR(50) NOT NULL DEFAULT 'lattes-tradicional',
                    `cor_tema` VARCHAR(20) NOT NULL DEFAULT '#1e3a8a',
                    `dados_json` LONGTEXT NOT NULL,
                    `criado_em` DATETIME DEFAULT CURRENT_TIMESTAMP,
                    `atualizado_em` DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    INDEX `idx_uuid` (`uuid`),
                    INDEX `idx_modelo` (`modelo_slug`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            "
        ];
    }

    /**
     * Retorna a lista de etapas pré-configuradas do currículo
     */
    public static function getInitialEtapas(): array {
        return [
            [
                'id' => 1,
                'slug' => 'dados_basicos',
                'titulo' => 'Dados Básicos e Identificação',
                'subtitulo' => 'Informações essenciais de contato e identificação civil/acadêmica',
                'descricao' => 'Nome, sexo, data de nascimento, e-mail, telefones e redes profissionais.',
                'ordem' => 1,
                'obrigatoria' => 1,
                'ativo' => 1,
                'icone' => 'User',
                'tipo_perfil' => 'todos'
            ],
            [
                'id' => 2,
                'slug' => 'identificadores_lattes',
                'titulo' => 'Identificadores Acadêmicos & Lattes',
                'subtitulo' => 'Endereço para acessar este CV, ID Lattes e ORCID',
                'descricao' => 'ID Lattes CNPq, ORCID ID, Scopus ID, nome em citações bibliográficas e resumo acadêmico.',
                'ordem' => 2,
                'obrigatoria' => 1,
                'ativo' => 1,
                'icone' => 'Award',
                'tipo_perfil' => 'lattes'
            ],
            [
                'id' => 3,
                'slug' => 'formacao_academica',
                'titulo' => 'Formação Acadêmica / Titulação',
                'subtitulo' => 'Trajetória educacional do ensino médio à pós-graduação',
                'descricao' => 'Cursos de graduação, especialização, mestrado, doutorado e pós-doutorado.',
                'ordem' => 3,
                'obrigatoria' => 1,
                'ativo' => 1,
                'icone' => 'GraduationCap',
                'tipo_perfil' => 'todos'
            ],
            [
                'id' => 4,
                'slug' => 'atuacao_profissional',
                'titulo' => 'Atuação Profissional & Trajetória',
                'subtitulo' => 'Vínculos institucionais, empresas e experiência profissional',
                'descricao' => 'Cargos, instituições/empresas de atuação, linhas de atuação e período.',
                'ordem' => 4,
                'obrigatoria' => 1,
                'ativo' => 1,
                'icone' => 'Briefcase',
                'tipo_perfil' => 'todos'
            ],
            [
                'id' => 5,
                'slug' => 'linhas_pesquisa',
                'titulo' => 'Linhas de Pesquisa & Áreas de Atuação',
                'subtitulo' => 'Grandes áreas do CNPq e especialidades científicas',
                'descricao' => 'Classificação por grande área (Ex: Exatas, Saúde, Humanas) e subáreas.',
                'ordem' => 5,
                'obrigatoria' => 0,
                'ativo' => 1,
                'icone' => 'Search',
                'tipo_perfil' => 'lattes'
            ],
            [
                'id' => 6,
                'slug' => 'producao_bibliografica',
                'titulo' => 'Produção Bibliográfica & Científica',
                'subtitulo' => 'Artigos, livros publicados, capítulos e anais de congressos',
                'descricao' => 'Publicações científicas, periódicos com Qualis/DOI e trabalhos em eventos.',
                'ordem' => 6,
                'obrigatoria' => 0,
                'ativo' => 1,
                'icone' => 'BookOpen',
                'tipo_perfil' => 'lattes'
            ],
            [
                'id' => 7,
                'slug' => 'projetos_pesquisa',
                'titulo' => 'Projetos de Pesquisa & Extensão',
                'subtitulo' => 'Projetos institucionais coordenados ou integrados',
                'descricao' => 'Título do projeto, agência de fomento (CNPq, CAPES, FAPESP), integrantes e status.',
                'ordem' => 7,
                'obrigatoria' => 0,
                'ativo' => 1,
                'icone' => 'FolderGit2',
                'tipo_perfil' => 'lattes'
            ],
            [
                'id' => 8,
                'slug' => 'conhecimentos_idiomas',
                'titulo' => 'Idiomas & Conhecimentos',
                'subtitulo' => 'Fluência linguística e competências técnicas',
                'descricao' => 'Idiomas com nível de compreensão/fala/escrita e ferramentas ou competências.',
                'ordem' => 8,
                'obrigatoria' => 0,
                'ativo' => 1,
                'icone' => 'Languages',
                'tipo_perfil' => 'todos'
            ],
            [
                'id' => 9,
                'slug' => 'cargo_pretendido',
                'titulo' => 'Área & Cargo Pretendido / Interesses',
                'subtitulo' => 'Objetivos profissionais ou acadêmicos almejados',
                'descricao' => 'Área de interesse, cargos pretendidos e pretensão ou dedicação.',
                'ordem' => 9,
                'obrigatoria' => 0,
                'ativo' => 1,
                'icone' => 'Compass',
                'tipo_perfil' => 'corporativo'
            ],
            [
                'id' => 10,
                'slug' => 'dados_pessoais',
                'titulo' => 'Dados Complementares & Endereço',
                'subtitulo' => 'Endereço residencial/profissional e informações adicionais',
                'descricao' => 'Estado civil, filhos, disponibilidade de viagens/mudança e endereço completo.',
                'ordem' => 10,
                'obrigatoria' => 0,
                'ativo' => 1,
                'icone' => 'Home',
                'tipo_perfil' => 'todos'
            ]
        ];
    }

    /**
     * Retorna a lista de modelos de currículo pré-configurados
     */
    public static function getInitialModelos(): array {
        return [
            [
                'id' => 1,
                'slug' => 'lattes-tradicional',
                'nome' => 'Lattes Tradicional (Padrão CNPq)',
                'descricao' => 'Modelo fiel à estrutura clássica da Plataforma Lattes / CNPq, com cabeçalho oficial, dados cadastrais, resumo biográfico corrido, formação acadêmica cronológica e produções no formato ABNT.',
                'categoria' => 'Lattes / Acadêmico',
                'badge' => 'Oficial CNPq',
                'cor_padrao' => '#0f3a68',
                'ativo' => 1,
                'ordem' => 1
            ],
            [
                'id' => 2,
                'slug' => 'lattes-moderno',
                'nome' => 'Lattes Executivo Moderno',
                'descricao' => 'Layout contemporâneo com barra lateral elegante para foto, contatos, métricas acadêmicas (ORCID, ID Lattes, H-Index) e corpo dinâmico para trajetória e publicações destacadas.',
                'categoria' => 'Lattes / Moderno',
                'badge' => 'Mais Popular',
                'cor_padrao' => '#1e40af',
                'ativo' => 1,
                'ordem' => 2
            ],
            [
                'id' => 3,
                'slug' => 'lattes-resumido',
                'nome' => 'Lattes Resumido / Pocket',
                'descricao' => 'Diagramação sintética ideal para editais de fomento, submissão de bancas avaliadoras e candidaturas com limite de páginas. Destaca os 5 artigos principais e titulação máxima.',
                'categoria' => 'Lattes / Síntese',
                'badge' => 'Compacto',
                'cor_padrao' => '#0f766e',
                'ativo' => 1,
                'ordem' => 3
            ],
            [
                'id' => 4,
                'slug' => 'lattes-hibrido',
                'nome' => 'Lattes & Corporativo (P&D / Indústria)',
                'descricao' => 'Integra projetos de inovação tecnológica, publicações e competências técnicas com a trajetória de gestão e experiência de mercado para cientistas na indústria.',
                'categoria' => 'Híbrido P&D',
                'badge' => 'Tecnologia & P&D',
                'cor_padrao' => '#374151',
                'ativo' => 1,
                'ordem' => 4
            ],
            [
                'id' => 5,
                'slug' => 'lattes-minimalista',
                'nome' => 'Lattes Minimalista Monocromático',
                'descricao' => 'Design editorial clean, tipografia serifada de alta legibilidade, otimizado para impressão oficial em alta resolução e pareceres de comissões acadêmicas.',
                'categoria' => 'Minimalista',
                'badge' => 'Alta Legibilidade',
                'cor_padrao' => '#111827',
                'ativo' => 1,
                'ordem' => 5
            ]
        ];
    }

    /**
     * Executa a criação de todas as tabelas via PDO
     */
    public static function createTables(PDO $pdo): void {
        foreach (self::getTables() as $tableName => $sql) {
            $pdo->exec($sql);
        }
    }

    /**
     * Realiza o seed inicial ou atualização dos registros nas tabelas
     */
    public static function seed(PDO $pdo): array {
        $etapaCount = 0;
        $modeloCount = 0;

        // Inserir / Atualizar Etapas
        $stmtEtapa = $pdo->prepare("
            INSERT INTO `curriculo_etapas` 
                (`id`, `slug`, `titulo`, `subtitulo`, `descricao`, `ordem`, `obrigatoria`, `ativo`, `icone`, `tipo_perfil`) 
            VALUES 
                (:id, :slug, :titulo, :subtitulo, :descricao, :ordem, :obrigatoria, :ativo, :icone, :tipo_perfil)
            ON DUPLICATE KEY UPDATE 
                `titulo` = VALUES(`titulo`),
                `subtitulo` = VALUES(`subtitulo`),
                `descricao` = VALUES(`descricao`),
                `ordem` = VALUES(`ordem`),
                `ativo` = VALUES(`ativo`),
                `icone` = VALUES(`icone`);
        ");

        foreach (self::getInitialEtapas() as $etapa) {
            $stmtEtapa->execute($etapa);
            $etapaCount++;
        }

        // Inserir / Atualizar Modelos
        $stmtModelo = $pdo->prepare("
            INSERT INTO `curriculo_modelos` 
                (`id`, `slug`, `nome`, `descricao`, `categoria`, `badge`, `cor_padrao`, `ativo`, `ordem`)
            VALUES 
                (:id, :slug, :nome, :descricao, :categoria, :badge, :cor_padrao, :ativo, :ordem)
            ON DUPLICATE KEY UPDATE 
                `nome` = VALUES(`nome`),
                `descricao` = VALUES(`descricao`),
                `cor_padrao` = VALUES(`cor_padrao`),
                `badge` = VALUES(`badge`),
                `ativo` = VALUES(`ativo`);
        ");

        foreach (self::getInitialModelos() as $modelo) {
            $stmtModelo->execute($modelo);
            $modeloCount++;
        }

        return [
            'etapas' => $etapaCount,
            'modelos' => $modeloCount
        ];
    }
}
