import React, { useState } from 'react';
import { 
  Printer, 
  Download, 
  Upload, 
  ZoomIn, 
  ZoomOut, 
  Layout, 
  Palette,
  Camera,
  X
} from 'lucide-react';
import { RESUME_MODELS } from '../data/modelsData';
import { useI18n } from '../i18n/I18nContext';
import ProfilePhotoEditor from './ProfilePhotoEditor';
import { useDialog } from './DialogModal';

import LattesTradicional from './templates/LattesTradicional';
import LattesModerno from './templates/LattesModerno';
import LattesResumido from './templates/LattesResumido';
import LattesHibrido from './templates/LattesHibrido';
import LattesMinimalista from './templates/LattesMinimalista';

export const COLOR_PALETTE = [
  // --- TONS DE ROSA (PINK) ---
  { name: 'Rosa Choque / Hot Pink', hex: '#ec4899' },
  { name: 'Rosa Escuro / Deep Pink', hex: '#db2777' },
  { name: 'Rosa Pastel / Soft Pink', hex: '#f472b6' },
  { name: 'Rosa Chiclete / Bubblegum', hex: '#fb7185' },
  { name: 'Rosa Queimado / Rose Gold', hex: '#be185d' },
  { name: 'Rosa Framboesa / Berry', hex: '#9d174d' },
  { name: 'Rosa Bebê / Baby Pink', hex: '#fbcfe8' },
  { name: 'Rosa Fúcsia / Magenta', hex: '#d946ef' },

  // --- TONS ROXOS & VIOLETAS ---
  { name: 'Lavanda / Lilás', hex: '#a855f7' },
  { name: 'Púrpura Real', hex: '#7c3aed' },
  { name: 'Índigo Profundo', hex: '#4338ca' },

  // --- TONS AZUIS CLÁSSICOS & MODERNOS ---
  { name: 'Azul CNPq Oficial', hex: '#0f3a68' },
  { name: 'Azul Royal Moderno', hex: '#1e40af' },
  { name: 'Azul Celeste / Ciano', hex: '#0284c7' },
  { name: 'Azul Petróleo / Deep Teal', hex: '#0e7490' },

  // --- TONS VERDES ACADÊMICOS ---
  { name: 'Verde Esmeralda Acadêmico', hex: '#0f766e' },
  { name: 'Verde Menta / Mint', hex: '#059669' },
  { name: 'Verde Floresta', hex: '#15803d' },

  // --- TONS QUENTES & CRIATIVOS ---
  { name: 'Laranja Coral', hex: '#ea580c' },
  { name: 'Âmbar Dourado', hex: '#d97706' },
  { name: 'Bordô / Vinho Universitário', hex: '#881337' },
  { name: 'Vermelho Rubi', hex: '#e11d48' },

  // --- TONS NEUTROS & MONOCROMÁTICOS ---
  { name: 'Ardósia / Grafite', hex: '#334155' },
  { name: 'Cinza Aço Neutro', hex: '#4b5563' },
  { name: 'Monocromático Escuro', hex: '#111827' }
];

