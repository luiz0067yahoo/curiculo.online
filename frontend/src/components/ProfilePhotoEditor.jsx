import React, { useRef } from 'react';
import { 
  Camera, 
  Upload, 
  ZoomIn, 
  ZoomOut, 
  ArrowLeft, 
  ArrowRight, 
  ArrowUp, 
  ArrowDown, 
  RotateCcw, 
  Trash2, 
  Link as LinkIcon,
  Circle,
  CircleDot,
  Square,
  RectangleVertical
} from 'lucide-react';

export default function ProfilePhotoEditor({
  photoData = {},
  onChange,
  themeColor = '#0f3a68'
}) {
  const fileInputRef = useRef(null);

  const photoUrl = photoData.foto_url || '';
  const zoom = photoData.foto_zoom ?? 1;
  const x = photoData.foto_x ?? 0;
  const y = photoData.foto_y ?? 0;
  const exibir = photoData.foto_exibir !== false;
  const formato = photoData.foto_formato || 'circulo'; // 'circulo' | 'quadrado' | 'retangular'
  const temAro = photoData.foto_aro !== false; // Aro envolta da foto

  const handleFileUpload = (e) => {
    const file = e.target.files?.[0];
    if (!file) return;

    if (!file.type.startsWith('image/')) {
      alert('Por favor, selecione um arquivo de imagem válido (JPG, PNG, WEBP).');
      return;
    }

    const reader = new FileReader();
    reader.onload = (event) => {
      onChange({
        ...photoData,
        foto_url: event.target.result,
        foto_zoom: 1,
        foto_x: 0,
        foto_y: 0,
        foto_exibir: true,
        foto_formato: formato || 'circulo',
        foto_aro: true
      });
    };
    reader.readAsDataURL(file);
  };

  const handleReset = () => {
    onChange({
      ...photoData,
      foto_zoom: 1,
      foto_x: 0,
      foto_y: 0
    });
  };

  const handleRemove = () => {
    onChange({
      ...photoData,
      foto_url: '',
      foto_zoom: 1,
      foto_x: 0,
      foto_y: 0,
      foto_exibir: false
    });
  };

  const updateField = (field, value) => {
    onChange({
      ...photoData,
      [field]: value
    });
  };

  // Dimensões do enquadramento no visualizador: Círculo (1:1), Quadrado (1:1), 3x4 (proporção clássica)
  let frameWidth = 120;
  let frameHeight = 120;
  let frameRadius = '50%';

  if (formato === 'quadrado') {
    frameRadius = '14px';
  } else if (formato === 'retangular') {
    frameWidth = 100;
    frameHeight = 133;
    frameRadius = '10px';
  }

  return (
    <div className="profile-photo-editor-card">
      <div className="photo-editor-header">
        <div style={{ display: 'flex', alignItems: 'center', gap: 8 }}>
          <Camera size={18} style={{ color: themeColor }} />
          <h4 style={{ margin: 0, fontSize: '0.95rem', fontWeight: 700, color: 'var(--text-primary)' }}>
            Foto de Perfil do Currículo
          </h4>
        </div>
        <div style={{ display: 'flex', alignItems: 'center', gap: 6 }}>
          <span className="brand-tag" style={{ background: `${themeColor}18`, color: themeColor }}>
            {formato === 'circulo' ? 'Círculo' : formato === 'quadrado' ? 'Quadrado' : '3x4 Clássico'}
          </span>
          {temAro && (
            <span className="brand-tag" style={{ background: 'rgba(16,185,129,0.15)', color: '#059669', display: 'flex', alignItems: 'center', gap: 3 }}>
              <CircleDot size={12} /> Com Aro
            </span>
          )}
        </div>
      </div>

      <div className="photo-editor-body">
        {/* LADO ESQUERDO: Visualizador com Background + Seleção Rápida de Formato (Círculo, Quadrado, 3x4) */}
        <div className="photo-preview-column">
          <div 
            className="photo-ring-wrapper"
            style={{
              width: temAro ? frameWidth + 10 : frameWidth,
              height: temAro ? frameHeight + 10 : frameHeight,
              borderRadius: frameRadius,
              border: temAro ? `3px solid ${themeColor}` : 'none',
              padding: temAro ? '3px' : '0px',
              backgroundColor: '#ffffff',
              boxShadow: temAro ? `0 4px 16px rgba(0, 0, 0, 0.12), 0 0 0 2px ${themeColor}22` : 'var(--shadow-md)',
              margin: '0 auto',
              display: 'flex',
              alignItems: 'center',
              justifyContent: 'center',
              transition: 'all 0.25s ease',
              boxSizing: 'border-box'
            }}
          >
            <div 
              className="photo-circular-frame"
              style={{
                width: '100%',
                height: '100%',
                borderRadius: frameRadius,
                borderColor: temAro ? 'rgba(0,0,0,0.08)' : themeColor,
                borderWidth: temAro ? '1px' : '3px',
                overflow: 'hidden',
                backgroundColor: '#f1f5f9',
                margin: 0,
                position: 'relative',
                transition: 'border-radius 0.25s ease'
              }}
            >
              {photoUrl ? (
                /* Imagem do perfil renderizada como background */
                <div
                  className="photo-bg-preview"
                  style={{
                    width: '100%',
                    height: '100%',
                    backgroundImage: `url("${photoUrl}")`,
                    backgroundPosition: 'center center',
                    backgroundSize: 'cover',
                    backgroundRepeat: 'no-repeat',
                    borderRadius: frameRadius,
                    transform: `scale(${zoom}) translate(${x}%, ${y}%)`,
                    transformOrigin: 'center center',
                    transition: 'transform 0.1s ease-out, border-radius 0.25s ease'
                  }}
                  title="Foto de perfil (imagem em background)"
                />
              ) : (
                <div className="photo-empty-placeholder">
                  <Camera size={34} style={{ color: 'var(--text-muted)' }} />
                  <span style={{ fontSize: '0.78rem' }}>Sem foto</span>
                </div>
              )}
            </div>
          </div>

          <div style={{ textAlign: 'center', marginTop: 8 }}>
            <span style={{ fontSize: '0.75rem', color: 'var(--text-muted)' }}>
              {photoUrl ? (temAro ? 'Foto com aro decorativo' : 'Foto visível no currículo') : 'Adicione uma foto'}
            </span>
          </div>

          {/* Seleção de Formato no Lado Esquerdo (Círculo, Quadrado, 3x4) */}
          <div style={{ marginTop: 10, width: '100%' }}>
            <div style={{ fontSize: '0.74rem', fontWeight: 600, color: 'var(--text-secondary)', marginBottom: 5, textAlign: 'center' }}>
              Formato no Lado Esquerdo:
            </div>
            <div style={{ display: 'grid', gridTemplateColumns: 'repeat(3, 1fr)', gap: 4 }}>
              <button
                type="button"
                className={`btn btn-secondary ${formato === 'circulo' ? 'active-shape' : ''}`}
                style={{
                  padding: '6px 2px',
                  fontSize: '0.72rem',
                  gap: 3,
                  flexDirection: 'column',
                  border: formato === 'circulo' ? `2px solid ${themeColor}` : '1px solid var(--border-color)',
                  background: formato === 'circulo' ? 'var(--bg-tertiary)' : 'transparent',
                  fontWeight: formato === 'circulo' ? 700 : 500,
                  borderRadius: 'var(--radius-sm)'
                }}
                onClick={() => updateField('foto_formato', 'circulo')}
                title="Mudar para formato Círculo"
              >
                <Circle size={14} style={{ color: themeColor }} />
                <span>Círculo</span>
              </button>

              <button
                type="button"
                className={`btn btn-secondary ${formato === 'quadrado' ? 'active-shape' : ''}`}
                style={{
                  padding: '6px 2px',
                  fontSize: '0.72rem',
                  gap: 3,
                  flexDirection: 'column',
                  border: formato === 'quadrado' ? `2px solid ${themeColor}` : '1px solid var(--border-color)',
                  background: formato === 'quadrado' ? 'var(--bg-tertiary)' : 'transparent',
                  fontWeight: formato === 'quadrado' ? 700 : 500,
                  borderRadius: 'var(--radius-sm)'
                }}
                onClick={() => updateField('foto_formato', 'quadrado')}
                title="Mudar para formato Quadrado"
              >
                <Square size={14} style={{ color: themeColor }} />
                <span>Quadrado</span>
              </button>

              <button
                type="button"
                className={`btn btn-secondary ${formato === 'retangular' ? 'active-shape' : ''}`}
                style={{
                  padding: '6px 2px',
                  fontSize: '0.72rem',
                  gap: 3,
                  flexDirection: 'column',
                  border: formato === 'retangular' ? `2px solid ${themeColor}` : '1px solid var(--border-color)',
                  background: formato === 'retangular' ? 'var(--bg-tertiary)' : 'transparent',
                  fontWeight: formato === 'retangular' ? 700 : 500,
                  borderRadius: 'var(--radius-sm)'
                }}
                onClick={() => updateField('foto_formato', 'retangular')}
                title="Mudar para formato 3x4 Clássico"
              >
                <RectangleVertical size={14} style={{ color: themeColor }} />
                <span>3x4</span>
              </button>
            </div>
          </div>

          {/* Opções de Exibir e de Aro ao Redor */}
          <div style={{ marginTop: 10, width: '100%', display: 'flex', flexDirection: 'column', gap: 6 }}>
            <label 
              className="form-switch"
              style={{
                background: 'var(--bg-secondary)',
                padding: '8px 10px',
                borderRadius: 'var(--radius-md)',
                border: '1px solid var(--border-color)',
                fontSize: '0.8rem',
                fontWeight: 600,
                cursor: 'pointer',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'space-between',
                gap: 8
              }}
            >
              <span>Exibir no currículo</span>
              <input
                type="checkbox"
                className="switch-input"
                checked={exibir && !!photoUrl}
                disabled={!photoUrl}
                onChange={(e) => updateField('foto_exibir', e.target.checked)}
              />
            </label>

            <label 
              className="form-switch"
              style={{
                background: 'var(--bg-secondary)',
                padding: '8px 10px',
                borderRadius: 'var(--radius-md)',
                border: '1px solid var(--border-color)',
                fontSize: '0.8rem',
                fontWeight: 600,
                cursor: 'pointer',
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'space-between',
                gap: 8
              }}
            >
              <div style={{ display: 'flex', alignItems: 'center', gap: 5 }}>
                <CircleDot size={14} style={{ color: themeColor }} />
                <span>Aro envolta da foto</span>
              </div>
              <input
                type="checkbox"
                className="switch-input"
                checked={temAro}
                onChange={(e) => updateField('foto_aro', e.target.checked)}
              />
            </label>
          </div>
        </div>

        {/* LADO DIREITO: Upload, Link direto e Ajustes de Enquadramento */}
        <div className="photo-controls-column">
          {/* 1. Botões de Upload e Ações */}
          <div className="photo-upload-actions">
            <input
              type="file"
              ref={fileInputRef}
              accept="image/*"
              style={{ display: 'none' }}
              onChange={handleFileUpload}
            />
            <button
              type="button"
              className="btn btn-primary"
              style={{ flex: 1, padding: '8px 14px', fontSize: '0.84rem' }}
              onClick={() => fileInputRef.current?.click()}
            >
              <Upload size={15} /> Carregar Imagem
            </button>

            {photoUrl && (
              <>
                <button
                  type="button"
                  className="btn btn-secondary btn-icon"
                  title="Centralizar e resetar enquadramento"
                  onClick={handleReset}
                >
                  <RotateCcw size={15} />
                </button>
                <button
                  type="button"
                  className="btn btn-outline btn-icon"
                  style={{ color: 'var(--danger)', borderColor: 'var(--danger)' }}
                  title="Remover foto"
                  onClick={handleRemove}
                >
                  <Trash2 size={15} />
                </button>
              </>
            )}
          </div>

          {/* 2. Inserir via link URL direto */}
          <div style={{ marginTop: 8 }}>
            <div style={{ position: 'relative' }}>
              <LinkIcon size={14} style={{ position: 'absolute', left: 10, top: 11, color: 'var(--text-muted)' }} />
              <input
                type="text"
                className="form-control"
                placeholder="Ou cole o link direto da imagem..."
                value={photoUrl.startsWith('data:') ? '' : photoUrl}
                style={{ paddingLeft: 30, fontSize: '0.8rem' }}
                onChange={(e) => {
                  onChange({
                    ...photoData,
                    foto_url: e.target.value,
                    foto_exibir: true
                  });
                }}
              />
            </div>
          </div>

          {/* 3. Controles de Enquadramento, Zoom e Posição */}
          {photoUrl && (
            <div className="photo-adjustments-panel" style={{ marginTop: 10 }}>
              {/* Controle de Zoom */}
              <div className="adjustment-row">
                <div className="adjustment-label">
                  <span>Zoom do Background: <strong>{Math.round(zoom * 100)}%</strong></span>
                  <div className="btn-group-micro">
                    <button
                      type="button"
                      className="btn-micro"
                      onClick={() => updateField('foto_zoom', Math.max(0.5, Number((zoom - 0.1).toFixed(2))))}
                      title="Diminuir Zoom"
                    >
                      <ZoomOut size={13} />
                    </button>
                    <button
                      type="button"
                      className="btn-micro"
                      onClick={() => updateField('foto_zoom', Math.min(3.0, Number((zoom + 0.1).toFixed(2))))}
                      title="Aumentar Zoom"
                    >
                      <ZoomIn size={13} />
                    </button>
                  </div>
                </div>
                <input
                  type="range"
                  min="0.5"
                  max="3.0"
                  step="0.05"
                  className="photo-slider"
                  value={zoom}
                  onChange={(e) => updateField('foto_zoom', parseFloat(e.target.value))}
                />
              </div>

              {/* Movimento Horizontal */}
              <div className="adjustment-row">
                <div className="adjustment-label">
                  <span>Mover Horizontal: <strong>{x > 0 ? `+${x}%` : `${x}%`}</strong></span>
                  <div className="btn-group-micro">
                    <button
                      type="button"
                      className="btn-micro"
                      onClick={() => updateField('foto_x', Math.max(-50, x - 5))}
                      title="Mover para Esquerda"
                    >
                      <ArrowLeft size={13} />
                    </button>
                    <button
                      type="button"
                      className="btn-micro"
                      onClick={() => updateField('foto_x', Math.min(50, x + 5))}
                      title="Mover para Direita"
                    >
                      <ArrowRight size={13} />
                    </button>
                  </div>
                </div>
                <input
                  type="range"
                  min="-50"
                  max="50"
                  step="1"
                  className="photo-slider"
                  value={x}
                  onChange={(e) => updateField('foto_x', parseInt(e.target.value, 10))}
                />
              </div>

              {/* Movimento Vertical */}
              <div className="adjustment-row">
                <div className="adjustment-label">
                  <span>Mover Vertical: <strong>{y > 0 ? `+${y}%` : `${y}%`}</strong></span>
                  <div className="btn-group-micro">
                    <button
                      type="button"
                      className="btn-micro"
                      onClick={() => updateField('foto_y', Math.max(-50, y - 5))}
                      title="Mover para Cima"
                    >
                      <ArrowUp size={13} />
                    </button>
                    <button
                      type="button"
                      className="btn-micro"
                      onClick={() => updateField('foto_y', Math.min(50, y + 5))}
                      title="Mover para Baixo"
                    >
                      <ArrowDown size={13} />
                    </button>
                  </div>
                </div>
                <input
                  type="range"
                  min="-50"
                  max="50"
                  step="1"
                  className="photo-slider"
                  value={y}
                  onChange={(e) => updateField('foto_y', parseInt(e.target.value, 10))}
                />
              </div>
            </div>
          )}
        </div>
      </div>
    </div>
  );
}
