import React, { useState, useEffect } from 'react';
import Navbar from './components/Navbar';
import WizardSteps from './components/WizardSteps';
import EtapasManager from './components/EtapasManager';
import TemplateGallery from './components/TemplateGallery';
import ResumePreview from './components/ResumePreview';

import { apiService } from './services/api';
import { DEFAULT_STEPS } from './data/defaultSteps';
import { SAMPLE_RESUME_DATA } from './data/sampleResumeData';
import { useI18n } from './i18n/I18nContext';

export default function App() {
  const { t } = useI18n();
  const [activeTab, setActiveTab] = useState('wizard');
  const [theme, setTheme] = useState(() => localStorage.getItem('curriculo_theme') || 'light');
  const [etapas, setEtapas] = useState(DEFAULT_STEPS);
  const [formData, setFormData] = useState(SAMPLE_RESUME_DATA);
  const [selectedModelSlug, setSelectedModelSlug] = useState('lattes-tradicional');
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
        setFormData(savedCurriculo.dados);
        if (savedCurriculo.modelo_slug) setSelectedModelSlug(savedCurriculo.modelo_slug);
        if (savedCurriculo.cor_tema) setThemeColor(savedCurriculo.cor_tema);
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

  const handleLoadSampleData = () => {
    setFormData(SAMPLE_RESUME_DATA);
    showToast(t('toasts.sampleLoaded'));
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
        onSaveBackend={handleSaveBackend}
        isSaving={isSaving}
        storageMode={storageMode}
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
            />
            <ResumePreview
              formData={formData}
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
