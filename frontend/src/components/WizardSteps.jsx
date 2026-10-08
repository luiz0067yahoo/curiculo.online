import React, { useState } from 'react';
import { 
  ChevronRight, 
  ChevronLeft, 
  Plus, 
  Trash2, 
  Wand2, 
  Check, 
  User, 
  Award, 
  GraduationCap, 
  Briefcase, 
  Search, 
  BookOpen, 
  FolderGit2, 
  Languages, 
  Compass, 
  Home 
} from 'lucide-react';
import { useI18n } from '../i18n/I18nContext';

const iconMap = {
  User,
  Award,
  GraduationCap,
  Briefcase,
  Search,
  BookOpen,
  FolderGit2,
  Languages,
  Compass,
  Home
};

export default function WizardSteps({ 
  etapas, 
  formData, 
  setFormData, 
  onGenerateLattesSummary, 
  isGeneratingSummary 
}) {
  const { t } = useI18n();
  const activeEtapas = etapas.filter(e => e.ativo);
  const [currentStepIdx, setCurrentStepIdx] = useState(0);

  const currentEtapa = activeEtapas[currentStepIdx] || activeEtapas[0];
  const totalSteps = activeEtapas.length;

  const handleChange = (section, field, value) => {
    setFormData(prev => ({
      ...prev,
      [section]: {
        ...(prev[section] || {}),
        [field]: value
      }
    }));
  };

  const handleArrayChange = (section, index, field, value) => {
    setFormData(prev => {
      const list = [...(prev[section] || [])];
      list[index] = { ...list[index], [field]: value };
      return { ...prev, [section]: list };
    });
  };

  const handleAddItem = (section, defaultItem) => {
    setFormData(prev => ({
      ...prev,
      [section]: [...(prev[section] || []), { id: Date.now(), ...defaultItem }]
    }));
  };

  const handleRemoveItem = (section, index) => {
    setFormData(prev => {
      const list = [...(prev[section] || [])];
      list.splice(index, 1);
      return { ...prev, [section]: list };
    });
  };

  const IconComponent = iconMap[currentEtapa?.icone] || Award;

  return (
    <div className="card-panel">
      {/* Stepper Superior */}
      <div className="wizard-stepper">
        {activeEtapas.map((step, idx) => {
          const isActive = idx === currentStepIdx;
          const isDone = idx < currentStepIdx;

          return (
            <div
              key={step.id || step.slug}
              className={`wizard-step-item ${isActive ? 'active' : ''}`}
              onClick={() => setCurrentStepIdx(idx)}
              title={step.titulo}
            >
              <div className="step-num">
                {isDone ? <Check size={14} /> : idx + 1}
              </div>
              <div style={{ overflow: 'hidden' }}>
                <div className="step-label">{step.titulo}</div>
                <div className="step-sub">
                  {t('wizard.stepOf', { current: idx + 1, total: totalSteps })}
                </div>
              </div>
            </div>
          );
        })}
      </div>

      {/* Cabeçalho da Etapa Atual */}
      <div className="card-panel-header">
        <div className="panel-title-group">
          <div className="panel-icon-badge">
            <IconComponent size={22} />
          </div>
          <div>
            <h3 className="panel-title">{currentEtapa?.titulo}</h3>
            <p className="panel-subtitle">{currentEtapa?.subtitulo || currentEtapa?.descricao}</p>
          </div>
        </div>
        <div style={{ fontSize: '0.85rem', color: 'var(--text-muted)', fontWeight: 600 }}>
          {currentStepIdx + 1} / {totalSteps}
        </div>
      </div>

      {/* Conteúdo Dinâmico por Slug da Etapa */}
      <div className="wizard-step-content" style={{ minHeight: '380px' }}>
        
        {/* 1. DADOS BÁSICOS */}
        {currentEtapa?.slug === 'dados_basicos' && (
          <div>
            <div className="form-group">
              <label className="form-label required">{t('fields.fullName')}</label>
              <input
                type="text"
                className="form-control"
                placeholder="Ex: Dr. Leonardo Albuquerque Silveira"
                value={formData.dados_basicos?.nome || ''}
                onChange={e => handleChange('dados_basicos', 'nome', e.target.value)}
              />
            </div>

            <div className="form-row">
              <div className="form-group">
                <label className="form-label">{t('fields.gender')}</label>
                <select
                  className="form-select"
                  value={formData.dados_basicos?.sexo || t('fields.genderMale')}
                  onChange={e => handleChange('dados_basicos', 'sexo', e.target.value)}
                >
                  <option value={t('fields.genderMale')}>{t('fields.genderMale')}</option>
                  <option value={t('fields.genderFemale')}>{t('fields.genderFemale')}</option>
                  <option value={t('fields.genderOther')}>{t('fields.genderOther')}</option>
                </select>
              </div>

              <div className="form-group">
                <label className="form-label required">{t('fields.email')}</label>
                <input
                  type="email"
                  className="form-control"
                  placeholder="seuemail@instituicao.edu.br"
                  value={formData.dados_basicos?.email || ''}
                  onChange={e => handleChange('dados_basicos', 'email', e.target.value)}
                />
              </div>

              <div className="form-group">
                <label className="form-label">{t('fields.birthDate')}</label>
                <input
                  type="date"
                  className="form-control"
                  value={formData.dados_basicos?.data_nascimento || ''}
                  onChange={e => handleChange('dados_basicos', 'data_nascimento', e.target.value)}
                />
              </div>
            </div>

            <div className="form-row">
              <div className="form-group">
                <label className="form-label">{t('fields.cellphone')}</label>
                <input
                  type="tel"
                  className="form-control"
                  placeholder="(11) 98765-4321"
                  value={formData.dados_basicos?.celular || ''}
                  onChange={e => handleChange('dados_basicos', 'celular', e.target.value)}
                />
              </div>

              <div className="form-group">
                <label className="form-label">{t('fields.phone')}</label>
                <input
                  type="tel"
                  className="form-control"
                  placeholder="(11) 3214-5678"
                  value={formData.dados_basicos?.telefone || ''}
                  onChange={e => handleChange('dados_basicos', 'telefone', e.target.value)}
                />
              </div>

              <div className="form-group">
                <label className="form-label">{t('fields.salaryExpectation')}</label>
                <input
                  type="text"
                  className="form-control"
                  placeholder="Ex: 15.000,00"
                  value={formData.dados_basicos?.pretensao_salarial || ''}
                  onChange={e => handleChange('dados_basicos', 'pretensao_salarial', e.target.value)}
                />
              </div>
            </div>

            <div style={{ marginTop: 16 }}>
              <h4 style={{ fontSize: '0.95rem', marginBottom: 10, color: 'var(--text-secondary)' }}>
                {t('wizard.socialProfiles')}
              </h4>
              <div className="form-row">
                <div className="form-group">
                  <label className="form-label">{t('fields.linkedin')}</label>
                  <input
                    type="text"
                    className="form-control"
                    placeholder="linkedin.com/in/usuario"
                    value={formData.dados_basicos?.linkedin || ''}
                    onChange={e => handleChange('dados_basicos', 'linkedin', e.target.value)}
                  />
                </div>
                <div className="form-group">
                  <label className="form-label">{t('fields.github')}</label>
                  <input
                    type="text"
                    className="form-control"
                    placeholder="github.com/usuario"
                    value={formData.dados_basicos?.github || ''}
                    onChange={e => handleChange('dados_basicos', 'github', e.target.value)}
                  />
                </div>
                <div className="form-group">
                  <label className="form-label">{t('fields.website')}</label>
                  <input
                    type="text"
                    className="form-control"
                    placeholder="https://meusite.com"
                    value={formData.dados_basicos?.website || ''}
                    onChange={e => handleChange('dados_basicos', 'website', e.target.value)}
                  />
                </div>
              </div>
            </div>
          </div>
        )}

        {/* 2. IDENTIFICADORES LATTES & CNPQ */}
        {currentEtapa?.slug === 'identificadores_lattes' && (
          <div>
            <div className="form-row">
              <div className="form-group">
                <label className="form-label required">{t('fields.lattesId')}</label>
                <input
                  type="text"
                  className="form-control"
                  placeholder="Ex: 4918237401928472"
                  value={formData.identificadores_lattes?.id_lattes || ''}
                  onChange={e => handleChange('identificadores_lattes', 'id_lattes', e.target.value)}
                />
              </div>

              <div className="form-group">
                <label className="form-label">{t('fields.lattesLink')}</label>
                <input
                  type="text"
                  className="form-control"
                  placeholder="http://lattes.cnpq.br/4918237401928472"
                  value={formData.identificadores_lattes?.link_lattes || ''}
                  onChange={e => handleChange('identificadores_lattes', 'link_lattes', e.target.value)}
                />
              </div>

              <div className="form-group">
                <label className="form-label">{t('fields.orcid')}</label>
                <input
                  type="text"
                  className="form-control"
                  placeholder="0000-0002-1825-0097"
                  value={formData.identificadores_lattes?.orcid || ''}
                  onChange={e => handleChange('identificadores_lattes', 'orcid', e.target.value)}
                />
              </div>
            </div>

            <div className="form-group">
              <label className="form-label">{t('fields.citations')}</label>
              <input
                type="text"
                className="form-control"
                placeholder="Ex: SILVEIRA, L. A.; SILVEIRA, Leonardo A."
                value={formData.identificadores_lattes?.citacoes_bibliograficas || ''}
                onChange={e => handleChange('identificadores_lattes', 'citacoes_bibliograficas', e.target.value)}
              />
            </div>

            <div className="form-group">
              <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 6 }}>
                <label className="form-label required" style={{ margin: 0 }}>
                  {t('fields.academicSummary')}
                </label>
                <button
                  type="button"
                  className="btn btn-outline"
                  style={{ padding: '4px 10px', fontSize: '0.78rem' }}
                  onClick={onGenerateLattesSummary}
                  disabled={isGeneratingSummary}
                  title={t('wizard.generateSummaryTooltip')}
                >
                  <Wand2 size={13} style={{ color: '#2563eb' }} />
                  <span>{isGeneratingSummary ? t('wizard.generatingSummary') : t('wizard.generateSummaryBtn')}</span>
                </button>
              </div>
              <textarea
                className="form-control"
                rows={5}
                placeholder={t('fields.academicSummaryPlaceholder')}
                value={formData.identificadores_lattes?.resumo_academico || ''}
                onChange={e => handleChange('identificadores_lattes', 'resumo_academico', e.target.value)}
              />
            </div>
          </div>
        )}

        {/* 3. FORMAÇÃO ACADÊMICA */}
        {currentEtapa?.slug === 'formacao_academica' && (
          <div>
            {(formData.formacao_academica || []).map((item, idx) => (
              <div key={item.id || idx} className="repeater-card">
                <div className="repeater-card-header">
                  <span className="repeater-tag">
                    #{idx + 1} — {item.nivel_label || item.nivel || t('fields.educationLevel')}
                  </span>
                  <button
                    type="button"
                    className="btn-remove-item"
                    onClick={() => handleRemoveItem('formacao_academica', idx)}
                  >
                    <Trash2 size={15} /> {t('wizard.removeItem')}
                  </button>
                </div>

                <div className="form-row-3">
                  <div className="form-group">
                    <label className="form-label">{t('fields.educationLevel')}</label>
                    <select
                      className="form-select"
                      value={item.nivel || 'Doutorado'}
                      onChange={e => {
                        const val = e.target.value;
                        handleArrayChange('formacao_academica', idx, 'nivel', val);
                        handleArrayChange('formacao_academica', idx, 'nivel_label', e.target.options[e.target.selectedIndex].text);
                      }}
                    >
                      <option value="Doutorado">Doutorado (PhD)</option>
                      <option value="Mestrado">Mestrado (M.Sc.)</option>
                      <option value="Pos_Graduacao">Pós-Graduação / Especialização</option>
                      <option value="Ensino_Superior">Ensino Superior / Graduação</option>
                      <option value="Pos_Doutorado">Pós-Doutorado (Postdoc)</option>
                      <option value="Ensino_Medio">Ensino Médio</option>
                    </select>
                  </div>

                  <div className="form-group">
                    <label className="form-label required">{t('fields.course')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="Ex: Ciência da Computação"
                      value={item.curso || ''}
                      onChange={e => handleArrayChange('formacao_academica', idx, 'curso', e.target.value)}
                    />
                  </div>

                  <div className="form-group">
                    <label className="form-label required">{t('fields.institution')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="Ex: Universidade de São Paulo (USP)"
                      value={item.instituicao || ''}
                      onChange={e => handleArrayChange('formacao_academica', idx, 'instituicao', e.target.value)}
                    />
                  </div>
                </div>

                <div className="form-row-3">
                  <div className="form-group">
                    <label className="form-label">{t('fields.status')}</label>
                    <select
                      className="form-select"
                      value={item.situacao || 'Concluído'}
                      onChange={e => handleArrayChange('formacao_academica', idx, 'situacao', e.target.value)}
                    >
                      <option value="Concluído">{t('fields.statusCompleted')}</option>
                      <option value="Em andamento">{t('fields.statusInProgress')}</option>
                      <option value="Incompleto">{t('fields.statusIncomplete')}</option>
                    </select>
                  </div>

                  <div className="form-group">
                    <label className="form-label">{t('fields.startYear')}</label>
                    <input
                      type="number"
                      className="form-control"
                      placeholder="2016"
                      value={item.ano_inicio || ''}
                      onChange={e => handleArrayChange('formacao_academica', idx, 'ano_inicio', e.target.value)}
                    />
                  </div>

                  <div className="form-group">
                    <label className="form-label">{t('fields.endYear')}</label>
                    <input
                      type="number"
                      className="form-control"
                      placeholder="2020"
                      value={item.ano_conclusao || ''}
                      onChange={e => handleArrayChange('formacao_academica', idx, 'ano_conclusao', e.target.value)}
                    />
                  </div>
                </div>

                <div className="form-row">
                  <div className="form-group">
                    <label className="form-label">{t('fields.thesisTitle')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="Título completo do trabalho final"
                      value={item.titulo_tese || ''}
                      onChange={e => handleArrayChange('formacao_academica', idx, 'titulo_tese', e.target.value)}
                    />
                  </div>
                  <div className="form-group">
                    <label className="form-label">{t('fields.advisor')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="Ex: Prof. Dr. Carlos Eduardo de Moura"
                      value={item.orientador || ''}
                      onChange={e => handleArrayChange('formacao_academica', idx, 'orientador', e.target.value)}
                    />
                  </div>
                  <div className="form-group">
                    <label className="form-label">{t('fields.grantAgency')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="Ex: Bolsista CNPq, FAPESP, CAPES"
                      value={item.bolsa || ''}
                      onChange={e => handleArrayChange('formacao_academica', idx, 'bolsa', e.target.value)}
                    />
                  </div>
                </div>
              </div>
            ))}

            <button
              type="button"
              className="btn btn-secondary"
              onClick={() => handleAddItem('formacao_academica', {
                nivel: 'Ensino_Superior',
                nivel_label: 'Graduação',
                curso: '',
                instituicao: '',
                ano_inicio: '',
                ano_conclusao: '',
                situacao: 'Concluído'
              })}
            >
              <Plus size={16} /> {t('wizard.addAcademic')}
            </button>
          </div>
        )}

        {/* 4. ATUAÇÃO PROFISSIONAL */}
        {currentEtapa?.slug === 'atuacao_profissional' && (
          <div>
            <div className="form-group">
              <label className="form-label">{t('fields.careerGoal')}</label>
              <textarea
                className="form-control"
                rows={2}
                placeholder={t('fields.careerGoalPlaceholder')}
                value={formData.dados_basicos?.objetivo_profissional || ''}
                onChange={e => handleChange('dados_basicos', 'objetivo_profissional', e.target.value)}
              />
            </div>

            <h4 style={{ fontSize: '0.95rem', margin: '18px 0 10px 0', color: 'var(--text-secondary)' }}>
              {t('wizard.institutionalHistory')}
            </h4>

            {(formData.atuacao_profissional || []).map((item, idx) => (
              <div key={item.id || idx} className="repeater-card">
                <div className="repeater-card-header">
                  <span className="repeater-tag">#{idx + 1} — {item.empresa || 'Nova Empresa'}</span>
                  <button
                    type="button"
                    className="btn-remove-item"
                    onClick={() => handleRemoveItem('atuacao_profissional', idx)}
                  >
                    <Trash2 size={15} /> {t('wizard.removeItem')}
                  </button>
                </div>

                <div className="form-row">
                  <div className="form-group">
                    <label className="form-label required">{t('fields.company')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="Nome da empresa ou universidade"
                      value={item.empresa || ''}
                      onChange={e => handleArrayChange('atuacao_profissional', idx, 'empresa', e.target.value)}
                    />
                  </div>

                  <div className="form-group">
                    <label className="form-label required">{t('fields.position')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="Ex: Professor Adjunto / Pesquisador Sênior"
                      value={item.cargo || ''}
                      onChange={e => handleArrayChange('atuacao_profissional', idx, 'cargo', e.target.value)}
                    />
                  </div>
                </div>

                <div className="form-row-3">
                  <div className="form-group">
                    <label className="form-label">{t('fields.startYear')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="Ex: 2021"
                      value={item.ano_inicio || ''}
                      onChange={e => handleArrayChange('atuacao_profissional', idx, 'ano_inicio', e.target.value)}
                    />
                  </div>

                  <div className="form-group">
                    <label className="form-label">{t('fields.endYearCurrent')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="Ex: Atual"
                      value={item.ano_fim || ''}
                      onChange={e => handleArrayChange('atuacao_profissional', idx, 'ano_fim', e.target.value)}
                    />
                  </div>

                  <div className="form-group">
                    <label className="form-label">{t('fields.workRegime')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="Ex: 40h Dedicação Exclusiva"
                      value={item.regime || ''}
                      onChange={e => handleArrayChange('atuacao_profissional', idx, 'regime', e.target.value)}
                    />
                  </div>
                </div>

                <div className="form-group">
                  <label className="form-label">{t('fields.jobDescription')}</label>
                  <textarea
                    className="form-control"
                    rows={2}
                    placeholder={t('fields.jobDescriptionPlaceholder')}
                    value={item.descricao || ''}
                    onChange={e => handleArrayChange('atuacao_profissional', idx, 'descricao', e.target.value)}
                  />
                </div>
              </div>
            ))}

            <button
              type="button"
              className="btn btn-secondary"
              onClick={() => handleAddItem('atuacao_profissional', {
                empresa: '',
                cargo: '',
                ano_inicio: '',
                ano_fim: 'Atual',
                regime: '40h semanais',
                descricao: ''
              })}
            >
              <Plus size={16} /> {t('wizard.addExperience')}
            </button>
          </div>
        )}

        {/* 5. LINHAS DE PESQUISA */}
        {currentEtapa?.slug === 'linhas_pesquisa' && (
          <div>
            {(formData.linhas_pesquisa || []).map((item, idx) => (
              <div key={item.id || idx} className="repeater-card">
                <div className="repeater-card-header">
                  <span className="repeater-tag">#{idx + 1} — {item.nome || t('fields.researchLine')}</span>
                  <button
                    type="button"
                    className="btn-remove-item"
                    onClick={() => handleRemoveItem('linhas_pesquisa', idx)}
                  >
                    <Trash2 size={15} /> {t('wizard.removeItem')}
                  </button>
                </div>

                <div className="form-row">
                  <div className="form-group">
                    <label className="form-label required">{t('fields.researchLine')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="Ex: Processamento de Linguagem Natural e Modelos Neurais"
                      value={item.nome || ''}
                      onChange={e => handleArrayChange('linhas_pesquisa', idx, 'nome', e.target.value)}
                    />
                  </div>

                  <div className="form-group">
                    <label className="form-label">{t('fields.greatArea')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="Ex: Ciências Exatas e da Terra"
                      value={item.grande_area || ''}
                      onChange={e => handleArrayChange('linhas_pesquisa', idx, 'grande_area', e.target.value)}
                    />
                  </div>
                </div>

                <div className="form-row">
                  <div className="form-group">
                    <label className="form-label">{t('fields.area')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="Ex: Ciência da Computação"
                      value={item.area || ''}
                      onChange={e => handleArrayChange('linhas_pesquisa', idx, 'area', e.target.value)}
                    />
                  </div>
                  <div className="form-group">
                    <label className="form-label">{t('fields.subarea')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="Ex: Sistemas de Computação"
                      value={item.subarea || ''}
                      onChange={e => handleArrayChange('linhas_pesquisa', idx, 'subarea', e.target.value)}
                    />
                  </div>
                </div>
              </div>
            ))}

            <button
              type="button"
              className="btn btn-secondary"
              onClick={() => handleAddItem('linhas_pesquisa', {
                nome: '',
                grande_area: 'Ciências Exatas e da Terra',
                area: 'Ciência da Computação',
                subarea: ''
              })}
            >
              <Plus size={16} /> {t('wizard.addResearchLine')}
            </button>
          </div>
        )}

        {/* 6. PRODUÇÃO BIBLIOGRÁFICA */}
        {currentEtapa?.slug === 'producao_bibliografica' && (
          <div>
            {(formData.producao_bibliografica || []).map((item, idx) => (
              <div key={item.id || idx} className="repeater-card">
                <div className="repeater-card-header">
                  <span className="repeater-tag">#{idx + 1} — {item.tipo || 'Artigo'}</span>
                  <button
                    type="button"
                    className="btn-remove-item"
                    onClick={() => handleRemoveItem('producao_bibliografica', idx)}
                  >
                    <Trash2 size={15} /> {t('wizard.removeItem')}
                  </button>
                </div>

                <div className="form-row">
                  <div className="form-group" style={{ flex: '1 1 200px' }}>
                    <label className="form-label">{t('fields.pubType')}</label>
                    <select
                      className="form-select"
                      value={item.tipo || 'Artigo em Periódico'}
                      onChange={e => handleArrayChange('producao_bibliografica', idx, 'tipo', e.target.value)}
                    >
                      <option value="Artigo em Periódico">{t('fields.pubTypeArticle')}</option>
                      <option value="Trabalho em Evento">{t('fields.pubTypeEvent')}</option>
                      <option value="Livro Publicado">{t('fields.pubTypeBook')}</option>
                      <option value="Capítulo de Livro">{t('fields.pubTypeChapter')}</option>
                      <option value="Patente Registrada">{t('fields.pubTypePatent')}</option>
                    </select>
                  </div>

                  <div className="form-group" style={{ flex: '2 1 300px' }}>
                    <label className="form-label required">{t('fields.pubTitle')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="Título completo do artigo ou trabalho"
                      value={item.titulo || ''}
                      onChange={e => handleArrayChange('producao_bibliografica', idx, 'titulo', e.target.value)}
                    />
                  </div>
                </div>

                <div className="form-row">
                  <div className="form-group">
                    <label className="form-label">{t('fields.pubAuthors')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="SILVEIRA, L. A.; MOURA, C. E."
                      value={item.autores || ''}
                      onChange={e => handleArrayChange('producao_bibliografica', idx, 'autores', e.target.value)}
                    />
                  </div>

                  <div className="form-group">
                    <label className="form-label">{t('fields.pubJournal')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="Nome do periódico ou evento científico"
                      value={item.revista || ''}
                      onChange={e => handleArrayChange('producao_bibliografica', idx, 'revista', e.target.value)}
                    />
                  </div>
                </div>

                <div className="form-row-3">
                  <div className="form-group">
                    <label className="form-label">{t('fields.pubYear')}</label>
                    <input
                      type="number"
                      className="form-control"
                      placeholder="2025"
                      value={item.ano || ''}
                      onChange={e => handleArrayChange('producao_bibliografica', idx, 'ano', e.target.value)}
                    />
                  </div>
                  <div className="form-group">
                    <label className="form-label">{t('fields.pubVolumePages')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="v. 37, p. 142-155"
                      value={item.volume ? `v. ${item.volume}, p. ${item.paginas || '-'}` : (item.paginas || '')}
                      onChange={e => handleArrayChange('producao_bibliografica', idx, 'paginas', e.target.value)}
                    />
                  </div>
                  <div className="form-group">
                    <label className="form-label">{t('fields.pubDoi')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="10.1109/TKDE.2025.123"
                      value={item.doi || ''}
                      onChange={e => handleArrayChange('producao_bibliografica', idx, 'doi', e.target.value)}
                    />
                  </div>
                </div>
              </div>
            ))}

            <button
              type="button"
              className="btn btn-secondary"
              onClick={() => handleAddItem('producao_bibliografica', {
                tipo: 'Artigo em Periódico',
                titulo: '',
                revista: '',
                ano: new Date().getFullYear(),
                autores: '',
                qualis: 'Qualis A1'
              })}
            >
              <Plus size={16} /> {t('wizard.addPublication')}
            </button>
          </div>
        )}

        {/* 7. PROJETOS DE PESQUISA */}
        {currentEtapa?.slug === 'projetos_pesquisa' && (
          <div>
            {(formData.projetos_pesquisa || []).map((item, idx) => (
              <div key={item.id || idx} className="repeater-card">
                <div className="repeater-card-header">
                  <span className="repeater-tag">#{idx + 1} — {item.titulo || t('fields.projectTitle')}</span>
                  <button
                    type="button"
                    className="btn-remove-item"
                    onClick={() => handleRemoveItem('projetos_pesquisa', idx)}
                  >
                    <Trash2 size={15} /> {t('wizard.removeItem')}
                  </button>
                </div>

                <div className="form-group">
                  <label className="form-label required">{t('fields.projectTitle')}</label>
                  <input
                    type="text"
                    className="form-control"
                    placeholder="Título do projeto de pesquisa financiado"
                    value={item.titulo || ''}
                    onChange={e => handleArrayChange('projetos_pesquisa', idx, 'titulo', e.target.value)}
                  />
                </div>

                <div className="form-row-3">
                  <div className="form-group">
                    <label className="form-label">{t('fields.startYear')}</label>
                    <input
                      type="number"
                      className="form-control"
                      placeholder="2023"
                      value={item.ano_inicio || ''}
                      onChange={e => handleArrayChange('projetos_pesquisa', idx, 'ano_inicio', e.target.value)}
                    />
                  </div>
                  <div className="form-group">
                    <label className="form-label">{t('fields.endYearCurrent')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="Atual"
                      value={item.ano_fim || ''}
                      onChange={e => handleArrayChange('projetos_pesquisa', idx, 'ano_fim', e.target.value)}
                    />
                  </div>
                  <div className="form-group">
                    <label className="form-label">{t('fields.projectAgency')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="Ex: CNPq, CAPES, FAPESP"
                      value={item.fomento || ''}
                      onChange={e => handleArrayChange('projetos_pesquisa', idx, 'fomento', e.target.value)}
                    />
                  </div>
                </div>

                <div className="form-group">
                  <label className="form-label">{t('fields.projectDescription')}</label>
                  <textarea
                    className="form-control"
                    rows={2}
                    placeholder={t('fields.projectDescriptionPlaceholder')}
                    value={item.descricao || ''}
                    onChange={e => handleArrayChange('projetos_pesquisa', idx, 'descricao', e.target.value)}
                  />
                </div>
              </div>
            ))}

            <button
              type="button"
              className="btn btn-secondary"
              onClick={() => handleAddItem('projetos_pesquisa', {
                titulo: '',
                ano_inicio: 2023,
                ano_fim: 'Atual',
                fomento: 'CNPq',
                descricao: ''
              })}
            >
              <Plus size={16} /> {t('wizard.addProject')}
            </button>
          </div>
        )}

        {/* 8. IDIOMAS E CONHECIMENTOS */}
        {currentEtapa?.slug === 'conhecimentos_idiomas' && (
          <div>
            <h4 style={{ fontSize: '0.95rem', marginBottom: 10, color: 'var(--text-secondary)' }}>
              {t('wizard.foreignLanguages')}
            </h4>
            {(formData.conhecimentos_idiomas?.idiomas || []).map((item, idx) => (
              <div key={item.id || idx} className="repeater-card">
                <div className="repeater-card-header">
                  <span className="repeater-tag">#{idx + 1} — {item.idioma || t('fields.language')}</span>
                  <button
                    type="button"
                    className="btn-remove-item"
                    onClick={() => {
                      const list = [...(formData.conhecimentos_idiomas?.idiomas || [])];
                      list.splice(idx, 1);
                      handleChange('conhecimentos_idiomas', 'idiomas', list);
                    }}
                  >
                    <Trash2 size={15} /> {t('wizard.removeItem')}
                  </button>
                </div>

                <div className="form-row">
                  <div className="form-group">
                    <label className="form-label required">{t('fields.language')}</label>
                    <input
                      type="text"
                      className="form-control"
                      placeholder="Ex: Inglês, Espanhol, Francês"
                      value={item.idioma || ''}
                      onChange={e => {
                        const list = [...(formData.conhecimentos_idiomas?.idiomas || [])];
                        list[idx] = { ...list[idx], idioma: e.target.value };
                        handleChange('conhecimentos_idiomas', 'idiomas', list);
                      }}
                    />
                  </div>

                  <div className="form-group">
                    <label className="form-label">{t('fields.languageFluency')}</label>
                    <select
                      className="form-select"
                      value={item.nivel || t('fields.fluencyFluent')}
                      onChange={e => {
                        const list = [...(formData.conhecimentos_idiomas?.idiomas || [])];
                        list[idx] = { ...list[idx], nivel: e.target.value };
                        handleChange('conhecimentos_idiomas', 'idiomas', list);
                      }}
                    >
                      <option value={t('fields.fluencyBasic')}>{t('fields.fluencyBasic')}</option>
                      <option value={t('fields.fluencyIntermediate')}>{t('fields.fluencyIntermediate')}</option>
                      <option value={t('fields.fluencyAdvanced')}>{t('fields.fluencyAdvanced')}</option>
                      <option value={t('fields.fluencyFluent')}>{t('fields.fluencyFluent')}</option>
                    </select>
                  </div>
                </div>
              </div>
            ))}

            <button
              type="button"
              className="btn btn-secondary"
              style={{ marginBottom: 20 }}
              onClick={() => {
                const list = [...(formData.conhecimentos_idiomas?.idiomas || [])];
                list.push({ id: Date.now(), idioma: '', nivel: t('fields.fluencyAdvanced') });
                handleChange('conhecimentos_idiomas', 'idiomas', list);
              }}
            >
              <Plus size={16} /> {t('wizard.addLanguage')}
            </button>

            <h4 style={{ fontSize: '0.95rem', margin: '14px 0 10px 0', color: 'var(--text-secondary)' }}>
              {t('wizard.techSkills')}
            </h4>
            {(formData.conhecimentos_idiomas?.conhecimentos || []).map((item, idx) => (
              <div key={item.id || idx} style={{ display: 'flex', gap: 10, marginBottom: 8, alignItems: 'center' }}>
                <input
                  type="text"
                  className="form-control"
                  placeholder="Ex: PHP 8, MySQL, Python, React"
                  value={item.nome || ''}
                  onChange={e => {
                    const list = [...(formData.conhecimentos_idiomas?.conhecimentos || [])];
                    list[idx] = { ...list[idx], nome: e.target.value };
                    handleChange('conhecimentos_idiomas', 'conhecimentos', list);
                  }}
                />
                <select
                  className="form-select"
                  style={{ width: '160px', flexShrink: 0 }}
                  value={item.nivel || t('fields.fluencyAdvanced')}
                  onChange={e => {
                    const list = [...(formData.conhecimentos_idiomas?.conhecimentos || [])];
                    list[idx] = { ...list[idx], nivel: e.target.value };
                    handleChange('conhecimentos_idiomas', 'conhecimentos', list);
                  }}
                >
                  <option value={t('fields.fluencyBasic')}>{t('fields.fluencyBasic')}</option>
                  <option value={t('fields.fluencyIntermediate')}>{t('fields.fluencyIntermediate')}</option>
                  <option value={t('fields.fluencyAdvanced')}>{t('fields.fluencyAdvanced')}</option>
                  <option value={t('fields.skillExpert')}>{t('fields.skillExpert')}</option>
                </select>
                <button
                  type="button"
                  className="btn-remove-item"
                  onClick={() => {
                    const list = [...(formData.conhecimentos_idiomas?.conhecimentos || [])];
                    list.splice(idx, 1);
                    handleChange('conhecimentos_idiomas', 'conhecimentos', list);
                  }}
                >
                  <Trash2 size={16} />
                </button>
              </div>
            ))}

            <button
              type="button"
              className="btn btn-secondary"
              onClick={() => {
                const list = [...(formData.conhecimentos_idiomas?.conhecimentos || [])];
                list.push({ id: Date.now(), nome: '', nivel: t('fields.fluencyAdvanced') });
                handleChange('conhecimentos_idiomas', 'conhecimentos', list);
              }}
            >
              <Plus size={16} /> {t('wizard.addSkill')}
            </button>
          </div>
        )}

        {/* 9. CARGO PRETENDIDO */}
        {currentEtapa?.slug === 'cargo_pretendido' && (
          <div>
            <div className="form-row">
              <div className="form-group">
                <label className="form-label required">{t('fields.targetArea')}</label>
                <input
                  type="text"
                  className="form-control"
                  placeholder="Ex: Ciência de Dados & Pesquisa Aplicada"
                  value={formData.cargo_pretendido?.area_pretendida || ''}
                  onChange={e => handleChange('cargo_pretendido', 'area_pretendida', e.target.value)}
                />
              </div>

              <div className="form-group">
                <label className="form-label required">{t('fields.targetRole')}</label>
                <input
                  type="text"
                  className="form-control"
                  placeholder="Ex: Pesquisador Titular / Professor Adjunto"
                  value={formData.cargo_pretendido?.cargo_pretendido || ''}
                  onChange={e => handleChange('cargo_pretendido', 'cargo_pretendido', e.target.value)}
                />
              </div>
            </div>

            <div className="form-row">
              <div className="form-group">
                <label className="form-label">{t('fields.contractType')}</label>
                <input
                  type="text"
                  className="form-control"
                  placeholder="Ex: Dedicação Exclusiva / CLT / Híbrido"
                  value={formData.cargo_pretendido?.tipo_contratacao || ''}
                  onChange={e => handleChange('cargo_pretendido', 'tipo_contratacao', e.target.value)}
                />
              </div>

              <div className="form-group">
                <label className="form-label">{t('fields.availability')}</label>
                <input
                  type="text"
                  className="form-control"
                  placeholder="Ex: Imediata / 30 dias"
                  value={formData.cargo_pretendido?.disponibilidade_inicio || ''}
                  onChange={e => handleChange('cargo_pretendido', 'disponibilidade_inicio', e.target.value)}
                />
              </div>
            </div>
          </div>
        )}

        {/* 10. DADOS PESSOAIS & ENDEREÇO */}
        {currentEtapa?.slug === 'dados_pessoais' && (
          <div>
            <div className="form-row">
              <div className="form-group">
                <label className="form-label">{t('fields.maritalStatus')}</label>
                <select
                  className="form-select"
                  value={formData.dados_pessoais?.estado_civil || t('fields.maritalSingle')}
                  onChange={e => handleChange('dados_pessoais', 'estado_civil', e.target.value)}
                >
                  <option value={t('fields.maritalSingle')}>{t('fields.maritalSingle')}</option>
                  <option value={t('fields.maritalMarried')}>{t('fields.maritalMarried')}</option>
                  <option value={t('fields.maritalUnion')}>{t('fields.maritalUnion')}</option>
                  <option value={t('fields.maritalSeparated')}>{t('fields.maritalSeparated')}</option>
                  <option value={t('fields.maritalDivorced')}>{t('fields.maritalDivorced')}</option>
                  <option value={t('fields.maritalWidowed')}>{t('fields.maritalWidowed')}</option>
                </select>
              </div>

              <div className="form-group">
                <label className="form-label">{t('fields.childrenCount')}</label>
                <input
                  type="number"
                  className="form-control"
                  placeholder="0"
                  value={formData.dados_pessoais?.filhos || '0'}
                  onChange={e => handleChange('dados_pessoais', 'filhos', e.target.value)}
                />
              </div>

              <div className="form-group">
                <label className="form-label">{t('fields.photoUrl')}</label>
                <input
                  type="text"
                  className="form-control"
                  placeholder="https://exemplo.com/foto.jpg"
                  value={formData.dados_pessoais?.foto_url || ''}
                  onChange={e => handleChange('dados_pessoais', 'foto_url', e.target.value)}
                />
              </div>
            </div>

            <div className="form-row" style={{ marginTop: 8, marginBottom: 16 }}>
              <label className="form-switch">
                <input
                  type="checkbox"
                  className="switch-input"
                  checked={!!formData.dados_pessoais?.aceita_viajar}
                  onChange={e => handleChange('dados_pessoais', 'aceita_viajar', e.target.checked)}
                />
                <span>{t('fields.travelAvailability')}</span>
              </label>

              <label className="form-switch">
                <input
                  type="checkbox"
                  className="switch-input"
                  checked={!!formData.dados_pessoais?.disponivel_mudanca}
                  onChange={e => handleChange('dados_pessoais', 'disponivel_mudanca', e.target.checked)}
                />
                <span>{t('fields.relocationAvailability')}</span>
              </label>
            </div>

            <h4 style={{ fontSize: '0.95rem', margin: '14px 0 10px 0', color: 'var(--text-secondary)' }}>
              {t('wizard.addressSection')}
            </h4>

            <div className="form-row-3">
              <div className="form-group">
                <label className="form-label">{t('fields.zipCode')}</label>
                <input
                  type="text"
                  className="form-control"
                  placeholder="01310-100"
                  value={formData.dados_pessoais?.endereco?.cep || ''}
                  onChange={e => {
                    const end = { ...(formData.dados_pessoais?.endereco || {}), cep: e.target.value };
                    handleChange('dados_pessoais', 'endereco', end);
                  }}
                />
              </div>

              <div className="form-group" style={{ gridColumn: 'span 2' }}>
                <label className="form-label">{t('fields.street')}</label>
                <input
                  type="text"
                  className="form-control"
                  placeholder="Av. Paulista"
                  value={formData.dados_pessoais?.endereco?.rua || ''}
                  onChange={e => {
                    const end = { ...(formData.dados_pessoais?.endereco || {}), rua: e.target.value };
                    handleChange('dados_pessoais', 'endereco', end);
                  }}
                />
              </div>
            </div>

            <div className="form-row-3">
              <div className="form-group">
                <label className="form-label">{t('fields.number')}</label>
                <input
                  type="text"
                  className="form-control"
                  placeholder="1000"
                  value={formData.dados_pessoais?.endereco?.numero || ''}
                  onChange={e => {
                    const end = { ...(formData.dados_pessoais?.endereco || {}), numero: e.target.value };
                    handleChange('dados_pessoais', 'endereco', end);
                  }}
                />
              </div>

              <div className="form-group">
                <label className="form-label">{t('fields.city')}</label>
                <input
                  type="text"
                  className="form-control"
                  placeholder="São Paulo"
                  value={formData.dados_pessoais?.endereco?.cidade || ''}
                  onChange={e => {
                    const end = { ...(formData.dados_pessoais?.endereco || {}), cidade: e.target.value };
                    handleChange('dados_pessoais', 'endereco', end);
                  }}
                />
              </div>

              <div className="form-group">
                <label className="form-label">{t('fields.state')}</label>
                <input
                  type="text"
                  className="form-control"
                  placeholder="SP"
                  maxLength={2}
                  value={formData.dados_pessoais?.endereco?.estado || ''}
                  onChange={e => {
                    const end = { ...(formData.dados_pessoais?.endereco || {}), estado: e.target.value.toUpperCase() };
                    handleChange('dados_pessoais', 'endereco', end);
                  }}
                />
              </div>
            </div>
          </div>
        )}

      </div>

      {/* Barra Inferior com Navegação Anterior / Próximo */}
      <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginTop: 24, paddingTop: 16, borderTop: '1px solid var(--border-color)' }}>
        <button
          type="button"
          className="btn btn-secondary"
          onClick={() => setCurrentStepIdx(prev => Math.max(0, prev - 1))}
          disabled={currentStepIdx === 0}
        >
          <ChevronLeft size={16} /> {t('wizard.prevStep')}
        </button>

        <div style={{ fontSize: '0.85rem', color: 'var(--text-muted)' }}>
          {t('wizard.stepProgress', { current: currentStepIdx + 1, total: totalSteps })}
        </div>

        <button
          type="button"
          className="btn btn-primary"
          onClick={() => setCurrentStepIdx(prev => Math.min(totalSteps - 1, prev + 1))}
          disabled={currentStepIdx === totalSteps - 1}
        >
          {t('wizard.nextStep')} <ChevronRight size={16} />
        </button>
      </div>
    </div>
  );
}
