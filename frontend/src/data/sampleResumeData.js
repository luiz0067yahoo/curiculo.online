export const SAMPLE_RESUME_DATA = {
  dados_basicos: {
    nome: 'Dr. Leonardo Albuquerque Silveira',
    sexo: 'Masculino',
    email: 'leonardo.albuquerque@pesquisa.online',
    data_nascimento: '1988-06-14',
    pretensao_salarial: '16.500,00',
    celular: '(11) 98765-4321',
    telefone: '(11) 3214-5678',
    linkedin: 'linkedin.com/in/leonardo-albuquerque',
    github: 'github.com/leosilveira-phd',
    facebook: 'facebook.com/prof.leonardo.silveira',
    website: 'https://curiculo.online/lattes/leonardo-silveira'
  },
  identificadores_lattes: {
    id_lattes: '4918237401928472',
    link_lattes: 'http://lattes.cnpq.br/4918237401928472',
    orcid: '0000-0002-1825-0097',
    scopus_id: '57201948201',
    citacoes_bibliograficas: 'SILVEIRA, L. A.; SILVEIRA, Leonardo A.; ALBUQUERQUE, L.',
    resumo_academico: 'Doutor em Ciência da Computação pela Universidade de São Paulo (USP) e Mestre em Engenharia Elétrica pela UNICAMP. Possui graduação em Sistemas de Informação pela UNESP. Atualmente é Pesquisador Sênior e Professor Adjunto, coordenando projetos na intersecção entre Inteligência Artificial, Processamento de Linguagem Natural e Sistemas Distribuídos de Alto Desempenho. Bolsista de Produtividade em Pesquisa do CNPq, com mais de 30 artigos publicados em periódicos de impacto internacional e congressos Qualis A1/A2.'
  },
  formacao_academica: [
    {
      id: 1,
      nivel: 'Doutorado',
      nivel_label: 'Doutorado em Ciência da Computação',
      curso: 'Ciência da Computação (Inteligência Artificial)',
      instituicao: 'Universidade de São Paulo (USP)',
      ano_inicio: '2016',
      ano_conclusao: '2020',
      situacao: 'Concluído',
      orientador: 'Prof. Dr. Carlos Eduardo de Moura',
      titulo_tese: 'Arquiteturas Neurais Eficientes para Compreensão Semântica em Larga Escala',
      bolsa: 'Bolsista CNPq'
    },
    {
      id: 2,
      nivel: 'Mestrado',
      nivel_label: 'Mestrado em Engenharia Elétrica e de Computação',
      curso: 'Engenharia de Computação',
      instituicao: 'Universidade Estadual de Campinas (UNICAMP)',
      ano_inicio: '2013',
      ano_conclusao: '2015',
      situacao: 'Concluído',
      orientador: 'Profa. Dra. Mariana Vasconcelos',
      titulo_tese: 'Otimização de Algoritmos Distribuídos em Ambientes Heterogêneos de Alta Concorrência',
      bolsa: 'Bolsista FAPESP'
    },
    {
      id: 3,
      nivel: 'Ensino_Superior',
      nivel_label: 'Graduação em Bacharelado em Sistemas de Informação',
      curso: 'Sistemas de Informação',
      instituicao: 'Universidade Estadual Paulista (UNESP)',
      ano_inicio: '2008',
      ano_conclusao: '2012',
      situacao: 'Concluído',
      orientador: 'Prof. Dr. Roberto Guimarães',
      titulo_tese: 'Plataforma Web Escalável para Gestão e Recuperação de Informação Acadêmica',
      bolsa: 'Iniciação Científica PIBIC/CNPq'
    }
  ],
  atuacao_profissional: [
    {
      id: 1,
      empresa: 'Instituto Tecnológico de Pesquisa Avançada (ITPA)',
      cargo: 'Pesquisador Sênior & Líder de P&D',
      ano_inicio: '2021',
      ano_fim: 'Atual',
      regime: 'Dedicação Exclusiva (40h semanais)',
      descricao: 'Liderança de equipe multidisciplinar focada no desenvolvimento de modelos de linguagem, arquiteturas seguras para dados em nuvem e transferência de tecnologia para o setor produtivo.'
    },
    {
      id: 2,
      empresa: 'Universidade Federal de Tecnologia (UFT)',
      cargo: 'Professor Adjunto Convidado',
      ano_inicio: '2020',
      ano_fim: 'Atual',
      regime: '20 horas semanais',
      descricao: 'Docência nas disciplinas de Algoritmos Avançados, Aprendizado de Máquina e Orientação de discentes em programas de iniciação científica e pós-graduação.'
    },
    {
      id: 3,
      empresa: 'Nexus Data Analytics & Soluções',
      cargo: 'Especialista em Engenharia de Software e Dados',
      ano_inicio: '2015',
      ano_fim: '2019',
      regime: 'Tempo Parcial',
      descricao: 'Desenvolvimento de microsserviços em PHP, Python e React, implementação de pipelines de dados em tempo real e arquitetura de bancos de dados MySQL e NoSQL.'
    }
  ],
  linhas_pesquisa: [
    { id: 1, grande_area: 'Ciências Exatas e da Terra', area: 'Ciência da Computação', subarea: 'Metodologia e Técnicas da Computação', nome: 'Processamento de Linguagem Natural e LLMs' },
    { id: 2, grande_area: 'Ciências Exatas e da Terra', area: 'Ciência da Computação', subarea: 'Sistemas de Computação', nome: 'Sistemas Distribuídos e Computação em Nuvem' },
    { id: 3, grande_area: 'Engenharias', area: 'Engenharia Biomédica', subarea: 'Bioinformática', nome: 'Mineração de Dados e Inteligência Aplicada à Saúde' }
  ],
  producao_bibliografica: [
    {
      id: 1,
      tipo: 'Artigo em Periódico',
      titulo: 'Scalable Neural Representations for Cross-Lingual Semantic Retrieval in Academic Repositories',
      revista: 'IEEE Transactions on Knowledge and Data Engineering',
      ano: '2025',
      volume: '37',
      paginas: '1420-1434',
      doi: '10.1109/TKDE.2025.3129841',
      autores: 'SILVEIRA, L. A.; MOURA, C. E.; VASCONCELOS, M.',
      qualis: 'Qualis A1'
    },
    {
      id: 2,
      tipo: 'Artigo em Periódico',
      titulo: 'Distributed Consensus and Efficient Synchronization in Ultra-Low Latency Cloud Architectures',
      revista: 'Journal of Systems and Software (Elsevier)',
      ano: '2023',
      volume: '198',
      paginas: '111580',
      doi: '10.1016/j.jss.2023.111580',
      autores: 'SILVEIRA, L. A.; SANTOS, P. R.; ALBUQUERQUE, L.',
      qualis: 'Qualis A1'
    },
    {
      id: 3,
      tipo: 'Capítulo de Livro',
      titulo: 'Arquiteturas Modernas para Engenharia de Dados e Machine Learning em Nuvem',
      revista: 'Avanços em Inteligência Computacional no Brasil (Editora Springer)',
      ano: '2022',
      volume: '1',
      paginas: '45-72',
      doi: '10.1007/978-3-030-91283-1_3',
      autores: 'SILVEIRA, L. A.; MOURA, C. E.',
      qualis: 'Livro Internacional'
    },
    {
      id: 4,
      tipo: 'Trabalho em Evento',
      titulo: 'Otimização de Consultas Distribuídas em Ambientes Web de Alta Concorrência',
      revista: 'Simpósio Brasileiro de Banco de Dados (SBBD)',
      ano: '2021',
      volume: '36',
      paginas: '89-98',
      doi: '10.5753/sbbd.2021.17890',
      autores: 'SILVEIRA, L. A.; GUIMARAES, R.',
      qualis: 'Qualis A2'
    }
  ],
  projetos_pesquisa: [
    {
      id: 1,
      titulo: 'Plataforma Inteligente de Curadoria e Geração Automática de Currículos Científicos',
      ano_inicio: '2023',
      ano_fim: 'Atual',
      fomento: 'CNPq - Chamada Universal',
      coordenador: 'Leonardo Albuquerque Silveira',
      descricao: 'Pesquisa e implementação de modelos de IA para unificação e estruturação de dados acadêmicos com foco em padronização Lattes e interoperabilidade com padrões abertos.'
    },
    {
      id: 2,
      titulo: 'Arquiteturas Resilientes para Microserviços e Bancos de Dados Relacionais Híbridos',
      ano_inicio: '2021',
      ano_fim: '2023',
      fomento: 'FAPESP (Auxílio Regular)',
      coordenador: 'Carlos Eduardo de Moura',
      descricao: 'Análise empírica de benchmarks de concorrência com MySQL, PostgreSQL e persistência em cache distribuído.'
    }
  ],
  conhecimentos_idiomas: {
    idiomas: [
      { id: 1, idioma: 'Português', nivel: 'Nativo / Fluente', compreensao: 'Excelente', fala: 'Excelente', escrita: 'Excelente' },
      { id: 2, idioma: 'Inglês', nivel: 'Fluente (C2)', compreensao: 'Excelente', fala: 'Excelente', escrita: 'Excelente' },
      { id: 3, idioma: 'Espanhol', nivel: 'Intermediário / Avançado (B2)', compreensao: 'Boa', fala: 'Razoável', escrita: 'Boa' }
    ],
    conhecimentos: [
      { id: 1, nome: 'PHP 8+ & Arquiteturas MVC / REST', nivel: 'Avançado' },
      { id: 2, nome: 'MySQL / MariaDB & Modelagem Relacional', nivel: 'Avançado' },
      { id: 3, nome: 'JavaScript (ES6+) & React Web', nivel: 'Avançado' },
      { id: 4, nome: 'Python & Ciência de Dados / IA (PyTorch)', nivel: 'Avançado' },
      { id: 5, nome: 'Metodologias Científicas & Normas ABNT', nivel: 'Especialista' },
      { id: 6, nome: 'Docker, Linux & Cloud Computing (GCP/AWS)', nivel: 'Intermediário' }
    ]
  },
  cargo_pretendido: {
    area_pretendida: 'Ciência de Dados, Pesquisa & Desenvolvimento (P&D) / Docência Superior',
    cargo_pretendido: 'Pesquisador Sênior / Professor Titular / Arquiteto de Soluções Científicas',
    tipo_contratacao: 'Dedicação Exclusiva / CLT / Contrato de Pesquisa',
    disponibilidade_inicio: 'Imediata'
  },
  dados_pessoais: {
    estado_civil: 'Casado(a)',
    filhos: '1',
    aceita_viajar: true,
    disponivel_mudanca: true,
    foto_url: 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=400',
    endereco: {
      cep: '01310-100',
      rua: 'Av. Paulista',
      numero: '1842',
      complemento: 'Bloco B, Sala 1402',
      bairro: 'Bela Vista',
      cidade: 'São Paulo',
      estado: 'SP'
    }
  }
};
