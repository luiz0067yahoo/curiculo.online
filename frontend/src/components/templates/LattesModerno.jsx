import React from 'react';
import { useI18n } from '../../i18n/I18nContext';

export default function LattesModerno({ data, themeColor = '#1e40af' }) {
  const { t } = useI18n();

  const {
    dados_basicos: b = {},
    identificadores_lattes: lat = {},
    formacao_academica: formacoes = [],
    atuacao_profissional: atuacoes = [],
    linhas_pesquisa: linhas = [],
    producao_bibliografica: producoes = [],
    conhecimentos_idiomas: ci = {},
    dados_pessoais: dp = {}
  } = data || {};

  const photo = dp.foto_url || 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=400';

  return (
    <div className="lattes-moderno" style={{ '--theme-color': themeColor }}>
      {/* Coluna Esquerda / Lateral */}
      <div className="sidebar">
        {photo && (
          <img src={photo} alt="Foto de perfil" className="sidebar-photo" />
        )}

        <div>
          <div className="sidebar-title">{t('lattesTemplate.identificationTitle')}</div>
          <div style={{ fontSize: '8.5pt', lineHeight: 1.6 }}>
            {lat.id_lattes && <div><strong>{t('lattesTemplate.idLattesLabel')}</strong><br />{lat.id_lattes}</div>}
            {lat.orcid && <div style={{ marginTop: 4 }}><strong>{t('lattesTemplate.orcidLabel')}</strong><br />{lat.orcid}</div>}
            {lat.scopus_id && <div style={{ marginTop: 4 }}><strong>Scopus:</strong> {lat.scopus_id}</div>}
          </div>
        </div>

        <div>
          <div className="sidebar-title">{t('lattesTemplate.contactsTitle')}</div>
          <div style={{ fontSize: '8.5pt', lineHeight: 1.6 }}>
            <div>{b.email}</div>
            <div>{b.celular || b.telefone}</div>
            {b.linkedin && <div>{b.linkedin}</div>}
            {b.github && <div>{b.github}</div>}
            {dp.endereco && (
              <div style={{ marginTop: 6, color: '#64748b' }}>
                {dp.endereco.cidade} - {dp.endereco.estado}
              </div>
            )}
          </div>
        </div>

        {linhas.length > 0 && (
          <div>
            <div className="sidebar-title">{t('lattesTemplate.researchLinesTitle')}</div>
            <div style={{ display: 'flex', flexDirection: 'column', gap: 4, fontSize: '8pt' }}>
              {linhas.map((l, idx) => (
                <div key={idx} style={{ background: '#e2e8f0', padding: '3px 6px', borderRadius: 4, fontWeight: 500 }}>
                  {l.nome || l}
                </div>
              ))}
            </div>
          </div>
        )}

        {ci.idiomas && ci.idiomas.length > 0 && (
          <div>
            <div className="sidebar-title">{t('lattesTemplate.languagesTitle')}</div>
            <div style={{ fontSize: '8.5pt' }}>
              {ci.idiomas.map((i, idx) => (
                <div key={idx} style={{ marginBottom: 4 }}>
                  <strong>{i.idioma}:</strong> {i.nivel}
                </div>
              ))}
            </div>
          </div>
        )}

        {ci.conhecimentos && ci.conhecimentos.length > 0 && (
          <div>
            <div className="sidebar-title">{t('lattesTemplate.skillsTitle')}</div>
            <div style={{ display: 'flex', flexWrap: 'wrap', gap: 4 }}>
              {ci.conhecimentos.map((c, idx) => (
                <span key={idx} style={{ fontSize: '7.5pt', background: '#e0f2fe', color: '#0369a1', padding: '2px 6px', borderRadius: 4, fontWeight: 600 }}>
                  {c.nome || c}
                </span>
              ))}
            </div>
          </div>
        )}
      </div>

      {/* Coluna Principal / Direita */}
      <div className="main-col">
        <div className="hero-name">{b.nome || 'Nome Completo'}</div>
        <div className="hero-role">
          {formacoes[0]?.nivel_label || formacoes[0]?.curso || t('lattesTemplate.researchSubtitle')}
        </div>

        {(lat.resumo_academico || b.resumo_profissional) && (
          <div style={{ marginBottom: 16 }}>
            <p style={{ fontSize: '9pt', color: '#334155', lineHeight: 1.6, textAlign: 'justify' }}>
              {lat.resumo_academico || b.resumo_profissional}
            </p>
          </div>
        )}

        {formacoes.length > 0 && (
          <div>
            <div className="section-heading">{t('lattesTemplate.educationTitle')}</div>
            {formacoes.map((item, idx) => (
              <div key={idx} style={{ marginBottom: 10 }}>
                <div style={{ display: 'flex', justifyContent: 'space-between', fontSize: '9pt', fontWeight: 'bold' }}>
                  <span>{item.curso}</span>
                  <span style={{ color: themeColor }}>{item.ano_inicio} - {item.ano_conclusao || 'Atual'}</span>
                </div>
                <div style={{ fontSize: '8.5pt', color: '#475569' }}>
                  {item.instituicao} ({item.nivel_label || item.nivel})
                </div>
                {item.titulo_tese && (
                  <div style={{ fontSize: '8pt', color: '#64748b', fontStyle: 'italic', marginTop: 2 }}>
                    {t('lattesTemplate.thesisLabel')} {item.titulo_tese}
                  </div>
                )}
              </div>
            ))}
          </div>
        )}

        {atuacoes.length > 0 && (
          <div>
            <div className="section-heading">{t('lattesTemplate.experienceTitle')}</div>
            {atuacoes.map((item, idx) => (
              <div key={idx} style={{ marginBottom: 10 }}>
                <div style={{ display: 'flex', justifyContent: 'space-between', fontSize: '9pt', fontWeight: 'bold' }}>
                  <span>{item.cargo} — {item.empresa}</span>
                  <span style={{ color: themeColor }}>{item.ano_inicio} - {item.ano_fim || 'Atual'}</span>
                </div>
                {item.descricao && (
                  <div style={{ fontSize: '8.5pt', color: '#475569', marginTop: 2 }}>
                    {item.descricao}
                  </div>
                )}
              </div>
            ))}
          </div>
        )}

        {producoes.length > 0 && (
          <div>
            <div className="section-heading">{t('lattesTemplate.publicationsTitle')}</div>
            {producoes.map((item, idx) => (
              <div key={idx} style={{ fontSize: '8.5pt', marginBottom: 8, paddingLeft: 12, borderLeft: `2px solid ${themeColor}` }}>
                <strong>{item.titulo}</strong>
                <div style={{ color: '#64748b' }}>
                  {item.revista} ({item.ano}) — {item.qualis && <strong>[{item.qualis}]</strong>}
                </div>
              </div>
            ))}
          </div>
        )}
      </div>
    </div>
  );
}
