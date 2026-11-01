import React, { useState } from 'react';
import { 
  FileText, 
  Settings2, 
  LayoutTemplate, 
  Sun, 
  Moon, 
  Save, 
  Sparkles, 
  BookOpen, 
  Globe,
  Eye,
  LogOut,
  UserCheck,
  RotateCcw
} from 'lucide-react';
import { useI18n } from '../i18n/I18nContext';
import { GoogleIcon } from './GoogleAuthModal';

export default function Navbar({ 
  activeTab, 
  setActiveTab, 
  theme, 
  toggleTheme, 
  onLoadSampleData, 
  onClearForm,
  onSaveBackend, 
  isSaving,
  storageMode,
  currentUser,
  onLogout,
  onApplyGoogleProfile
}) {
  const { t, language, setLanguage, languages } = useI18n();
  const [isUserMenuOpen, setIsUserMenuOpen] = useState(false);

  const activeUser = currentUser || null;

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

        {/* Abas de Navegação (4 Abas: Wizard, Etapas, Modelos e Currículo) */}
        <nav className="nav-tabs" aria-label="Navegação Principal">
          <button 
            type="button"
            className={`nav-tab-btn ${activeTab === 'wizard' ? 'active' : ''}`}
            onClick={() => setActiveTab('wizard')}
            title="1. Preencher as etapas do currículo"
          >
            <span className="nav-tab-num">1</span>
            <FileText size={16} className="nav-tab-icon" />
            <span className="nav-tab-label">{t('nav.wizard')}</span>
          </button>

          <button 
            type="button"
            className={`nav-tab-btn ${activeTab === 'etapas' ? 'active' : ''}`}
            onClick={() => setActiveTab('etapas')}
            title="2. Gerenciar e reordenar etapas"
          >
            <span className="nav-tab-num">2</span>
            <Settings2 size={16} className="nav-tab-icon" />
            <span className="nav-tab-label">{t('nav.stages')}</span>
          </button>

          <button 
            type="button"
            className={`nav-tab-btn ${activeTab === 'modelos' ? 'active' : ''}`}
            onClick={() => setActiveTab('modelos')}
            title="3. Modelos de Curriculum Vitae"
          >
            <span className="nav-tab-num">3</span>
            <LayoutTemplate size={16} className="nav-tab-icon" />
            <span className="nav-tab-label">{t('nav.models')}</span>
          </button>

          {/* 4. Última Aba: Currículo Atual */}
          <button 
            type="button"
            className={`nav-tab-btn ${activeTab === 'curriculo' ? 'active' : ''}`}
            onClick={() => setActiveTab('curriculo')}
            title="4. Exibir o currículo atual completo"
          >
            <span className="nav-tab-num">4</span>
            <Eye size={16} className="nav-tab-icon" />
            <span className="nav-tab-label">{t('nav.curriculo') || 'Currículo'}</span>
          </button>
        </nav>

        {/* Ações Rápidas & Perfil do Usuário */}
        <div className="nav-actions">
          {/* Usuário Autenticado */}
          {activeUser && (
            <div style={{ position: 'relative' }}>
              <button
                type="button"
                className="btn btn-secondary google-user-btn"
                onClick={() => setIsUserMenuOpen(prev => !prev)}
                title={`Conectado como ${activeUser.name}`}
                style={{ padding: '4px 10px', gap: 8, height: 38 }}
              >
                <img 
                  src={activeUser.avatar} 
                  alt={activeUser.name} 
                  style={{ width: 24, height: 24, borderRadius: '50%', objectFit: 'cover' }}
                />
                <span style={{ fontSize: '0.82rem', fontWeight: 600, maxWidth: 100, overflow: 'hidden', textOverflow: 'ellipsis', whiteSpace: 'nowrap' }}>
                  {activeUser.name.split(' ')[0]}
                </span>
                {activeUser.provider === 'google' && <GoogleIcon size={13} />}
              </button>

              {isUserMenuOpen && (
                <div className="google-user-dropdown" onClick={(e) => e.stopPropagation()}>
                  <div style={{ padding: '10px 14px', borderBottom: '1px solid var(--border-color)' }}>
                    <div style={{ fontWeight: 700, fontSize: '0.85rem', color: 'var(--text-primary)' }}>{activeUser.name}</div>
                    <div style={{ fontSize: '0.78rem', color: 'var(--text-muted)' }}>{activeUser.email}</div>
                  </div>
                  {onApplyGoogleProfile && (
                    <button
                      type="button"
                      className="google-dropdown-item"
                      onClick={() => {
                        onApplyGoogleProfile(activeUser);
                        setIsUserMenuOpen(false);
                      }}
                    >
                      <UserCheck size={14} /> Usar no Currículo
                    </button>
                  )}
                  {onLogout && (
                    <button
                      type="button"
                      className="google-dropdown-item text-danger"
                      onClick={() => {
                        setIsUserMenuOpen(false);
                        onLogout();
                      }}
                    >
                      <LogOut size={14} /> Sair da Conta
                    </button>
                  )}
                </div>
              )}
            </div>
          )}

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

          {onClearForm && (
            <button 
              type="button" 
              className="btn btn-secondary"
              title="Limpar todos os campos do currículo"
              onClick={onClearForm}
            >
              <RotateCcw size={15} style={{ color: 'var(--text-muted)' }} />
              <span className="btn-text-hide-mobile">Limpar Campos</span>
            </button>
          )}

          <button 
            type="button" 
            className="btn btn-primary"
            onClick={onSaveBackend}
            disabled={isSaving}
            title={storageMode === 'mysql_pdo' ? 'Salvo no MySQL via PHP PDO' : 'Salvo no backend PHP'}
          >
            <Save size={16} />
            <span className="btn-text-hide-mobile">{isSaving ? t('nav.saving') : t('nav.saveCv')}</span>
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
