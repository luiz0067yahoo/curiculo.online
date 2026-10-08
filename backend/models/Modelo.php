<?php
require_once __DIR__ . '/../config/Database.php';

class ModeloModel {
    private static function getInitialModelos(): array {
        return [
            [
                'id' => 1,
                'slug' => 'lattes-tradicional',
                'nome' => 'Lattes Tradicional (Padrão CNPq)',
                'descricao' => 'Estrutura formal e canônica inspirada na Plataforma Lattes / CNPq, com cabeçalho oficial, dados cadastrais completos, resumo corrido e citações no padrão ABNT.',
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
                'descricao' => 'Layout moderno de duas colunas, barra lateral elegante para foto, links ORCID/Lattes, métricas acadêmicas e corpo com timeline cronológica.',
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
                'descricao' => 'Síntese objetiva de alta performance para editais de fomento, bolsas e bancas avaliadoras com restrição de laudas.',
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
                'descricao' => 'Conecta projetos científicos e publicações a competências corporativas e experiência profissional na indústria e startups.',
                'categoria' => 'Híbrido P&D',
                'badge' => 'Tech & Inovação',
                'cor_padrao' => '#334155',
                'ativo' => 1,
                'ordem' => 4
            ],
            [
                'id' => 5,
                'slug' => 'lattes-minimalista',
                'nome' => 'Lattes Minimalista Monocromático',
                'descricao' => 'Design tipográfico refinado com fontes serifadas de alta legibilidade, otimizado para impressão oficial direta e leitura contínua.',
                'categoria' => 'Minimalista',
                'badge' => 'Editorial',
                'cor_padrao' => '#111827',
                'ativo' => 1,
                'ordem' => 5
            ]
        ];
    }

    public static function getAll(): array {
        $pdo = Database::getConnection();
        if ($pdo) {
            try {
                $stmt = $pdo->query("SELECT * FROM curriculo_modelos WHERE ativo = 1 ORDER BY ordem ASC");
                $rows = $stmt->fetchAll();
                if (!empty($rows)) {
                    return $rows;
                }
            } catch (Exception $e) {}
        }

        $file = Database::getFallbackStoragePath('modelos');
        if (file_exists($file)) {
            $data = json_decode(file_get_contents($file), true);
            if (is_array($data)) return $data;
        }

        $initial = self::getInitialModelos();
        file_put_contents($file, json_encode($initial, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        return $initial;
    }
}
