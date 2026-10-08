import React from 'react';
import { useI18n } from '../../i18n/I18nContext';

export default function LattesTradicional({ data, themeColor = '#0f3a68' }) {
  const { t, language } = useI18n();

  const {
    dados_basicos: b = {},
    identificadores_lattes: lat = {},
    formacao_academica: formacoes = [],
    atuacao_profissional: atuacoes = [],
    linhas_pesquisa: linhas = [],
    producao_bibliografica: producoes = [],
    projetos_pesquisa: projetos = [],
    conhecimentos_idiomas: ci = {}
  } = data || {};

  const idiomas = ci.idiomas || [];
  const dateLocale = language === 'pt' ? 'pt-BR' : language === 'es' ? 'es-ES' : language === 'it' ? 'it-IT' : 'en-US';

  return (
    <div className="lattes-tradicional" style={{ '--theme-color': themeColor }}>
      {/* Cabeçalho Institucional Padrão CNPq */}
      <div className="cnpq-header-bar">
        <div>
          <div className="cnpq-badge-title">{t('lattesTemplate.title')}</div>
          <div className="cnpq-sub-header">{t('lattesTemplate.agencyHeader')}</div>
        </div>
        <div style={{ textAlign: 'right', fontSize: '8pt', color: '#64748b' }}>
          <div>{t('lattesTemplate.lastUpdate')} {new Date().toLocaleDateString(dateLocale)}</div>
          {lat.id_lattes && <div style={{ fontWeight: 'bold' }}>{t('lattesTemplate.idLattesLabel')} {lat.id_lattes}</div>}
        </div>
      </div>

      {/* Nome e Dados Cadastrais */}
      <div className="lattes-name-title">{b.nome || 'Nome Completo do Pesquisador'}</div>
      
      <div className="lattes-meta-grid">
        <div><strong>{t('lattesTemplate.citationLabel')}</strong> {lat.citacoes_bibliograficas || b.nome}</div>
        <div><strong>{t('lattesTemplate.emailLabel')}</strong> {b.email || '—'}</div>
        <div><strong>{t('lattesTemplate.orcidLabel')}</strong> {lat.orcid || '—'}</div>
        <div><strong>{t('lattesTemplate.phoneLabel')}</strong> {b.celular || b.telefone || '—'}</div>
        {lat.link_lattes && (
          <div style={{ gridColumn: 'span 2' }}>
            <strong>{t('lattesTemplate.addressUrlLabel')}</strong>{' '}
            <a href={lat.link_lattes} target="_blank" rel="noreferrer" style={{ color: themeColor }}>
              {lat.link_lattes}
            </a>
          </div>
        )}
      </div>

      {/* Resumo Acadêmico */}
      {(lat.resumo_academico || b.resumo_profissional) && (
        <div style={{ marginBottom: 14 }}>
          <div className="lattes-section-title">{t('lattesTemplate.summaryTitle')}</div>
          <p className="lattes-text-justified">
            {lat.resumo_academico || b.resumo_profissional}
          </p>
        </div>
      )}

      {/* Formação Acadêmica / Titulação */}
      {formacoes.length > 0 && (
        <div>
          <div className="lattes-section-title">{t('lattesTemplate.educationTitle')}</div>
          {formacoes.map((item, idx) => (
            <div key={idx} className="lattes-item-row">
              <span className="lattes-item-years">
                {item.ano_inicio || '----'} - {item.ano_conclusao || 'Atual'}:
              </span>{' '}
              <strong>{item.nivel_label || item.nivel || 'Formação'}:</strong> {item.curso}
              <br />
              <span style={{ color: '#475569', fontSize: '9pt' }}>
                {item.instituicao}
                {item.titulo_tese && <span>. <em>{t('lattesTemplate.thesisLabel')} {item.titulo_tese}</em></span>}
                {item.orientador && <span>. {t('lattesTemplate.advisorLabel')} {item.orientador}</span>}
                {item.bolsa && <span>. ({item.bolsa})</span>}
              </span>
            </div>
          ))}
        </div>
      )}

      {/* Atuação Profissional */}
      {atuacoes.length > 0 && (
        <div>
          <div className="lattes-section-title">{t('lattesTemplate.experienceTitle')}</div>
          {atuacoes.map((item, idx) => (
            <div key={idx} className="lattes-item-row">
              <span className="lattes-item-years">
                {item.ano_inicio || '----'} - {item.ano_fim || 'Atual'}:
              </span>{' '}
              <strong>{item.empresa}</strong>
              <br />
              <span style={{ fontSize: '9pt', color: '#334155' }}>
                Vínculo: {item.cargo} {item.regime && `(${item.regime})`}
              </span>
              {item.descricao && (
                <div style={{ fontSize: '9pt', marginTop: 4, color: '#475569' }}>
                  {item.descricao}
                </div>
              )}
            </div>
          ))}
        </div>
      )}

      {/* Linhas de Pesquisa */}
      {linhas.length > 0 && (
        <div>
          <div className="lattes-section-title">{t('lattesTemplate.researchLinesTitle')}</div>
          <ul style={{ paddingLeft: 20, fontSize: '9.5pt', margin: '6px 0' }}>
            {linhas.map((item, idx) => (
              <li key={idx} style={{ marginBottom: 4 }}>
                <strong>{item.nome || item}</strong>
                {item.grande_area && <span style={{ color: '#64748b' }}> — {item.grande_area} / {item.area}</span>}
              </li>
            ))}
          </ul>
        </div>
      )}

      {/* Produção Bibliográfica (Artigos ABNT) */}
      {producoes.length > 0 && (
        <div>
          <div className="lattes-section-title">{t('lattesTemplate.publicationsTitle')}</div>
          {producoes.map((item, idx) => (
            <div key={idx} className="lattes-citation">
              <strong>{idx + 1}.</strong> {item.autores || b.nome}. <strong>{item.titulo}</strong>.{' '}
              <em>{item.revista}</em>, v. {item.volume || '1'}, p. {item.paginas || '-'}, {item.ano}.
              {item.doi && <span style={{ color: '#64748b', fontSize: '8.5pt' }}> DOI: {item.doi}</span>}
              {item.qualis && <span style={{ marginLeft: 8, fontSize: '8pt', color: themeColor, fontWeight: 'bold' }}>[{item.qualis}]</span>}
            </div>
          ))}
        </div>
      )}

      {/* Projetos de Pesquisa */}
      {projetos.length > 0 && (
        <div>
          <div className="lattes-section-title">{t('lattesTemplate.projectsTitle')}</div>
          {projetos.map((item, idx) => (
            <div key={idx} className="lattes-item-row">
              <span className="lattes-item-years">{item.ano_inicio} - {item.ano_fim || 'Atual'}:</span>{' '}
              <strong>{item.titulo}</strong>
              <div style={{ fontSize: '8.5pt', color: '#475569', marginTop: 2 }}>
                {item.descricao}
                {item.fomento && <span>. {t('lattesTemplate.fundingLabel')} <strong>{item.fomento}</strong></span>}
              </div>
            </div>
          ))}
        </div>
      )}

      {/* Idiomas */}
      {idiomas.length > 0 && (
        <div>
          <div className="lattes-section-title">{t('lattesTemplate.languagesTitle')}</div>
          <div style={{ fontSize: '9pt', display: 'flex', flexWrap: 'wrap', gap: 16 }}>
            {idiomas.map((item, idx) => (
              <div key={idx}>
                <strong>{item.idioma}:</strong> {item.nivel || 'Compreende e fala'}
              </div>
            ))}
          </div>
        </div>
      )}
    </div>
  );
}
