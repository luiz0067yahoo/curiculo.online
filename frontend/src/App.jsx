import React, { useState, useEffect } from 'react';
import Navbar from './components/Navbar';
import WizardSteps from './components/WizardSteps';
import EtapasManager from './components/EtapasManager';
import TemplateGallery from './components/TemplateGallery';
import ResumePreview from './components/ResumePreview';
import AuthScreen from './components/AuthScreen';

import { apiService } from './services/api';
import { DEFAULT_STEPS } from './data/defaultSteps';
import { EMPTY_RESUME_DATA } from './data/sampleResumeData';
import { useI18n } from './i18n/I18nContext';
import { useDialog } from './components/DialogModal';

export default function App() {
  const { t } = useI18n();
  const { showConfirm } = useDialog();
  const [currentUser, setCurrentUser] = useState(() => {
    try {
      const stored = localStorage.getItem('curriculo_auth_user');
      if (stored) {
        const parsed = JSON.parse(stored);
        if (parsed?.avatar?.includes('images.unsplash.com')) {
          localStorage.removeItem('curriculo_auth_user');
          localStorage.removeItem('curriculo_google_user');
          return null;
        }
        if (parsed?.name === 'Pesquisador Convidado') {
          parsed.name = 'Profissional Convidado';
          parsed.avatar = 'https://ui-avatars.com/api/?name=Profissional&background=334155&color=fff';
          localStorage.setItem('curriculo_auth_user', JSON.stringify(parsed));
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
  const [curriculoUuid, setCurriculoUuid] = useState(null);
  const [selectedModelSlug, setSelectedModelSlug] = useState('modelo-vitae');
  const [themeColor, setThemeColor] = useState('#0f3a68');
  const [isSaving, setIsSaving] = useState(false);
  const [isGeneratingSummary, setIsGeneratingSummary] = useState(false);
  const [toastMessage, setToastMessage] = useState(null);
  const [storageMode, setStorageMode] = useState('local');

  useEffect(() => {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('curriculo_theme', theme);
  }, [theme]);

  useEffect(() => {
    async function loadInitialData() {
      // Carregar etapas do backend
      const loadedEtapas = await apiService.getEtapas();
      if (loadedEtapas && loadedEtapas.length > 0) {
        setEtapas(loadedEtapas);
      }

      // Sincronizar usuário autenticado e currículo salvo no backend
      let activeUser = currentUser;
      if (activeUser?.token) {
        const meRes = await apiService.getMe();
        if (meRes?.user) {
          activeUser = meRes.user;
          setCurrentUser(meRes.user);
          localStorage.setItem('curriculo_auth_user', JSON.stringify(meRes.user));
          if (meRes.curriculo?.dados) {
            setFormData(meRes.curriculo.dados);
            if (meRes.curriculo.uuid) setCurriculoUuid(meRes.curriculo.uuid);
            if (meRes.curriculo.modelo_slug) setSelectedModelSlug(meRes.curriculo.modelo_slug);
            if (meRes.curriculo.cor_tema) setThemeColor(meRes.curriculo.cor_tema);
          }
        }
      } else if (activeUser) {
        const savedCurriculo = await apiService.getCurriculoSalvo(activeUser);
        if (savedCurriculo && savedCurriculo.dados) {
          if (savedCurriculo.dados?.dados_basicos?.nome === 'Pesquisador Convidado') {
            savedCurriculo.dados.dados_basicos.nome = 'Profissional Convidado';
          }
          if (savedCurriculo.dados?.identificadores_lattes?.citacoes_bibliograficas === 'Pesquisador Convidado') {
            savedCurriculo.dados.identificadores_lattes.citacoes_bibliograficas = 'Profissional Convidado';
          }
          setFormData(savedCurriculo.dados);
          if (savedCurriculo.uuid) setCurriculoUuid(savedCurriculo.uuid);
          if (savedCurriculo.modelo_slug) setSelectedModelSlug(savedCurriculo.modelo_slug);
          if (savedCurriculo.cor_tema) setThemeColor(savedCurriculo.cor_tema);
        } else {
          setFormData(prev => ({
            ...prev,
            dados_basicos: {
              ...(prev.dados_basicos || {}),
              nome: activeUser.name || prev.dados_basicos?.nome || '',
              email: activeUser.email || prev.dados_basicos?.email || '',
              foto_url: activeUser.avatar || prev.dados_basicos?.foto_url || '',
              foto_exibir: true
            }
          }));
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

  const handleClearForm = async () => {
    const confirmed = await showConfirm({
      title: 'Limpar Todos os Campos',
      message: 'Tem certeza de que deseja limpar todos os campos do currículo? Esta ação removerá os dados preenchidos.',
      confirmText: 'Sim, Limpar Campos',
      cancelText: 'Cancelar',
      variant: 'danger'
    });
    if (confirmed) {
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
        uuid: curriculoUuid,
        user_id: currentUser?.id || null,
        titulo: `Currículo Lattes - ${formData.dados_basicos?.nome || currentUser?.name || 'Profissional'}`,
        nome_completo: formData.dados_basicos?.nome || currentUser?.name || '',
        email: formData.dados_basicos?.email || currentUser?.email || '',
        modelo_slug: selectedModelSlug,
        cor_tema: themeColor,
        dados: formData
      };
      const saved = await apiService.saveCurriculo(payload);
      if (saved?.uuid) {
        setCurriculoUuid(saved.uuid);
      }
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

  const handleAuthSuccess = async (user, backendCurriculo = null) => {
    setCurrentUser(user);
    if (!user) return;

    if (backendCurriculo && backendCurriculo.dados) {
      setFormData(backendCurriculo.dados);
      if (backendCurriculo.uuid) setCurriculoUuid(backendCurriculo.uuid);
      if (backendCurriculo.modelo_slug) setSelectedModelSlug(backendCurriculo.modelo_slug);
      if (backendCurriculo.cor_tema) setThemeColor(backendCurriculo.cor_tema);
      showToast(`Bem-vindo de volta, ${user.name}! Currículo carregado.`);
      return;
    }

    const initialData = {
      ...EMPTY_RESUME_DATA,
      dados_basicos: {
        ...EMPTY_RESUME_DATA.dados_basicos,
        nome: user.name || '',
        email: user.email || '',
        foto_url: user.avatar || '',
        foto_exibir: true
      },
      dados_pessoais: {
        ...EMPTY_RESUME_DATA.dados_pessoais,
        foto_url: user.avatar || '',
        foto_exibir: true
      }
    };
    setFormData(initialData);
    setCurriculoUuid(null);

    if (user.provider !== 'guest') {
      try {
        const saved = await apiService.saveCurriculo({
          user_id: user.id || null,
          titulo: `Currículo Lattes - ${user.name}`,
          nome_completo: user.name || '',
          email: user.email || '',
          modelo_slug: selectedModelSlug,
          cor_tema: themeColor,
          dados: initialData
        });
        if (saved?.uuid) {
          setCurriculoUuid(saved.uuid);
        }
      } catch (e) {}
    }

    showToast(`Bem-vindo, ${user.name}!`);
  };

  const handleLogout = async () => {
    await apiService.logout();
    localStorage.removeItem('curriculo_auth_user');
    localStorage.removeItem('curriculo_google_user');
    localStorage.removeItem('curriculo_saved_data');
    setCurrentUser(null);
    setCurriculoUuid(null);
    setFormData(EMPTY_RESUME_DATA);
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
