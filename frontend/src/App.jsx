import React, { useState, useEffect } from 'react';
import Navbar from './components/Navbar';
import WizardSteps from './components/WizardSteps';
import EtapasManager from './components/EtapasManager';
import TemplateGallery from './components/TemplateGallery';
import ResumePreview from './components/ResumePreview';
import AuthScreen from './components/AuthScreen';

import { apiService } from './services/api';
import { DEFAULT_STEPS } from './data/defaultSteps';
import { EMPTY_RESUME_DATA, SAMPLE_RESUME_DATA } from './data/sampleResumeData';
import { useI18n } from './i18n/I18nContext';

export default function App() {
  const { t } = useI18n();
  const [currentUser, setCurrentUser] = useState(() => {
    try {
      const stored = localStorage.getItem('curriculo_auth_user');
      if (stored) {
        const parsed = JSON.parse(stored);
        if (
          parsed?.avatar?.includes('images.unsplash.com') || 
          parsed?.email === 'mock@example.com'


        ) {
          localStorage.removeItem('curriculo_auth_user');
          localStorage.removeItem('curriculo_google_user');
          return null;
        }
        return parsed;
      }
      return null;
    } catch (e) {
      return null;
    }
  });
  const [activeTab, setActiveTab] = useState('wizard');
  const [theme, setTheme] = useState(() => localStorage.getItem('curriculo_theme') || 'light');
  const [etapas, setEtapas] = useState(DEFAULT_STEPS);
  const [formData, setFormData] = useState(EMPTY_RESUME_DATA);
  const [selectedModelSlug, setSelectedModelSlug] = useState('modelo-vitae');
  const [themeColor, setThemeColor] = useState('#0f3a68');
  const [isSaving, setIsSaving] = useState(false);
  const [isGeneratingSummary, setIsGeneratingSummary] = useState(false);
  const [toastMessage, setToastMessage] = useState(null);
  const [storageMode, setStorageMode] = useState('local');

  // Inicialização e carregamento do backend PHP
  useEffect(() => {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('curriculo_theme', theme);
  }, [theme]);

  useEffect(() => {
    async function loadInitialData() {
      // Carregar etapas
      const loadedEtapas = await apiService.getEtapas();
      if (loadedEtapas && loadedEtapas.length > 0) {
        setEtapas(loadedEtapas);
      }

      // Carregar currículo salvo previamente se existir
      const savedCurriculo = await apiService.getCurriculoSalvo();
      if (savedCurriculo && savedCurriculo.dados) {
        const isOldSample = savedCurriculo.dados?.identificadores_lattes?.id_lattes === '8492019384756102';
        if (!isOldSample) {
          setFormData(savedCurriculo.dados);
          if (savedCurriculo.modelo_slug) setSelectedModelSlug(savedCurriculo.modelo_slug);
          if (savedCurriculo.cor_tema) setThemeColor(savedCurriculo.cor_tema);
        } else {
          localStorage.removeItem('curriculo_saved_data');
        }
      }

      // Verificar status da API PHP
      try {
        const statusRes = await fetch('/api/status');
        if (statusRes.ok) {
          const statusJson = await statusRes.json();
          setStorageMode(statusJson.storage_mode || 'mysql_pdo');
        }
      } catch (e) {
        setStorageMode('local_resilient');
      }
    }
    loadInitialData();
  }, []);

  const showToast = (msg) => {
    setToastMessage(msg);
    setTimeout(() => setToastMessage(null), 3500);
  };

  const toggleTheme = () => {
    setTheme(prev => (prev === 'dark' ? 'light' : 'dark'));
  };

  const handleClearForm = () => {
    if (window.confirm('Tem certeza de que deseja limpar todos os campos do currículo?')) {
      setFormData(EMPTY_RESUME_DATA);
      localStorage.removeItem('curriculo_saved_data');
      showToast('Todos os campos foram limpos com sucesso!');
    }
  };

  const handleLoadSampleData = () => {
    setFormData(EMPTY_RESUME_DATA);
    showToast('Campos limpos!');
  };

  const handleSaveBackend = async () => {
    setIsSaving(true);
    try {
      const payload = {
        titulo: `Currículo Lattes - ${formData.dados_basicos?.nome || 'Pesquisador'}`,
        nome_completo: formData.dados_basicos?.nome || '',
        email: formData.dados_basicos?.email || '',
        modelo_slug: selectedModelSlug,
        cor_tema: themeColor,
        dados: formData
      };
      await apiService.saveCurriculo(payload);
      showToast(t('toasts.savedSuccess'));
    } catch (e) {
      showToast(t('toasts.savedLocal'));
    } finally {
      setIsSaving(false);
    }
  };

  const handleSaveEtapa = async (etapa) => {
    await apiService.saveEtapa(etapa);
    const updated = await apiService.getEtapas();
    setEtapas(updated);
    showToast(t('toasts.stageUpdated', { name: etapa.titulo }));
  };

  const handleDeleteEtapa = async (id) => {
    await apiService.deleteEtapa(id);
    const updated = await apiService.getEtapas();
    setEtapas(updated);
    showToast(t('toasts.stageDeleted'));
  };

  const handleReorderEtapas = async (orderedIds) => {
    const updated = await apiService.reorderEtapas(orderedIds);
    setEtapas(updated);
    showToast(t('toasts.stagesReordered'));
  };

  const handleResetEtapas = () => {
    localStorage.removeItem('curriculo_etapas_cache');
    setEtapas(DEFAULT_STEPS);
    showToast(t('toasts.stagesRestored'));
  };

  const handleGenerateSummary = async () => {
    setIsGeneratingSummary(true);
    try {
      const resumo = await apiService.gerarResumoLattes(formData);
      setFormData(prev => ({
        ...prev,
        identificadores_lattes: {
          ...(prev.identificadores_lattes || {}),
          resumo_academico: resumo
        }
      }));
      showToast(t('toasts.summaryGenerated'));
    } catch (e) {
      showToast(t('toasts.summaryError'));
    } finally {
      setIsGeneratingSummary(false);
    }
  };

  const handleAuthSuccess = (user) => {
    setCurrentUser(user);
    if (user) {
      setFormData(prev => ({
        ...prev,
        dados_basicos: {
          ...(prev.dados_basicos || {}),
          nome: user.name || prev.dados_basicos?.nome,
          email: user.email || prev.dados_basicos?.email,
          foto_url: user.avatar || prev.dados_basicos?.foto_url,
          foto_exibir: true
        },
        dados_pessoais: {
          ...(prev.dados_pessoais || {}),
          foto_url: user.avatar || prev.dados_pessoais?.foto_url,
          foto_exibir: true
        }
      }));
      showToast(`Bem-vindo, ${user.name}!`);
    }
  };

  const handleLogout = () => {
    localStorage.removeItem('curriculo_auth_user');
    localStorage.removeItem('curriculo_google_user');
    setCurrentUser(null);
    showToast('Sessão encerrada com sucesso.');
  };

  const handleApplyGoogleProfile = (googleUser) => {
    if (!googleUser) return;
    setFormData(prev => ({
      ...prev,
      dados_basicos: {
        ...(prev.dados_basicos || {}),
        nome: googleUser.name || prev.dados_basicos?.nome,
        email: googleUser.email || prev.dados_basicos?.email,
        foto_url: googleUser.avatar || prev.dados_basicos?.foto_url,
        foto_exibir: true
      },
      dados_pessoais: {
        ...(prev.dados_pessoais || {}),
        foto_url: googleUser.avatar || prev.dados_pessoais?.foto_url,
        foto_exibir: true
      }
    }));
    showToast(`Perfil atualizado: ${googleUser.name}`);
  };

  // Se o usuário ainda não estiver autenticado, a PRIMEIRA TELA é o login do Google / Cadastro
  if (!currentUser) {
    return (
      <AuthScreen
        onLoginSuccess={handleAuthSuccess}
        theme={theme}
        toggleTheme={toggleTheme}
      />
    );
  }

  return (
    <div className="app-container">
      {/* Toast Notification */}
      {toastMessage && (
        <div 
          style={{
            position: 'fixed',
            bottom: 24,
            right: 24,
            zIndex: 9999,
            background: 'var(--text-primary)',
            color: 'var(--bg-primary)',
            padding: '12px 20px',
            borderRadius: 'var(--radius-md)',
            boxShadow: 'var(--shadow-xl)',
            fontSize: '0.875rem',
            fontWeight: 600,
            display: 'flex',
            alignItems: 'center',
            gap: 8,
            animation: 'fadeIn 0.3s ease'
          }}
        >
          <span>✓ {toastMessage}</span>
        </div>
      )}

      {/* Barra de Navegação Superior */}
      <Navbar
        activeTab={activeTab}
        setActiveTab={setActiveTab}
        theme={theme}
        toggleTheme={toggleTheme}
        onLoadSampleData={handleLoadSampleData}
        onClearForm={handleClearForm}
        onSaveBackend={handleSaveBackend}
        isSaving={isSaving}
        storageMode={storageMode}
        currentUser={currentUser}
        onLogout={handleLogout}
        onApplyGoogleProfile={handleApplyGoogleProfile}
      />

      {/* Conteúdo Principal */}
      <main className="main-content">
        {activeTab === 'wizard' && (
          <div className="split-view-grid">
            <WizardSteps
              etapas={etapas}
              formData={formData}
              setFormData={setFormData}
              onGenerateLattesSummary={handleGenerateSummary}
              isGeneratingSummary={isGeneratingSummary}
              themeColor={themeColor}
              setThemeColor={setThemeColor}
              onViewResume={() => setActiveTab('curriculo')}
            />
            <ResumePreview
              formData={formData}
              setFormData={setFormData}
              selectedModelSlug={selectedModelSlug}
              setSelectedModelSlug={setSelectedModelSlug}
              themeColor={themeColor}
              setThemeColor={setThemeColor}
              onImportJson={(imported) => {
                setFormData(imported);
                showToast(t('toasts.importedSuccess'));
              }}
            />
          </div>
        )}

        {/* 4. Última Aba: Currículo Atual Completo */}
        {activeTab === 'curriculo' && (
          <div className="curriculo-tab-view" style={{ maxWidth: '1000px', margin: '0 auto', width: '100%' }}>
            <ResumePreview
              formData={formData}
              setFormData={setFormData}
              selectedModelSlug={selectedModelSlug}
              setSelectedModelSlug={setSelectedModelSlug}
              themeColor={themeColor}
              setThemeColor={setThemeColor}
              onImportJson={(imported) => {
                setFormData(imported);
                showToast(t('toasts.importedSuccess'));
              }}
            />
          </div>
        )}

        {activeTab === 'etapas' && (
          <div style={{ display: 'flex', flexDirection: 'column', gap: 24 }}>
            <EtapasManager
              etapas={etapas}
              onSaveEtapa={handleSaveEtapa}
              onDeleteEtapa={handleDeleteEtapa}
              onReorderEtapas={handleReorderEtapas}
              onResetEtapas={handleResetEtapas}
            />
            <ResumePreview
              formData={formData}
              selectedModelSlug={selectedModelSlug}
              setSelectedModelSlug={setSelectedModelSlug}
              themeColor={themeColor}
              setThemeColor={setThemeColor}
              onImportJson={setFormData}
            />
          </div>
        )}

        {activeTab === 'modelos' && (
          <div style={{ display: 'flex', flexDirection: 'column', gap: 24 }}>
            <TemplateGallery
              selectedModelSlug={selectedModelSlug}
              onSelectModel={(slug) => {
                setSelectedModelSlug(slug);
                showToast(t('toasts.modelSwitched', { model: slug }));
              }}
              onSwitchToWizard={() => setActiveTab('wizard')}
            />
            <ResumePreview
              formData={formData}
              selectedModelSlug={selectedModelSlug}
              setSelectedModelSlug={setSelectedModelSlug}
              themeColor={themeColor}
              setThemeColor={setThemeColor}
              onImportJson={setFormData}
            />
          </div>
        )}
      </main>
    </div>
  );
}
