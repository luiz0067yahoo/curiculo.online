import React, { useState } from 'react';
import { 
  Printer, 
  Download, 
  Upload, 
  ZoomIn, 
  ZoomOut, 
  Layout, 
  Palette 
} from 'lucide-react';
import { RESUME_MODELS } from '../data/modelsData';
import { useI18n } from '../i18n/I18nContext';

import LattesTradicional from './templates/LattesTradicional';
import LattesModerno from './templates/LattesModerno';
import LattesResumido from './templates/LattesResumido';
import LattesHibrido from './templates/LattesHibrido';
import LattesMinimalista from './templates/LattesMinimalista';

const COLOR_PALETTE = [
  { name: 'Azul CNPq Oficial', hex: '#0f3a68' },
  { name: 'Azul Royal Moderno', hex: '#1e40af' },
  { name: 'Verde Esmeralda Acadêmico', hex: '#0f766e' },
  { name: 'Ardósia / Grafite P&D', hex: '#334155' },
  { name: 'Monocromático Escuro', hex: '#111827' },
  { name: 'Bordô / Vinho Universitário', hex: '#881337' },
  { name: 'Índigo Profundo', hex: '#4338ca' }
];

export default function ResumePreview({ 
  formData, 
  selectedModelSlug, 
  setSelectedModelSlug, 
  themeColor, 
  setThemeColor,
  onImportJson 
}) {
  const { t } = useI18n();
  const [zoom, setZoom] = useState(100);

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
          alert('Arquivo JSON inválido.');
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
        return <LattesMinimalista data={formData} />;
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
                className={`color-dot ${themeColor === c.hex ? 'active' : ''}`}
                style={{ backgroundColor: c.hex }}
                onClick={() => setThemeColor(c.hex)}
                title={c.name}
              />
            ))}
          </div>
        </div>

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
