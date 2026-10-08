import React from 'react';
import { 
  FileText, 
  Settings2, 
  LayoutTemplate, 
  Sun, 
  Moon, 
  Save, 
  Sparkles, 
  BookOpen,
  Globe
} from 'lucide-react';
import { useI18n } from '../i18n/I18nContext';

export default function Navbar({ 
  activeTab, 
  setActiveTab, 
  theme, 
  toggleTheme, 
  onLoadSampleData, 
  onSaveBackend, 
  isSaving,
  storageMode
}) {
  const { t, language, setLanguage, languages } = useI18n();

  return (
    <header className="navbar">
      <div className="navbar-inner">
        {/* Marca / Identidade */}
        <div className="brand-section">
          <div className="brand-logo-badge">
            <BookOpen size={24} />
          </div>
          <div>
            <div className="brand-title">
              {t('brand.title')}<span style={{ color: '#38bdf8' }}>{t('brand.domain')}</span>
            </div>
            <div className="brand-subtitle">
              <span>{t('brand.subtitle')}</span>
              <span className="brand-tag">{t('brand.versionTag')}</span>
            </div>
          </div>
        </div>

        {/* Abas de Navegação */}
        <nav className="nav-tabs">
          <button 
            type="button"
            className={`nav-tab-btn ${activeTab === 'wizard' ? 'active' : ''}`}
            onClick={() => setActiveTab('wizard')}
          >
            <FileText size={16} />
            <span>{t('nav.wizard')}</span>
          </button>

          <button 
            type="button"
            className={`nav-tab-btn ${activeTab === 'etapas' ? 'active' : ''}`}
            onClick={() => setActiveTab('etapas')}
          >
            <Settings2 size={16} />
            <span>{t('nav.stages')}</span>
          </button>

          <button 
            type="button"
            className={`nav-tab-btn ${activeTab === 'modelos' ? 'active' : ''}`}
            onClick={() => setActiveTab('modelos')}
          >
            <LayoutTemplate size={16} />
            <span>{t('nav.models')}</span>
          </button>
        </nav>

        {/* Ações Rápidas */}
        <div className="nav-actions">
          {/* Seletor de Idioma (4 Idiomas) */}
          <div style={{ display: 'flex', alignItems: 'center', gap: 6, background: 'var(--bg-tertiary)', padding: '3px 8px', borderRadius: 'var(--radius-md)', border: '1px solid var(--border-color)' }}>
            <Globe size={15} style={{ color: 'var(--text-muted)' }} />
            <select
              className="lang-select"
              style={{
                background: 'transparent',
                border: 'none',
                color: 'var(--text-primary)',
                fontSize: '0.82rem',
                fontWeight: 600,
                cursor: 'pointer',
                outline: 'none'
              }}
              value={language}
              onChange={(e) => setLanguage(e.target.value)}
              title={t('nav.selectLang')}
            >
              {languages.map((l) => (
                <option key={l.code} value={l.code} style={{ background: 'var(--bg-secondary)', color: 'var(--text-primary)' }}>
                  {l.flag} {l.name}
                </option>
              ))}
            </select>
          </div>

          <button 
            type="button" 
            className="btn btn-secondary"
            title={t('nav.loadBackupTitle')}
            onClick={onLoadSampleData}
          >
            <Sparkles size={16} style={{ color: '#f59e0b' }} />
            <span style={{ display: 'none', md: 'inline' }}>{t('nav.loadBackup')}</span>
          </button>

          <button 
            type="button" 
            className="btn btn-primary"
            onClick={onSaveBackend}
            disabled={isSaving}
            title={storageMode === 'mysql_pdo' ? 'Salvo no MySQL via PHP PDO' : 'Salvo no backend PHP'}
          >
            <Save size={16} />
            <span>{isSaving ? t('nav.saving') : t('nav.saveCv')}</span>
          </button>

          <button 
            type="button" 
            className="btn btn-secondary btn-icon"
            onClick={toggleTheme}
            title={theme === 'dark' ? t('nav.lightMode') : t('nav.darkMode')}
          >
            {theme === 'dark' ? <Sun size={18} /> : <Moon size={18} />}
          </button>
        </div>
      </div>
    </header>
  );
}
