import React from 'react';
import { Check, Sparkles, FileCheck, Layers, Cpu, Printer } from 'lucide-react';
import { RESUME_MODELS } from '../data/modelsData';
import { useI18n } from '../i18n/I18nContext';

const iconMap = {
  FileCheck,
  Sparkles,
  Layers,
  Cpu,
  Printer
};

export default function TemplateGallery({ selectedModelSlug, onSelectModel, onSwitchToWizard }) {
  const { t } = useI18n();

  return (
    <div className="card-panel">
      <div className="card-panel-header">
        <div className="panel-title-group">
          <div className="panel-icon-badge">
            <Sparkles size={22} />
          </div>
          <div>
            <h3 className="panel-title">{t('gallery.title')}</h3>
            <p className="panel-subtitle">
              {t('gallery.subtitle')}
            </p>
          </div>
        </div>
      </div>

      <div style={{ display: 'grid', gridTemplateColumns: 'repeat(auto-fit, minmax(280px, 1fr))', gap: 20 }}>
        {RESUME_MODELS.map(modelo => {
          const isSelected = selectedModelSlug === modelo.slug;
          const Icon = iconMap[modelo.previewIcon] || FileCheck;

          return (
            <div
              key={modelo.slug}
              style={{
                border: isSelected ? '2px solid var(--accent)' : '1px solid var(--border-color)',
                borderRadius: 'var(--radius-lg)',
                padding: '20px',
                background: isSelected ? 'var(--bg-tertiary)' : 'var(--bg-secondary)',
                display: 'flex',
                flexDirection: 'column',
                justifyContent: 'space-between',
                boxShadow: isSelected ? 'var(--shadow-md)' : 'var(--shadow-sm)',
                transition: 'var(--transition)',
                cursor: 'pointer'
              }}
              onClick={() => onSelectModel(modelo.slug)}
            >
              <div>
                <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 12 }}>
                  <span
                    style={{
                      background: isSelected ? 'var(--accent)' : 'var(--border-color)',
                      color: isSelected ? '#fff' : 'var(--text-secondary)',
                      fontSize: '0.75rem',
                      fontWeight: 700,
                      padding: '3px 10px',
                      borderRadius: 'var(--radius-full)'
                    }}
                  >
                    {modelo.badge}
                  </span>

                  <div
                    style={{
                      width: 18,
                      height: 18,
                      borderRadius: '50%',
                      backgroundColor: modelo.corPadrao,
                      border: '2px solid #fff',
                      boxShadow: '0 0 0 1px var(--border-color)'
                    }}
                    title={`${t('gallery.colorDefaultTitle')}: ${modelo.corPadrao}`}
                  />
                </div>

                <div style={{ display: 'flex', alignItems: 'center', gap: 10, marginBottom: 8 }}>
                  <Icon size={20} style={{ color: modelo.corPadrao }} />
                  <h4 style={{ fontSize: '1.05rem', fontWeight: 700, margin: 0 }}>
                    {modelo.nome}
                  </h4>
                </div>

                <p style={{ fontSize: '0.85rem', color: 'var(--text-secondary)', lineHeight: 1.5, marginBottom: 16 }}>
                  {modelo.descricao}
                </p>
              </div>

              <div style={{ display: 'flex', alignItems: 'center', justifyContent: 'space-between', paddingTop: 12, borderTop: '1px solid var(--border-color)' }}>
                <span style={{ fontSize: '0.8rem', color: 'var(--text-muted)', fontWeight: 600 }}>
                  {modelo.categoria}
                </span>

                <button
                  type="button"
                  className={`btn ${isSelected ? 'btn-primary' : 'btn-secondary'}`}
                  style={{ padding: '6px 14px', fontSize: '0.8rem' }}
                  onClick={(e) => {
                    e.stopPropagation();
                    onSelectModel(modelo.slug);
                    onSwitchToWizard();
                  }}
                >
                  {isSelected ? (
                    <>
                      <Check size={14} /> {t('gallery.activeOnCv')}
                    </>
                  ) : (
                    t('gallery.useThisModel')
                  )}
                </button>
              </div>
            </div>
          );
        })}
      </div>
    </div>
  );
}
