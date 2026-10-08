import React from 'react';
import { useI18n } from '../../i18n/I18nContext';

export default function LattesHibrido({ data, themeColor = '#334155' }) {
  const { t } = useI18n();

  const {
    dados_basicos: b = {},
    identificadores_lattes: lat = {},
    formacao_academica: formacoes = [],
    atuacao_profissional: atuacoes = [],
    linhas_pesquisa: linhas = [],
    producao_bibliografica: producoes = [],
    conhecimentos_idiomas: ci = {},
    cargo_pretendido: cp = {}
  } = data || {};

  return (
    <div className="lattes-hibrido" style={{ '--theme-color': themeColor }}>
      {/* Header Corporativo / Acadêmico */}
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'flex-start', borderBottom: '2px solid #0f172a', paddingBottom: 14, marginBottom: 16 }}>
        <div>
          <h1 style={{ fontSize: '18pt', fontWeight: 800, color: '#0f172a', margin: 0 }}>
            {b.nome || 'Nome Completo'}
          </h1>
          <div style={{ fontSize: '10.5pt', fontWeight: 600, color: themeColor, marginTop: 4 }}>
            {cp.cargo_pretendido || 'Pesquisa Aplicada & Liderança Tecnológica'}
          </div>
          <div style={{ fontSize: '8.5pt', color: '#64748b', marginTop: 4 }}>
            {t('lattesTemplate.idLattesLabel')} {lat.id_lattes || '----'} • {t('lattesTemplate.orcidLabel')} {lat.orcid || '----'} • {b.email} • {b.celular || b.telefone}
          </div>
        </div>
        <div style={{ textAlign: 'right' }}>
          <span style={{ background: '#0f172a', color: '#fff', fontSize: '7.5pt', padding: '4px 8px', borderRadius: 4, fontWeight: 700, textTransform: 'uppercase' }}>
            {t('lattesTemplate.hybridProfileBadge')}
          </span>
        </div>
      </div>

      {/* Trajetória & Visão */}
      {(lat.resumo_academico || b.resumo_profissional) && (
        <div style={{ marginBottom: 14 }}>
          <h3 style={{ fontSize: '10.5pt', textTransform: 'uppercase', color: '#0f172a', letterSpacing: 0.5, borderBottom: '1px solid #e2e8f0', paddingBottom: 4, marginBottom: 6 }}>
            {t('lattesTemplate.summaryTitle')}
          </h3>
          <p style={{ fontSize: '9pt', color: '#334155', lineHeight: 1.6, textAlign: 'justify' }}>
            {lat.resumo_academico || b.resumo_profissional}
          </p>
        </div>
      )}

      {/* Competências Tecnológicas & Metodológicas */}
      {ci.conhecimentos && ci.conhecimentos.length > 0 && (
        <div style={{ marginBottom: 14 }}>
          <h3 style={{ fontSize: '10.5pt', textTransform: 'uppercase', color: '#0f172a', letterSpacing: 0.5, borderBottom: '1px solid #e2e8f0', paddingBottom: 4, marginBottom: 6 }}>
            {t('lattesTemplate.hybridStackTitle')}
          </h3>
          <div>
            {ci.conhecimentos.map((c, idx) => (
              <span key={idx} className="hybrid-badge">
                {c.nome || c} ({c.nivel})
              </span>
            ))}
          </div>
        </div>
      )}

      {/* Atuação e Liderança */}
      {atuacoes.length > 0 && (
        <div style={{ marginBottom: 14 }}>
          <h3 style={{ fontSize: '10.5pt', textTransform: 'uppercase', color: '#0f172a', letterSpacing: 0.5, borderBottom: '1px solid #e2e8f0', paddingBottom: 4, marginBottom: 6 }}>
            {t('lattesTemplate.hybridLeadershipTitle')}
          </h3>
          {atuacoes.map((item, idx) => (
            <div key={idx} style={{ marginBottom: 8, fontSize: '9pt' }}>
              <div style={{ display: 'flex', justifyContent: 'space-between', fontWeight: 'bold' }}>
                <span>{item.cargo} — {item.empresa}</span>
                <span style={{ color: '#64748b' }}>{item.ano_inicio} - {item.ano_fim || 'Atual'}</span>
              </div>
              {item.descricao && <div style={{ fontSize: '8.5pt', color: '#475569', marginTop: 2 }}>{item.descricao}</div>}
            </div>
          ))}
        </div>
      )}

      {/* Formação Acadêmica */}
      {formacoes.length > 0 && (
        <div style={{ marginBottom: 14 }}>
          <h3 style={{ fontSize: '10.5pt', textTransform: 'uppercase', color: '#0f172a', letterSpacing: 0.5, borderBottom: '1px solid #e2e8f0', paddingBottom: 4, marginBottom: 6 }}>
            {t('lattesTemplate.educationTitle')}
          </h3>
          {formacoes.map((item, idx) => (
            <div key={idx} style={{ marginBottom: 6, fontSize: '8.5pt' }}>
              <strong>{item.nivel}: {item.curso}</strong> — {item.instituicao} ({item.ano_conclusao || item.ano_inicio})
              {item.titulo_tese && <div style={{ color: '#64748b', fontSize: '8pt' }}>{t('lattesTemplate.thesisLabel')} {item.titulo_tese}</div>}
            </div>
          ))}
        </div>
      )}

      {/* Publicações Destacadas */}
      {producoes.length > 0 && (
        <div>
          <h3 style={{ fontSize: '10.5pt', textTransform: 'uppercase', color: '#0f172a', letterSpacing: 0.5, borderBottom: '1px solid #e2e8f0', paddingBottom: 4, marginBottom: 6 }}>
            {t('lattesTemplate.publicationsTitle')}
          </h3>
          {producoes.slice(0, 4).map((item, idx) => (
            <div key={idx} style={{ fontSize: '8pt', marginBottom: 4, color: '#334155' }}>
              • <strong>{item.titulo}</strong>. <em>{item.revista}</em>, {item.ano}. {item.doi && `(DOI: ${item.doi})`}
            </div>
          ))}
        </div>
      )}
    </div>
  );
}
