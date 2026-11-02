import React, { createContext, useContext, useState, useCallback, useEffect } from 'react';
import { AlertTriangle, CheckCircle, HelpCircle, Info, X } from 'lucide-react';

const DialogContext = createContext(null);

export function DialogProvider({ children }) {
  const [modalState, setModalState] = useState(null);
  const [promptValue, setPromptValue] = useState('');

  const closeModal = useCallback((result) => {
    setModalState((prev) => {
      if (prev?.resolve) {
        prev.resolve(result);
      }
      return null;
    });
    setPromptValue('');
  }, []);

  const showAlert = useCallback((options) => {
    const config = typeof options === 'string' ? { message: options } : (options || {});
    return new Promise((resolve) => {
      setModalState({
        type: 'alert',
        title: config.title || 'Aviso do Sistema',
        message: config.message || '',
        confirmText: config.confirmText || 'OK',
        variant: config.variant || 'info',
        resolve
      });
    });
  }, []);

  const showConfirm = useCallback((options) => {
    const config = typeof options === 'string' ? { message: options } : (options || {});
    return new Promise((resolve) => {
      setModalState({
        type: 'confirm',
        title: config.title || 'Confirmação',
        message: config.message || '',
        confirmText: config.confirmText || 'Confirmar',
        cancelText: config.cancelText || 'Cancelar',
        variant: config.variant || 'warning',
        resolve
      });
    });
  }, []);

  const showPrompt = useCallback((options) => {
    const config = typeof options === 'string' ? { message: options } : (options || {});
    setPromptValue(config.defaultValue || '');
    return new Promise((resolve) => {
      setModalState({
        type: 'prompt',
        title: config.title || 'Preencha a informação',
        message: config.message || '',
        placeholder: config.placeholder || 'Digite aqui...',
        confirmText: config.confirmText || 'Confirmar',
        cancelText: config.cancelText || 'Cancelar',
        variant: config.variant || 'info',
        resolve
      });
    });
  }, []);

  // Sobrescrever window.alert para sempre exibir o modal em div
  useEffect(() => {
    const originalAlert = window.alert;
    window.alert = (msg) => {
      showAlert({ title: 'Aviso', message: String(msg) });
    };
    return () => {
      window.alert = originalAlert;
    };
  }, [showAlert]);

  const renderIcon = () => {
    if (!modalState) return null;
    if (modalState.variant === 'danger' || modalState.variant === 'warning') {
      return <AlertTriangle size={22} style={{ color: '#ef4444' }} />;
    }
    if (modalState.variant === 'success') {
      return <CheckCircle size={22} style={{ color: '#10b981' }} />;
    }
    if (modalState.type === 'confirm' || modalState.type === 'prompt') {
      return <HelpCircle size={22} style={{ color: 'var(--accent)' }} />;
    }
    return <Info size={22} style={{ color: 'var(--accent)' }} />;
  };

  return (
    <DialogContext.Provider value={{ showAlert, showConfirm, showPrompt }}>
      {children}

      {modalState && (
        <div
          className="modal-backdrop"
          onClick={() => closeModal(modalState.type === 'confirm' ? false : null)}
          role="dialog"
          aria-modal="true"
        >
          <div
            className="modal-content"
            style={{
              maxWidth: 440,
              width: '100%',
              padding: '24px',
              borderRadius: 'var(--radius-lg)',
              background: 'var(--bg-secondary)',
              border: '1px solid var(--border-color)',
              boxShadow: 'var(--shadow-xl)',
              animation: 'fadeIn 0.2s ease'
            }}
            onClick={(e) => e.stopPropagation()}
          >
            {/* Cabeçalho do Modal */}
            <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 14 }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: 10 }}>
                <div
                  style={{
                    width: 38,
                    height: 38,
                    borderRadius: '50%',
                    background: modalState.variant === 'danger' || modalState.variant === 'warning'
                      ? 'rgba(239, 68, 68, 0.12)'
                      : 'var(--bg-tertiary)',
                    display: 'flex',
                    alignItems: 'center',
                    justifyContent: 'center',
                    flexShrink: 0
                  }}
                >
                  {renderIcon()}
                </div>
                <h3 style={{ margin: 0, fontSize: '1.05rem', fontWeight: 700, color: 'var(--text-primary)' }}>
                  {modalState.title}
                </h3>
              </div>

              <button
                type="button"
                className="btn btn-secondary btn-icon"
                style={{ width: 30, height: 30 }}
                onClick={() => closeModal(modalState.type === 'confirm' ? false : null)}
                title="Fechar"
              >
                <X size={15} />
              </button>
            </div>

            {/* Corpo da Mensagem */}
            {modalState.message && (
              <div
                style={{
                  fontSize: '0.9rem',
                  color: 'var(--text-secondary)',
                  lineHeight: 1.55,
                  marginBottom: modalState.type === 'prompt' ? 14 : 20
                }}
              >
                {modalState.message}
              </div>
            )}

            {/* Campo de Input para modo Prompt */}
            {modalState.type === 'prompt' && (
              <form
                onSubmit={(e) => {
                  e.preventDefault();
                  closeModal(promptValue);
                }}
              >
                <input
                  type="text"
                  className="form-control"
                  placeholder={modalState.placeholder}
                  value={promptValue}
                  onChange={(e) => setPromptValue(e.target.value)}
                  style={{ marginBottom: 18 }}
                  autoFocus
                />
                <div style={{ display: 'flex', justifyContent: 'flex-end', gap: 10 }}>
                  <button
                    type="button"
                    className="btn btn-secondary"
                    onClick={() => closeModal(null)}
                  >
                    {modalState.cancelText}
                  </button>
                  <button type="submit" className="btn btn-primary">
                    {modalState.confirmText}
                  </button>
                </div>
              </form>
            )}

            {/* Botões de Ação para Alert e Confirm */}
            {modalState.type !== 'prompt' && (
              <div style={{ display: 'flex', justifyContent: 'flex-end', gap: 10 }}>
                {modalState.type === 'confirm' && (
                  <button
                    type="button"
                    className="btn btn-secondary"
                    onClick={() => closeModal(false)}
                  >
                    {modalState.cancelText}
                  </button>
                )}
                <button
                  type="button"
                  className="btn btn-primary"
                  style={
                    modalState.variant === 'danger' || modalState.variant === 'warning'
                      ? { background: '#dc2626', borderColor: '#dc2626', color: '#fff' }
                      : {}
                  }
                  onClick={() => closeModal(true)}
                  autoFocus
                >
                  {modalState.confirmText}
                </button>
              </div>
            )}
          </div>
        </div>
      )}
    </DialogContext.Provider>
  );
}

export function useDialog() {
  const ctx = useContext(DialogContext);
  if (!ctx) {
    return {
      showAlert: async (opts) => window.alert(typeof opts === 'string' ? opts : opts?.message),
      showConfirm: async () => true,
      showPrompt: async () => null
    };
  }
  return ctx;
}

