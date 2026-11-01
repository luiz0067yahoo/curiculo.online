import React from 'react';

export default function ProfilePhotoView({ 
  data, 
  themeColor = '#0f3a68', 
  size = 96,
  style = {} 
}) {
  const dp = data?.dados_pessoais || {};
  const db = data?.dados_basicos || {};

  // Foto URL pode vir de dados_basicos ou dados_pessoais
  const photoUrl = db.foto_url || dp.foto_url;
  const exibir = db.foto_exibir !== false && dp.foto_exibir !== false;
  const formato = db.foto_formato || dp.foto_formato || 'circulo'; // 'circulo' | 'quadrado' | 'retangular' (3x4)
  const temAro = db.foto_aro !== false && dp.foto_aro !== false; // Aro envolta da foto

  if (!photoUrl || !exibir) {
    return null;
  }

  const zoom = db.foto_zoom ?? dp.foto_zoom ?? 1;
  const x = db.foto_x ?? dp.foto_x ?? 0;
  const y = db.foto_y ?? dp.foto_y ?? 0;

  // Dimensões dinâmicas: Círculo (1:1), Quadrado (1:1 com cantos suaves), Retangular (3x4 clássico)
  let finalWidth = size;
  let finalHeight = size;
  let borderRadius = '50%';

  if (formato === 'quadrado') {
    borderRadius = '14px';
  } else if (formato === 'retangular') {
    finalWidth = Math.round(size * 0.75); // Proporção 3x4
    finalHeight = size;
    borderRadius = '10px';
  }

  // Estilização do Aro ao redor da foto
  const isWhite = themeColor.toLowerCase() === '#ffffff' || themeColor.toLowerCase() === '#fff';
  const ringColor = isWhite ? '#ffffff' : themeColor;
  const ringBg = isWhite ? 'rgba(255, 255, 255, 0.25)' : '#ffffff';
  const ringShadow = isWhite
    ? '0 3px 12px rgba(0, 0, 0, 0.25)'
    : `0 4px 14px rgba(0, 0, 0, 0.12), 0 0 0 2px ${themeColor}22`;

  const totalWidth = temAro ? finalWidth + 8 : finalWidth;
  const totalHeight = temAro ? finalHeight + 8 : finalHeight;

  return (
    <div 
      className="resume-profile-photo-ring-wrapper"
      style={{
        width: totalWidth,
        height: totalHeight,
        minWidth: totalWidth,
        minHeight: totalHeight,
        borderRadius: borderRadius,
        border: temAro ? `3px solid ${ringColor}` : 'none',
        padding: temAro ? '3px' : 0,
        backgroundColor: temAro ? ringBg : 'transparent',
        boxShadow: temAro ? ringShadow : 'none',
        display: 'inline-flex',
        alignItems: 'center',
        justifyContent: 'center',
        flexShrink: 0,
        position: 'relative',
        boxSizing: 'border-box',
        transition: 'all 0.2s ease',
        ...style
      }}
      title={`Foto de Perfil (${formato === 'circulo' ? 'Circular' : formato === 'quadrado' ? 'Quadrada' : '3x4'})`}
    >
      <div
        className="resume-profile-photo-frame"
        style={{
          width: '100%',
          height: '100%',
          borderRadius: borderRadius,
          overflow: 'hidden',
          backgroundColor: '#f1f5f9',
          border: temAro ? '1px solid rgba(0, 0, 0, 0.08)' : `3px solid ${ringColor}`,
          boxSizing: 'border-box',
          position: 'relative'
        }}
      >
        {/* Imagem do perfil aplicada como Background com enquadramento e escala */}
        <div
          className="resume-profile-photo-bg"
          style={{
            width: '100%',
            height: '100%',
            backgroundImage: `url("${photoUrl}")`,
            backgroundPosition: 'center center',
            backgroundSize: 'cover',
            backgroundRepeat: 'no-repeat',
            transform: `scale(${zoom}) translate(${x}%, ${y}%)`,
            transformOrigin: 'center center',
            borderRadius: borderRadius,
            transition: 'transform 0.1s ease-out'
          }}
        />
      </div>
    </div>
  );
}