export default function ResumePreview({ 
  formData, 
  setFormData,
  selectedModelSlug, 
  setSelectedModelSlug, 
  themeColor, 
  setThemeColor,
  onImportJson 
}) {
  const { t } = useI18n();
  const { showAlert } = useDialog();
  const [zoom, setZoom] = useState(100);
  const [isPhotoModalOpen, setIsPhotoModalOpen] = useState(false);

  const handlePrint = () => {
    window.print();
  };

  const handleExportJson = () => {
    const dataStr = "data:text/json;charset=utf-8," + encodeURIComponent(JSON.stringify(formData, null, 2));
    const downloadAnchor = document.createElement('a');
    downloadAnchor.setAttribute("href", dataStr);
    downloadAnchor.setAttribute("download", `curriculo_lattes_${(formData.dados_basicos?.nome || 'pesquisador').toLowerCase().replace(/\s+/g, '_')}.json`);
    document.body.appendChild(downloadAnchor);
    downloadAnchor.click();
    downloadAnchor.remove();
  };

  const handleFileUpload = (e) => {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = (event) => {
        try {
          const parsed = JSON.parse(event.target.result);
          onImportJson(parsed);
        } catch (err) {
          showAlert({ title: 'Arquivo JSON Inválido', message: 'O arquivo selecionado não é um JSON de currículo válido.', variant: 'danger' });
        }
      };
      reader.readAsText(file);
    }
  };

  const renderTemplate = () => {
    switch (selectedModelSlug) {
      case 'lattes-moderno':
        return <LattesModerno data={formData} themeColor={themeColor} />;
      case 'lattes-resumido':
        return <LattesResumido data={formData} themeColor={themeColor} />;
      case 'lattes-hibrido':
        return <LattesHibrido data={formData} themeColor={themeColor} />;
      case 'lattes-minimalista':
        return <LattesMinimalista data={formData} themeColor={themeColor} />;
      case 'modelo-vitae':
      case 'curriculum-vitae':
      case 'vitae':
      case 'lattes-tradicional':
      default:
        return <LattesTradicional data={formData} themeColor={themeColor} />;
    }
  };

  return (
    <div className="preview-container-wrapper">
      {/* Barra de Ferramentas da Prévia */}
      <div className="preview-toolbar">
        {/* Seletor de Modelo */}
        <div className="toolbar-group">
          <Layout size={16} style={{ color: 'var(--text-muted)' }} />
          <select
            className="form-select"
            style={{ width: '220px', padding: '6px 10px', fontSize: '0.85rem' }}
            value={selectedModelSlug}
            onChange={e => setSelectedModelSlug(e.target.value)}
            title={t('preview.modelSelector')}
          >
            {RESUME_MODELS.map(m => (
              <option key={m.slug} value={m.slug}>
                {m.nome}
              </option>
            ))}
          </select>
        </div>

        {/* Seletor de Cores */}
        <div className="toolbar-group">
          <Palette size={16} style={{ color: 'var(--text-muted)' }} />
          <div className="color-dot-picker" title={t('preview.colorPalette')}>
            {COLOR_PALETTE.map(c => (
              <div
                key={c.hex}
                className={`color-dot ${themeColor.toLowerCase() === c.hex.toLowerCase() ? 'active' : ''}`}
                style={{ backgroundColor: c.hex }}
                onClick={() => setThemeColor(c.hex)}
                title={c.name}
              />
            ))}
            {/* Seletor Customizado / Qualquer Cor / Rosa Personalizado */}
            <label 
              className="color-dot color-custom-picker-label"
              style={{
                backgroundColor: themeColor,
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'center',
                position: 'relative',
                cursor: 'pointer'
              }}
              title="Escolher qualquer outra cor (ex: Rosa, Pastel, etc.)"
            >
              <input 
                type="color" 
                value={themeColor} 
                onChange={(e) => setThemeColor(e.target.value)}
                style={{
                  position: 'absolute',
                  opacity: 0,
                  width: '100%',
                  height: '100%',
                  cursor: 'pointer'
                }}
              />
              <span style={{ fontSize: '10px', color: '#fff', fontWeight: 'bold', textShadow: '0 1px 2px rgba(0,0,0,0.8)' }}>+</span>
            </label>
          </div>
        </div>

        {/* Botão de Foto no Currículo */}
        {setFormData && (
          <div className="toolbar-group">
            <button
              type="button"
              className="btn btn-secondary"
              style={{ padding: '6px 12px', fontSize: '0.82rem', gap: 6, height: 34 }}
              onClick={() => setIsPhotoModalOpen(true)}
              title="Adicionar ou alterar a foto no currículo"
            >
              <Camera size={15} style={{ color: themeColor }} />
              <span>Foto do Currículo</span>
            </button>
          </div>
        )}

        {/* Controles de Zoom & Impressão */}
        <div className="toolbar-group">
          <button
            type="button"
            className="btn btn-secondary btn-icon"
            style={{ width: 32, height: 32 }}
            onClick={() => setZoom(prev => Math.max(70, prev - 10))}
            title={t('preview.zoomOutTooltip')}
          >
            <ZoomOut size={14} />
          </button>
          <span style={{ fontSize: '0.8rem', fontWeight: 600, minWidth: '40px', textAlign: 'center' }}>
            {zoom}%
          </span>
          <button
            type="button"
            className="btn btn-secondary btn-icon"
            style={{ width: 32, height: 32 }}
            onClick={() => setZoom(prev => Math.min(130, prev + 10))}
            title={t('preview.zoomInTooltip')}
          >
            <ZoomIn size={14} />
          </button>

          <button
            type="button"
            className="btn btn-secondary"
            style={{ padding: '6px 12px', fontSize: '0.82rem' }}
            onClick={handleExportJson}
            title={t('preview.exportJsonTooltip')}
          >
            <Download size={14} /> {t('preview.exportJson')}
          </button>

          <label
            className="btn btn-secondary"
            style={{ padding: '6px 12px', fontSize: '0.82rem', cursor: 'pointer', margin: 0 }}
            title={t('preview.importJsonTooltip')}
          >
            <Upload size={14} />
            <input type="file" accept=".json" onChange={handleFileUpload} style={{ display: 'none' }} />
          </label>

          <button
            type="button"
            className="btn btn-primary"
            style={{ padding: '6px 14px', fontSize: '0.85rem' }}
            onClick={handlePrint}
            title={t('preview.printPdfTooltip')}
          >
            <Printer size={15} /> {t('preview.printPdf')}
          </button>
        </div>
      </div>

      {/* Modal Popup para Configurar Foto de Perfil */}
      {isPhotoModalOpen && setFormData && (
        <div className="modal-backdrop" onClick={() => setIsPhotoModalOpen(false)}>
          <div 
            className="modal-content" 
            style={{ maxWidth: 560, padding: '24px', borderRadius: 'var(--radius-lg)' }}
            onClick={(e) => e.stopPropagation()}
          >
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 16, flexWrap: 'wrap', gap: 8 }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: 8, flexWrap: 'wrap' }}>
                <Camera size={20} style={{ color: themeColor }} />
                <h3 style={{ margin: 0, fontSize: '1.1rem', fontWeight: 700, color: 'var(--text-primary)' }}>
                  Foto do Currículo
                </h3>
              </div>
              <button 
                type="button" 
                className="btn btn-secondary btn-icon" 
                style={{ width: 32, height: 32 }}
                onClick={() => setIsPhotoModalOpen(false)}
              >
                <X size={16} />
              </button>
            </div>

            <ProfilePhotoEditor
              themeColor={themeColor}
              photoData={{
                foto_url: formData.dados_basicos?.foto_url || formData.dados_pessoais?.foto_url,
                foto_zoom: formData.dados_basicos?.foto_zoom ?? formData.dados_pessoais?.foto_zoom ?? 1,
                foto_x: formData.dados_basicos?.foto_x ?? formData.dados_pessoais?.foto_x ?? 0,
                foto_y: formData.dados_basicos?.foto_y ?? formData.dados_pessoais?.foto_y ?? 0,
                foto_exibir: formData.dados_basicos?.foto_exibir ?? formData.dados_pessoais?.foto_exibir ?? true,
                foto_formato: formData.dados_basicos?.foto_formato || formData.dados_pessoais?.foto_formato || 'circulo',
                foto_aro: formData.dados_basicos?.foto_aro ?? formData.dados_pessoais?.foto_aro ?? true
              }}
              onChange={(newPhoto) => {
                setFormData(prev => ({
                  ...prev,
                  dados_basicos: {
                    ...(prev.dados_basicos || {}),
                    ...newPhoto
                  },
                  dados_pessoais: {
                    ...(prev.dados_pessoais || {}),
                    ...newPhoto
                  }
                }));
              }}
            />

            <div style={{ display: 'flex', justifyContent: 'flex-end', marginTop: 16 }}>
              <button 
                type="button" 
                className="btn btn-primary"
                onClick={() => setIsPhotoModalOpen(false)}
              >
                Concluir e Aplicar no Currículo
              </button>
            </div>
          </div>
        </div>
      )}

      {/* Viewport da Folha A4 */}
      <div className="a4-viewport-container">
        <div 
          className="a4-page-sheet" 
          id="cv-print-area"
          style={{ transform: `scale(${zoom / 100})`, transformOrigin: 'top center' }}
        >
          {renderTemplate()}
        </div>
      </div>
    </div>
  );
}
