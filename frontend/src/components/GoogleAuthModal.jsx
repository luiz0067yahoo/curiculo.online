import React, { useState } from 'react';
import { X, LogIn, ShieldCheck } from 'lucide-react';
import { apiService } from '../services/api';

export function GoogleIcon({ size = 18 }) {
  return (
    <svg width={size} height={size} viewBox="0 0 24 24" fill="none">
      <path
        d="M23.745 12.27c0-.7-.06-1.4-.19-2.07H12v4.51h6.6c-.29 1.52-1.14 2.82-2.4 3.68v3.05h3.88c2.27-2.09 3.665-5.17 3.665-9.17z"
        fill="#4285F4"
      />
      <path
        d="M12 24c3.24 0 5.95-1.08 7.93-2.91l-3.88-3.05c-1.08.72-2.45 1.16-4.05 1.16-3.12 0-5.77-2.1-6.72-4.93H1.25v3.15C3.26 21.36 7.34 24 12 24z"
        fill="#34A853"
      />
      <path
        d="M5.28 14.27c-.25-.72-.38-1.49-.38-2.27s.13-1.55.38-2.27V6.58H1.25C.45 8.18 0 10.04 0 12s.45 3.82 1.25 5.42l4.03-3.15z"
        fill="#FBBC05"
      />
      <path
        d="M12 4.75c1.77 0 3.35.61 4.6 1.8l3.42-3.42C17.95 1.19 15.24 0 12 0 7.34 0 3.26 2.64 1.25 6.58l4.03 3.15c.95-2.83 3.6-4.98 6.72-4.98z"
        fill="#EA4335"
      />
    </svg>
  );
}

export default function GoogleAuthModal({
  isOpen,
  onClose,
  onLoginSuccess
}) {
  const [customName, setCustomName] = useState('');
  const [customEmail, setCustomEmail] = useState('');
  const [customPassword, setCustomPassword] = useState('');
  const [errorMsg, setErrorMsg] = useState('');
  const [isLoading, setIsLoading] = useState(false);

  if (!isOpen) return null;

  const handleCustomSubmit = async (e) => {
    e.preventDefault();
    setErrorMsg('');
    if (!customEmail || !customPassword) {
      setErrorMsg('Informe o e-mail Google e a senha.');
      return;
    }

    setIsLoading(true);
    try {
      const res = await apiService.googleAuth({
        name: customName,
        email: customEmail,
        password: customPassword
      });
      localStorage.setItem('curriculo_google_user', JSON.stringify(res.user));
      localStorage.setItem('curriculo_auth_user', JSON.stringify(res.user));
      onLoginSuccess(res.user, res.curriculo);
      onClose();
    } catch (err) {
      setErrorMsg(err.message || 'Erro ao autenticar com o Google.');
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <div className="modal-backdrop" onClick={onClose}>
      <div 
        className="modal-content" 
        style={{ maxWidth: 440, padding: '24px', borderRadius: 'var(--radius-lg)' }}
        onClick={(e) => e.stopPropagation()}
      >
        {/* Header Google */}
        <div style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', marginBottom: 16 }}>
          <div style={{ display: 'flex', alignItems: 'center', gap: 10 }}>
            <div style={{ background: '#f8fafc', padding: 8, borderRadius: '50%', boxShadow: '0 2px 6px rgba(0,0,0,0.08)' }}>
              <GoogleIcon size={24} />
            </div>
            <div>
              <h3 style={{ margin: 0, fontSize: '1.05rem', fontWeight: 700, color: 'var(--text-primary)' }}>
                Fazer login com o Google
              </h3>
              <p style={{ margin: 0, fontSize: '0.8rem', color: 'var(--text-muted)' }}>
                para continuar em Curriculo.online
              </p>
            </div>
          </div>
          <button 
            type="button" 
            className="btn btn-secondary btn-icon" 
            style={{ width: 32, height: 32 }}
            onClick={onClose}
          >
            <X size={16} />
          </button>
        </div>

        {errorMsg && (
          <div className="auth-error-banner" role="alert" style={{ marginBottom: 12 }}>
            {errorMsg}
          </div>
        )}

        {/* Informações de Privacidade e Segurança */}
        <div style={{ 
          background: 'var(--bg-tertiary)', 
          padding: '10px 14px', 
          borderRadius: 'var(--radius-md)', 
          display: 'flex', 
          alignItems: 'center', 
          gap: 10,
          marginBottom: 18,
          fontSize: '0.8rem',
          color: 'var(--text-secondary)'
        }}>
          <ShieldCheck size={18} style={{ color: '#10b981', flexShrink: 0 }} />
          <span>Acesso seguro sincronizado com o servidor.</span>
        </div>

        {/* Formulário de Conta Google com Senha */}
        <form onSubmit={handleCustomSubmit}>
          <div className="form-group">
            <label className="form-label">Nome Completo</label>
            <input
              type="text"
              className="form-control"
              placeholder="Seu Nome Completo"
              value={customName}
              onChange={(e) => setCustomName(e.target.value)}
            />
          </div>

          <div className="form-group">
            <label className="form-label required">E-mail do Google (Gmail)</label>
            <input
              type="email"
              className="form-control"
              placeholder="seuemail@gmail.com"
              value={customEmail}
              onChange={(e) => setCustomEmail(e.target.value)}
              required
              autoFocus
            />
          </div>

          <div className="form-group">
            <label className="form-label required">Senha de Acesso</label>
            <input
              type="password"
              className="form-control"
              placeholder="Crie ou digite sua senha (mín. 4 caracteres)"
              value={customPassword}
              onChange={(e) => setCustomPassword(e.target.value)}
              required
            />
          </div>

          <div style={{ display: 'flex', gap: 10, marginTop: 18 }}>
            <button
              type="button"
              className="btn btn-secondary"
              style={{ flex: 1 }}
              onClick={onClose}
            >
              Cancelar
            </button>
            <button
              type="submit"
              className="btn btn-primary"
              disabled={isLoading}
              style={{ flex: 1 }}
            >
              <LogIn size={15} /> {isLoading ? 'Autenticando...' : 'Entrar com Google'}
            </button>
          </div>
        </form>
      </div>
    </div>
  );
}
