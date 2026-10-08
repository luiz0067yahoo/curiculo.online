# Mapeamento das Etapas do Currículo

As etapas do sistema foram mapeadas a partir dos arquivos HTML do backup (`#bkp/0.1`), enriquecidas com os campos e módulos do padrão oficial da Plataforma Lattes / CNPq.

| Nº | Etapa (Slug) | Origem no Backup | Campos Principais | Perfil |
|---|---|---|---|---|
| 1 | `dados_basicos` | `dados_basicos.html` | Nome, Sexo, E-mail, Data Nasc, Salário, Celular, Telefone, Redes Sociais | Todos |
| 2 | `identificadores_lattes` | Módulo CNPq | ID Lattes (16 dígitos), Link Lattes, ORCID, Scopus, Citações Bibliográficas, Resumo Acadêmico | Lattes |
| 3 | `formacao_academica` | `formacao_academica.html` | Nível (Graduação a Pós-Doc), Curso, Instituição, Anos, Orientador, Título Tese, Bolsa | Todos |
| 4 | `atuacao_profissional` | `experiencia_profissional.html` | Vínculos, Empresas/Universidades, Cargo, Período, Regime (40h DE), Descrição | Todos |
| 5 | `linhas_pesquisa` | Módulo CNPq | Grande Área, Área, Subárea, Linha de Pesquisa | Lattes |
| 6 | `producao_bibliografica` | Módulo CNPq | Artigos em periódicos, Livros, Capítulos, Trabalhos em eventos, DOI, Qualis, Autores ABNT | Lattes |
| 7 | `projetos_pesquisa` | Módulo CNPq | Título, Agência de Fomento (CNPq, CAPES, FAPESP), Anos, Coordenador, Resumo | Lattes |
| 8 | `conhecimentos_idiomas` | `conhecimentos.html` | Idiomas (fluência, compreensão, fala, escrita), Conhecimentos técnicos e ferramentas | Todos |
| 9 | `cargo_pretendido` | `cargo_pretendido.html` | Área pretendida, Cargo almejado, Disponibilidade | Corporativo |
| 10 | `dados_pessoais` | `dados_pessoais.html` | Estado civil, Dependentes, Viagens, Mudança, Foto URL, Endereço completo | Todos |
