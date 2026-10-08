import React from 'react';
import { useI18n } from '../../i18n/I18nContext';

export default function LattesResumido({ data, themeColor = '#0f766e' }) {
  const { t } = useI18n();

  const {
    dados_basicos: b = {},
    identificadores_lattes: lat = {},
    formacao_academica: formacoes = [],
    atuacao_profissional: atuacoes = [],
    producao_bibliografica: producoes = [],
    conhecimentos_idiomas: ci = {}
  } = data || {};

  return (
    <div className="lattes-resumido" style={{ '--theme-color': themeColor }}>
      {/* Box Superior Compacto */}
      <div className="header-box">
        <div>
          <h2 style={{ fontSize: '15pt', margin: 0, fontWeight: 800 }}>{b.nome || 'Pesquisador'}</h2>
          <div style={{ fontSize: '8.5pt', opacity: 0.9 }}>
            {formacoes[0]?.curso} | {t('lattesTemplate.idLattesLabel')} {lat.id_lattes || '----'} | {t('lattesTemplate.orcidLabel')} {lat.orcid || '----'}
          </div>
        </div>
        <div style={{ textAlign: 'right', fontSize: '8pt', opacity: 0.9 }}>
          <div>{b.email}</div>
          <div>{b.celular || b.telefone}</div>
        </div>
      </div>

      {/* Resumo Direto */}
      {(lat.resumo_academico || b.resumo_profissional) && (
        <div style={{ background: '#f8fafc', padding: '8px 12px', borderLeft: `3px solid ${themeColor}`, marginBottom: 12, fontSize: '8.5pt', textAlign: 'justify' }}>
          {lat.resumo_academico || b.resumo_profissional}
        </div>
      )}

      {/* Grid 2 Colunas de Alta Densidade */}
      <div className="grid-2col">
        <div>
          <h4 style={{ color: themeColor, borderBottom: '1px solid #cbd5e1', paddingBottom: 2, marginBottom: 6, fontSize: '9.5pt', textTransform: 'uppercase' }}>
            {t('lattesTemplate.educationTitle')}
          </h4>
          {formacoes.map((item, idx) => (
            <div key={idx} style={{ marginBottom: 6, fontSize: '8.5pt' }}>
              <strong>{item.nivel}: {item.curso}</strong>
              <div style={{ color: '#64748b', fontSize: '8pt' }}>{item.instituicao} ({item.ano_conclusao || item.ano_inicio})</div>
            </div>
          ))}

          <h4 style={{ color: themeColor, borderBottom: '1px solid #cbd5e1', paddingBottom: 2, margin: '10px 0 6px 0', fontSize: '9.5pt', textTransform: 'uppercase' }}>
            {t('lattesTemplate.experienceTitle')}
          </h4>
          {atuacoes.map((item, idx) => (
            <div key={idx} style={{ marginBottom: 6, fontSize: '8.5pt' }}>
              <strong>{item.cargo}</strong> — {item.empresa}
              <div style={{ color: '#64748b', fontSize: '8pt' }}>{item.ano_inicio} a {item.ano_fim || 'Atual'}</div>
            </div>
          ))}
        </div>

        <div>
          <h4 style={{ color: themeColor, borderBottom: '1px solid #cbd5e1', paddingBottom: 2, marginBottom: 6, fontSize: '9.5pt', textTransform: 'uppercase' }}>
            {t('lattesTemplate.publicationsTitle')}
          </h4>
          {producoes.slice(0, 5).map((item, idx) => (
            <div key={idx} style={{ marginBottom: 6, fontSize: '8pt', lineHeight: 1.4 }}>
              <strong>[{item.ano}]</strong> {item.titulo}. <em>{item.revista}</em>.
            </div>
          ))}

          {ci.idiomas && ci.idiomas.length > 0 && (
            <>
              <h4 style={{ color: themeColor, borderBottom: '1px solid #cbd5e1', paddingBottom: 2, margin: '10px 0 6px 0', fontSize: '9.5pt', textTransform: 'uppercase' }}>
                {t('lattesTemplate.languagesTitle')}
              </h4>
              <div style={{ fontSize: '8pt' }}>
                {ci.idiomas.map((i, idx) => (
                  <span key={idx} style={{ marginRight: 8 }}>
                    <strong>{i.idioma}:</strong> {i.nivel} |
                  </span>
                ))}
              </div>
            </>
          )}
        </div>
      </div>
    </div>
  );
}
