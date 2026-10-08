import { DEFAULT_STEPS } from '../data/defaultSteps';
import { RESUME_MODELS } from '../data/modelsData';
import { SAMPLE_RESUME_DATA } from '../data/sampleResumeData';

const API_BASE = '/api';

export const apiService = {
  // --- ETAPAS ---
  async getEtapas() {
    try {
      const res = await fetch(`${API_BASE}/etapas`);
      if (res.ok) {
        const json = await res.json();
        if (json.success && Array.isArray(json.data) && json.data.length > 0) {
          localStorage.setItem('curriculo_etapas_cache', JSON.stringify(json.data));
          return json.data;
        }
      }
    } catch (e) {
      console.warn('API PHP offline ou inacessível, usando cache local:', e);
    }
    const cached = localStorage.getItem('curriculo_etapas_cache');
    return cached ? JSON.parse(cached) : DEFAULT_STEPS;
  },

  async saveEtapa(etapa) {
    try {
      const url = etapa.id ? `${API_BASE}/etapas/${etapa.id}` : `${API_BASE}/etapas`;
      const method = etapa.id ? 'PUT' : 'POST';
      const res = await fetch(url, {
        method,
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(etapa)
      });
      if (res.ok) {
        const json = await res.json();
        return json.data;
      }
    } catch (e) {
      console.warn('Erro na requisição para salvar etapa no backend:', e);
    }
    // Fallback local
    const cached = await this.getEtapas();
    let updated;
    if (etapa.id) {
      updated = cached.map(e => e.id === etapa.id ? { ...e, ...etapa } : e);
    } else {
      const newId = Math.max(0, ...cached.map(e => e.id || 0)) + 1;
      updated = [...cached, { ...etapa, id: newId, ordem: cached.length + 1 }];
    }
    localStorage.setItem('curriculo_etapas_cache', JSON.stringify(updated));
    return etapa;
  },

  async deleteEtapa(id) {
    try {
      const res = await fetch(`${API_BASE}/etapas/${id}`, { method: 'DELETE' });
      if (res.ok) return true;
    } catch (e) {
      console.warn('Erro ao deletar etapa na API PHP:', e);
    }
    const cached = await this.getEtapas();
    const updated = cached.filter(e => e.id !== id);
    localStorage.setItem('curriculo_etapas_cache', JSON.stringify(updated));
    return true;
  },

  async reorderEtapas(orderedIds) {
    try {
      const res = await fetch(`${API_BASE}/etapas/reorder`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ ordered_ids: orderedIds })
      });
      if (res.ok) {
        const json = await res.json();
        return json.data;
      }
    } catch (e) {
      console.warn('Erro ao reordenar etapas na API PHP:', e);
    }
    const cached = await this.getEtapas();
    const map = new Map(cached.map(e => [e.id, e]));
    const reordered = orderedIds.map((id, index) => {
      const item = map.get(id);
      return item ? { ...item, ordem: index + 1 } : null;
    }).filter(Boolean);
    localStorage.setItem('curriculo_etapas_cache', JSON.stringify(reordered));
    return reordered;
  },

  // --- MODELOS ---
  async getModelos() {
    try {
      const res = await fetch(`${API_BASE}/modelos`);
      if (res.ok) {
        const json = await res.json();
        if (json.success && Array.isArray(json.data) && json.data.length > 0) {
          return json.data;
        }
      }
    } catch (e) {
      console.warn('API de modelos offline, usando modelos padrão:', e);
    }
    return RESUME_MODELS;
  },

  // --- CURRICULOS ---
  async saveCurriculo(curriculoData) {
    try {
      const res = await fetch(`${API_BASE}/curriculos`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(curriculoData)
      });
      if (res.ok) {
        const json = await res.json();
        return json.data;
      }
    } catch (e) {
      console.warn('Erro ao salvar currículo no servidor PHP, salvando no localStorage:', e);
    }
    localStorage.setItem('curriculo_saved_data', JSON.stringify(curriculoData));
    return curriculoData;
  },

  async getCurriculoSalvo() {
    const saved = localStorage.getItem('curriculo_saved_data');
    if (saved) {
      try { return JSON.parse(saved); } catch (e) {}
    }
    return null;
  },

  // --- GERADOR RESUMO LATTES (CNPq) ---
  async gerarResumoLattes(dados) {
    try {
      const res = await fetch(`${API_BASE}/gerar-lattes-resumo`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ dados })
      });
      if (res.ok) {
        const json = await res.json();
        if (json.success && json.resumo) return json.resumo;
      }
    } catch (e) {
      console.warn('Erro ao gerar resumo no backend, gerando no cliente:', e);
    }
    // Gerador client-side fallback
    const formacoes = dados.formacao_academica || [];
    const f0 = formacoes[0];
    let resumo = '';
    if (f0 && f0.curso) {
      resumo += `Possui formação em ${f0.curso} pela ${f0.instituicao || 'Instituição de Ensino Superior'}`;
      if (f0.ano_conclusao) resumo += ` (${f0.ano_conclusao}). `;
      else resumo += '. ';
    }
    const atuacoes = dados.atuacao_profissional || [];
    if (atuacoes[0] && atuacoes[0].empresa) {
      resumo += `Atua profissionalmente como ${atuacoes[0].cargo || 'pesquisador(a)'} em ${atuacoes[0].empresa}. `;
    }
    const linhas = dados.linhas_pesquisa || [];
    if (linhas.length > 0) {
      const nomes = linhas.map(l => l.nome || l).filter(Boolean).join(', ');
      resumo += `Desenvolve estudos e pesquisas nas áreas de ${nomes}, com ênfase em inovação e publicações científicas.`;
    }
    return resumo || 'Pesquisador com experiência acadêmica e técnica.';
  }
};
