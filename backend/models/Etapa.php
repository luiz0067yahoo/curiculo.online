<?php
require_once __DIR__ . '/../config/Database.php';

class EtapaModel {
    private static function getInitialEtapas(): array {
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

    public static function getAll(): array {
        $pdo = Database::getConnection();
        if ($pdo) {
            try {
                $stmt = $pdo->query("SELECT * FROM curriculo_etapas ORDER BY ordem ASC");
                $rows = $stmt->fetchAll();
                if (!empty($rows)) {
                    return $rows;
                }
            } catch (Exception $e) {
                // fall through
            }
        }

        $file = Database::getFallbackStoragePath('etapas');
        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file), true);
            if (is_array($data)) {
                usort($data, fn($a, $b) => ($a['ordem'] ?? 0) <=> ($b['ordem'] ?? 0));
                return $data;
            }
        }

        $initial = self::getInitialEtapas();
        file_put_contents($file, json_encode($initial, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $initial;
    }

    public static function save(array $data): array {
        $etapas = self::getAll();
        $id = $data['id'] ?? null;

        if ($id) {
            $found = false;
            foreach ($etapas as &$etapa) {
                if ($etapa['id'] == $id) {
                    $etapa = array_merge($etapa, $data);
                    $found = true;
                    break;
                }
            }
            if (!$found) {
                $data['id'] = (int)$id;
                $etapas[] = $data;
            }
        } else {
            $maxId = 0;
            foreach ($etapas as $e) {
                if (($e['id'] ?? 0) > $maxId) $maxId = $e['id'];
            }
            $data['id'] = $maxId + 1;
            $data['ordem'] = $data['ordem'] ?? (count($etapas) + 1);
            $etapas[] = $data;
        }

        // Tentar salvar no MySQL
        $pdo = Database::getConnection();
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("INSERT INTO curriculo_etapas (id, slug, titulo, subtitulo, descricao, ordem, obrigatoria, ativo, icone, tipo_perfil)
                    VALUES (:id, :slug, :titulo, :subtitulo, :descricao, :ordem, :obrigatoria, :ativo, :icone, :tipo_perfil)
                    ON DUPLICATE KEY UPDATE 
                    slug=:slug, titulo=:titulo, subtitulo=:subtitulo, descricao=:descricao, ordem=:ordem, obrigatoria=:obrigatoria, ativo=:ativo, icone=:icone, tipo_perfil=:tipo_perfil");
                $stmt->execute([
                    ':id' => $data['id'],
                    ':slug' => $data['slug'] ?? 'etapa_' . $data['id'],
                    ':titulo' => $data['titulo'],
                    ':subtitulo' => $data['subtitulo'] ?? '',
                    ':descricao' => $data['descricao'] ?? '',
                    ':ordem' => $data['ordem'],
                    ':obrigatoria' => $data['obrigatoria'] ? 1 : 0,
                    ':ativo' => $data['ativo'] ? 1 : 0,
                    ':icone' => $data['icone'] ?? 'FileText',
                    ':tipo_perfil' => $data['tipo_perfil'] ?? 'todos',
                ]);
            } catch (Exception $e) {
                // fall back to json file
            }
        }

        // Salvar no JSON fallback
        $file = Database::getFallbackStoragePath('etapas');
        file_put_contents($file, json_encode($etapas, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        return $data;
    }

    public static function delete(int $id): bool {
        $etapas = self::getAll();
        $filtered = array_values(array_filter($etapas, fn($e) => $e['id'] != $id));

        $pdo = Database::getConnection();
        if ($pdo) {
            try {
                $stmt = $pdo->prepare("DELETE FROM curriculo_etapas WHERE id = :id");
                $stmt->execute([':id' => $id]);
            } catch (Exception $e) {}
        }

        $file = Database::getFallbackStoragePath('etapas');
        file_put_contents($file, json_encode($filtered, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return true;
    }

    public static function reorder(array $orderedIds): array {
        $etapas = self::getAll();
        $map = [];
        foreach ($etapas as $e) {
            $map[$e['id']] = $e;
        }

        $newOrder = [];
        $order = 1;
        foreach ($orderedIds as $id) {
            if (isset($map[$id])) {
                $map[$id]['ordem'] = $order++;
                $newOrder[] = $map[$id];
                unset($map[$id]);
            }
        }
        foreach ($map as $remaining) {
            $remaining['ordem'] = $order++;
            $newOrder[] = $remaining;
        }

        $file = Database::getFallbackStoragePath('etapas');
        file_put_contents($file, json_encode($newOrder, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $newOrder;
    }
}
