import React, { createContext, useContext, useState, useEffect } from 'react';
import { TRANSLATIONS } from './translations';

export const LANGUAGES = [
  { code: 'pt', name: 'Português', flag: '🇧🇷' },
  { code: 'en', name: 'English', flag: '🇺🇸' },
  { code: 'es', name: 'Español', flag: '🇪🇸' },
  { code: 'it', name: 'Italiano', flag: '🇮🇹' }
];

const I18nContext = createContext(null);

function detectBrowserLanguage() {
  // 1. Verificar preferência salva manualmente no localStorage
  const saved = localStorage.getItem('curriculo_lang');
  if (saved && ['pt', 'en', 'es', 'it'].includes(saved)) {
    return saved;
  }

  // 2. Detecção automática através do navegador (navigator.languages ou navigator.language)
  const browserLangs = navigator.languages || [navigator.language || navigator.userLanguage || 'pt'];
  for (const bLang of browserLangs) {
    if (!bLang) continue;
    const lower = bLang.toLowerCase();
    if (lower.startsWith('pt')) return 'pt';
    if (lower.startsWith('en')) return 'en';
    if (lower.startsWith('es')) return 'es';
    if (lower.startsWith('it')) return 'it';
  }

  // 3. Padrão caso não corresponda a nenhum dos 4
  return 'pt';
}

export function I18nProvider({ children }) {
  const [language, setLanguageState] = useState(() => detectBrowserLanguage());

  const setLanguage = (langCode) => {
    if (['pt', 'en', 'es', 'it'].includes(langCode)) {
      setLanguageState(langCode);
      localStorage.setItem('curriculo_lang', langCode);
      document.documentElement.lang = langCode;
    }
  };

  useEffect(() => {
    document.documentElement.lang = language;
  }, [language]);

  // Função helper de tradução com suporte a interpolação: t('wizard.stepOf', { current: 1, total: 10 })
  const t = (path, params = {}) => {
    const keys = path.split('.');
    let current = TRANSLATIONS[language] || TRANSLATIONS.en;

    for (const key of keys) {
      if (current && current[key] !== undefined) {
        current = current[key];
      } else {
        // Fallback para inglês se não encontrar no idioma atual
        let fallback = TRANSLATIONS.en;
        for (const fbKey of keys) {
          if (fallback && fallback[fbKey] !== undefined) {
            fallback = fallback[fbKey];
          } else {
            return path; // Retorna a própria chave se não existir
          }
        }
        current = fallback;
        break;
      }
    }

    if (typeof current === 'string') {
      let result = current;
      Object.keys(params).forEach(pKey => {
        result = result.replace(new RegExp(`\\{${pKey}\\}`, 'g'), params[pKey]);
      });
      return result;
    }

    return current;
  };

  return (
    <I18nContext.Provider value={{ language, setLanguage, t, languages: LANGUAGES }}>
      {children}
    </I18nContext.Provider>
  );
}

export function useI18n() {
  const context = useContext(I18nContext);
  if (!context) {
    throw new Error('useI18n must be used within an I18nProvider');
  }
  return context;
}
