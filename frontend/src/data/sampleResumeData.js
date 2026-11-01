/**
 * Estrutura vazia padrão para o formulário de currículo.
 * Todos os campos iniciam limpos, sem dados pré-preenchidos.
 */
export const EMPTY_RESUME_DATA = {
  dados_basicos: {
    nome: '',
    sexo: '',
    email: '',
    foto_url: '',
    foto_exibir: true,
    foto_zoom: 1,
    foto_x: 0,
    foto_y: 0,
    foto_formato: 'circulo',
    foto_aro: true,
    data_nascimento: '',
    pretensao_salarial: '',
    celular: '',
    telefone: '',
    linkedin: '',
    github: '',
    facebook: '',
    website: ''
  },
  identificadores_lattes: {
    id_lattes: '',
    link_lattes: '',
    orcid: '',
    scopus_id: '',
    citacoes_bibliograficas: '',
    resumo_academico: ''
  },
  formacao_academica: [],
  atuacao_profissional: [],
  linhas_pesquisa: [],
  producao_bibliografica: [],
  projetos_pesquisa: [],
  conhecimentos_idiomas: {
    idiomas: [],
    conhecimentos: []
  },
  cargo_pretendido: {
    area_pretendida: '',
    cargo_pretendido: '',
    tipo_contratacao: '',
    disponibilidade_inicio: ''
  },
  dados_pessoais: {
    estado_civil: '',
    filhos: '',
    aceita_viajar: false,
    disponivel_mudanca: false,
    foto_url: '',
    endereco: {
      cep: '',
      rua: '',
      numero: '',
      complemento: '',
      bairro: '',
      cidade: '',
      estado: ''
    }
  }
};

// Garantir que referências legadas a SAMPLE_RESUME_DATA também retornem a estrutura limpa
export const SAMPLE_RESUME_DATA = EMPTY_RESUME_DATA;
