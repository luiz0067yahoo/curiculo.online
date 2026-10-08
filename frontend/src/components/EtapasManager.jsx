import React, { useState } from 'react';
import { 
  ArrowUp, 
  ArrowDown, 
  Plus, 
  Trash2, 
  RotateCcw, 
  Sliders,
  Sparkles
} from 'lucide-react';
import { useI18n } from '../i18n/I18nContext';

export default function EtapasManager({ 
  etapas, 
  onSaveEtapa, 
  onDeleteEtapa, 
  onReorderEtapas, 
  onResetEtapas 
}) {
  const { t } = useI18n();
  const [filterProfile, setFilterProfile] = useState('todos');
  const [showNewModal, setShowNewModal] = useState(false);
  const [newEtapa, setNewEtapa] = useState({
    titulo: '',
    subtitulo: '',
    descricao: '',
    slug: '',
    icone: 'FileText',
    tipo_perfil: 'lattes',
    obrigatoria: false,
    ativo: true
  });

  const filteredEtapas = etapas.filter(e => {
    if (filterProfile === 'todos') return true;
    return e.tipo_perfil === filterProfile || e.tipo_perfil === 'todos';
  });

  const handleMove = (index, direction) => {
    const targetIdx = index + direction;
    if (targetIdx < 0 || targetIdx >= etapas.length) return;
    
    const clone = [...etapas];
    const temp = clone[index];
    clone[index] = clone[targetIdx];
    clone[targetIdx] = temp;
    
    const orderedIds = clone.map(e => e.id);
    onReorderEtapas(orderedIds);
  };

  const handleToggle = (etapa, field) => {
    onSaveEtapa({
      ...etapa,
      [field]: !etapa[field]
    });
  };

  const handleCreateNew = (e) => {
    e.preventDefault();
    if (!newEtapa.titulo) return;

    const slug = newEtapa.slug || newEtapa.titulo.toLowerCase().replace(/[^a-z0-9]/g, '_');
    onSaveEtapa({
      ...newEtapa,
      slug,
      ordem: etapas.length + 1
    });

    setNewEtapa({
      titulo: '',
      subtitulo: '',
      descricao: '',
      slug: '',
      icone: 'FileText',
      tipo_perfil: 'lattes',
      obrigatoria: false,
      ativo: true
    });
    setShowNewModal(false);
  };

  return (
    <div className="card-panel">
      {/* Top Header */}
      <div className="card-panel-header">
        <div className="panel-title-group">
          <div className="panel-icon-badge">
            <Sliders size={22} />
          </div>
          <div>
            <h3 className="panel-title">{t('stagesManager.title')}</h3>
            <p className="panel-subtitle">
              {t('stagesManager.subtitle')}
            </p>
          </div>
        </div>

        <div style={{ display: 'flex', gap: 10, alignItems: 'center' }}>
          <button
            type="button"
            className="btn btn-outline"
            onClick={onResetEtapas}
            title={t('stagesManager.restoreDefaultTooltip')}
          >
            <RotateCcw size={15} /> {t('stagesManager.restoreDefault')}
          </button>

          <button
            type="button"
            className="btn btn-primary"
            onClick={() => setShowNewModal(true)}
          >
            <Plus size={16} /> {t('stagesManager.newStageBtn')}
          </button>
        </div>
      </div>

      {/* Filtros de Perfil */}
      <div style={{ display: 'flex', gap: 10, marginBottom: 20, alignItems: 'center', flexWrap: 'wrap' }}>
        <span style={{ fontSize: '0.85rem', fontWeight: 600, color: 'var(--text-secondary)' }}>
          {t('stagesManager.filterLabel')}
        </span>
        <button
          type="button"
          className={`btn ${filterProfile === 'todos' ? 'btn-primary' : 'btn-secondary'}`}
          style={{ padding: '4px 12px', fontSize: '0.8rem' }}
          onClick={() => setFilterProfile('todos')}
        >
          {t('stagesManager.allStages')} ({etapas.length})
        </button>
        <button
          type="button"
          className={`btn ${filterProfile === 'lattes' ? 'btn-primary' : 'btn-secondary'}`}
          style={{ padding: '4px 12px', fontSize: '0.8rem' }}
          onClick={() => setFilterProfile('lattes')}
        >
          {t('stagesManager.lattesProfile')}
        </button>
        <button
          type="button"
          className={`btn ${filterProfile === 'corporativo' ? 'btn-primary' : 'btn-secondary'}`}
          style={{ padding: '4px 12px', fontSize: '0.8rem' }}
          onClick={() => setFilterProfile('corporativo')}
        >
          {t('stagesManager.corporateProfile')}
        </button>
      </div>

      {/* Lista de Etapas */}
      <div style={{ display: 'flex', flexDirection: 'column', gap: 12 }}>
        {filteredEtapas.map((etapa, idx) => {
          const globalIdx = etapas.findIndex(e => e.id === etapa.id);

          return (
            <div
              key={etapa.id || etapa.slug}
              style={{
                display: 'flex',
                alignItems: 'center',
                justifyContent: 'space-between',
                padding: '14px 18px',
                background: etapa.ativo ? 'var(--bg-tertiary)' : 'var(--bg-secondary)',
                border: '1px solid var(--border-color)',
                borderRadius: 'var(--radius-md)',
                opacity: etapa.ativo ? 1 : 0.65,
                gap: 16,
                flexWrap: 'wrap'
              }}
            >
              {/* Controles de Ordem */}
              <div style={{ display: 'flex', alignItems: 'center', gap: 8 }}>
                <span
                  style={{
                    width: 28,
                    height: 28,
                    borderRadius: '50%',
                    background: 'var(--bg-secondary)',
                    border: '1px solid var(--border-color)',
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    fontWeight: 700,
                    fontSize: '0.8rem'
                  }}
                >
                  {etapa.ordem || globalIdx + 1}
                </span>

                <div style={{ display: 'flex', flexDirection: 'column', gap: 2 }}>
                  <button
                    type="button"
                    className="btn btn-secondary btn-icon"
                    style={{ width: 24, height: 24 }}
                    onClick={() => handleMove(globalIdx, -1)}
                    disabled={globalIdx === 0}
                    title={t('stagesManager.upTooltip')}
                  >
                    <ArrowUp size={12} />
                  </button>
                  <button
                    type="button"
                    className="btn btn-secondary btn-icon"
                    style={{ width: 24, height: 24 }}
                    onClick={() => handleMove(globalIdx, 1)}
                    disabled={globalIdx === etapas.length - 1}
                    title={t('stagesManager.downTooltip')}
                  >
                    <ArrowDown size={12} />
                  </button>
                </div>
              </div>

              {/* Informações da Etapa */}
              <div style={{ flex: 1, minWidth: 220 }}>
                <div style={{ display: 'flex', alignItems: 'center', gap: 8, flexWrap: 'wrap' }}>
                  <strong style={{ fontSize: '0.95rem' }}>{etapa.titulo}</strong>
                  <span
                    style={{
                      fontSize: '0.7rem',
                      padding: '2px 8px',
                      borderRadius: 12,
                      fontWeight: 700,
                      background: etapa.tipo_perfil === 'lattes' ? '#dbeafe' : etapa.tipo_perfil === 'corporativo' ? '#fef3c7' : '#e2e8f0',
                      color: etapa.tipo_perfil === 'lattes' ? '#1e40af' : etapa.tipo_perfil === 'corporativo' ? '#b45309' : '#475569'
                    }}
                  >
                    {etapa.tipo_perfil === 'lattes' ? t('stagesManager.badgeLattes') : etapa.tipo_perfil === 'corporativo' ? t('stagesManager.badgeCorporate') : t('stagesManager.badgeGeneral')}
                  </span>
                  {etapa.obrigatoria && (
                    <span style={{ fontSize: '0.7rem', color: 'var(--danger)', fontWeight: 600 }}>
                      {t('stagesManager.requiredBadge')}
                    </span>
                  )}
                </div>
                <div style={{ fontSize: '0.8rem', color: 'var(--text-muted)', marginTop: 2 }}>
                  {etapa.subtitulo || etapa.descricao} (slug: <code>{etapa.slug}</code>)
                </div>
              </div>

              {/* Switches e Ações */}
              <div style={{ display: 'flex', alignItems: 'center', gap: 16 }}>
                <label className="form-switch">
                  <input
                    type="checkbox"
                    className="switch-input"
                    checked={!!etapa.ativo}
                    onChange={() => handleToggle(etapa, 'ativo')}
                  />
                  <span style={{ fontSize: '0.8rem', fontWeight: 600 }}>
                    {etapa.ativo ? t('stagesManager.activeLabel') : t('stagesManager.inactiveLabel')}
                  </span>
                </label>

                <label className="form-switch">
                  <input
                    type="checkbox"
                    className="switch-input"
                    checked={!!etapa.obrigatoria}
                    onChange={() => handleToggle(etapa, 'obrigatoria')}
                  />
                  <span style={{ fontSize: '0.8rem' }}>{t('stagesManager.requiredSwitch')}</span>
                </label>

                {etapa.id > 10 && (
                  <button
                    type="button"
                    className="btn-remove-item"
                    onClick={() => onDeleteEtapa(etapa.id)}
                    title={t('stagesManager.deleteTooltip')}
                  >
                    <Trash2 size={16} />
                  </button>
                )}
              </div>
            </div>
          );
        })}
      </div>

      {/* Modal para Cadastrar Nova Etapa */}
      {showNewModal && (
        <div style={{ marginTop: 24, padding: 20, background: 'var(--bg-tertiary)', borderRadius: 'var(--radius-lg)', border: '1px solid var(--accent)' }}>
          <h4 style={{ marginBottom: 14, display: 'flex', alignItems: 'center', gap: 8 }}>
            <Sparkles size={18} style={{ color: 'var(--accent)' }} />
            {t('stagesManager.modalTitle')}
          </h4>

          <form onSubmit={handleCreateNew}>
            <div className="form-row">
              <div className="form-group">
                <label className="form-label required">{t('stagesManager.stageTitleInput')}</label>
                <input
                  type="text"
                  className="form-control"
                  placeholder="Ex: Prêmios & Distinções"
                  value={newEtapa.titulo}
                  onChange={e => setNewEtapa({ ...newEtapa, titulo: e.target.value })}
                  required
                />
              </div>

              <div className="form-group">
                <label className="form-label">{t('stagesManager.stageSubtitleInput')}</label>
                <input
                  type="text"
                  className="form-control"
                  placeholder="Ex: Homenagens, comendas e prêmios acadêmicos"
                  value={newEtapa.subtitulo}
                  onChange={e => setNewEtapa({ ...newEtapa, subtitulo: e.target.value })}
                />
              </div>

              <div className="form-group">
                <label className="form-label">{t('stagesManager.profileSelect')}</label>
                <select
                  className="form-select"
                  value={newEtapa.tipo_perfil}
                  onChange={e => setNewEtapa({ ...newEtapa, tipo_perfil: e.target.value })}
                >
                  <option value="todos">{t('stagesManager.profileAll')}</option>
                  <option value="lattes">{t('stagesManager.lattesProfile')}</option>
                  <option value="corporativo">{t('stagesManager.corporateProfile')}</option>
                </select>
              </div>
            </div>

            <div style={{ display: 'flex', justifyContent: 'flex-end', gap: 10, marginTop: 12 }}>
              <button
                type="button"
                className="btn btn-secondary"
                onClick={() => setShowNewModal(false)}
              >
                {t('stagesManager.cancelBtn')}
              </button>
              <button
                type="submit"
                className="btn btn-primary"
              >
                {t('stagesManager.saveStageBtn')}
              </button>
            </div>
          </form>
        </div>
      )}
    </div>
  );
}
