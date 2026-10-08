import React from 'react';
import { useI18n } from '../../i18n/I18nContext';

export default function LattesMinimalista({ data }) {
  const { t } = useI18n();

  const {
    dados_basicos: b = {},
    identificadores_lattes: lat = {},
    formacao_academica: formacoes = [],
    atuacao_profissional: atuacoes = [],
    producao_bibliografica: producoes = []
  } = data || {};

  return (
    <div className="lattes-minimalista">
      <div className="min-header">
        <h1 className="min-title">{b.nome || 'Nome Completo'}</h1>
        <div style={{ fontSize: '9pt', color: '#444', marginTop: 4 }}>
          {b.email} • {b.celular || b.telefone} • {t('lattesTemplate.idLattesLabel')} {lat.id_lattes || '----'} • {t('lattesTemplate.orcidLabel')} {lat.orcid || '----'}
        </div>
      </div>

      {(lat.resumo_academico || b.resumo_profissional) && (
        <div style={{ marginBottom: 16 }}>
          <div className="min-section-title">{t('lattesTemplate.summaryTitle')}</div>
          <p style={{ fontSize: '9.5pt', textAlign: 'justify', lineHeight: 1.6 }}>
            {lat.resumo_academico || b.resumo_profissional}
          </p>
        </div>
      )}

      {formacoes.length > 0 && (
        <div style={{ marginBottom: 16 }}>
          <div className="min-section-title">{t('lattesTemplate.educationTitle')}</div>
          {formacoes.map((item, idx) => (
            <div key={idx} style={{ marginBottom: 8, fontSize: '9.5pt' }}>
              <div style={{ display: 'flex', justifyContent: 'space-between' }}>
                <strong>{item.curso}</strong>
                <span>{item.ano_inicio}–{item.ano_conclusao || 'Atual'}</span>
              </div>
              <div style={{ fontStyle: 'italic', color: '#555' }}>
                {item.instituicao} ({item.nivel_label || item.nivel})
              </div>
              {item.titulo_tese && (
                <div style={{ fontSize: '8.5pt', color: '#666' }}>
                  {t('lattesTemplate.thesisLabel')} "{item.titulo_tese}" ({t('lattesTemplate.advisorLabel')} {item.orientador || '—'})
                </div>
              )}
            </div>
          ))}
        </div>
      )}

      {atuacoes.length > 0 && (
        <div style={{ marginBottom: 16 }}>
          <div className="min-section-title">{t('lattesTemplate.experienceTitle')}</div>
          {atuacoes.map((item, idx) => (
            <div key={idx} style={{ marginBottom: 8, fontSize: '9.5pt' }}>
              <div style={{ display: 'flex', justifyContent: 'space-between' }}>
                <strong>{item.empresa}</strong>
                <span>{item.ano_inicio}–{item.ano_fim || 'Atual'}</span>
              </div>
              <div style={{ fontStyle: 'italic', color: '#555' }}>
                {item.cargo} {item.regime && `(${item.regime})`}
              </div>
              {item.descricao && <div style={{ fontSize: '8.5pt', color: '#444' }}>{item.descricao}</div>}
            </div>
          ))}
        </div>
      )}

      {producoes.length > 0 && (
        <div style={{ marginBottom: 16 }}>
          <div className="min-section-title">{t('lattesTemplate.publicationsTitle')}</div>
          {producoes.map((item, idx) => (
            <div key={idx} style={{ fontSize: '9pt', marginBottom: 6, lineHeight: 1.5 }}>
              {idx + 1}. {item.autores || b.nome}. <strong>{item.titulo}</strong>. <em>{item.revista}</em>, {item.ano}.
            </div>
          ))}
        </div>
      )}
    </div>
  );
}
