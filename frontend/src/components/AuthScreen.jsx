import React, { useState, useEffect } from 'react';
import { 
  BookOpen, 
  Mail, 
  Lock, 
  User, 
  ArrowRight, 
  CheckCircle, 
  Sun, 
  Moon, 
  Globe, 
  Sparkles,
  Shield,
  UserCheck
} from 'lucide-react';
import { useI18n } from '../i18n/I18nContext';
import { GoogleIcon } from './GoogleAuthModal';

export default function AuthScreen({ 
  onLoginSuccess, 
  theme, 
  toggleTheme 
}) {
  const { t, language, setLanguage, languages } = useI18n();
  const [authMode, setAuthMode] = useState('login'); // 'login' | 'register'
  
  // Estados do formulário de e-mail
  const [nome, setNome] = useState('');
  const [email, setEmail] = useState('');
  const [senha, setSenha] = useState('');
  const [confirmSenha, setConfirmSenha] = useState('');
  const [errorMsg, setErrorMsg] = useState('');
  
  // Estados para seleção/personalização de conta Google
  const [showGoogleAccounts, setShowGoogleAccounts] = useState(false);
  const [googleCustomName, setGoogleCustomName] = useState('');
  const [googleCustomEmail, setGoogleCustomEmail] = useState('');

  // Limpeza preventiva de contas de exemplo salvas anteriormente
  useEffect(() => {
    try {
      const storedGoogle = localStorage.getItem('curriculo_google_user');
      if (storedGoogle) {
        const parsed = JSON.parse(storedGoogle);
        if (parsed?.avatar?.includes('images.unsplash.com')) {
          localStorage.removeItem('curriculo_google_user');
          localStorage.removeItem('curriculo_auth_user');
        }
      }
    } catch (e) {}
  }, []);

  const handleGoogleLogin = (account) => {
    localStorage.setItem('curriculo_auth_user', JSON.stringify(account));
    localStorage.setItem('curriculo_google_user', JSON.stringify(account));
    onLoginSuccess(account);
  };

  const handleCustomGoogleSubmit = (e) => {
    e.preventDefault();
    if (!googleCustomName || !googleCustomEmail) {
      setErrorMsg('Preencha seu nome e e-mail Google.');
      return;
    }
    const account = {
      name: googleCustomName,
      email: googleCustomEmail,
      avatar: `https://ui-avatars.com/api/?name=${encodeURIComponent(googleCustomName)}&background=0f3a68&color=fff`,
      provider: 'google'
    };
    handleGoogleLogin(account);
  };

  const handleEmailAuthSubmit = (e) => {
    e.preventDefault();
    setErrorMsg('');

    if (!email || !senha) {
      setErrorMsg('Por favor, preencha todos os campos obrigatórios.');
      return;
    }

    if (authMode === 'register') {
      if (!nome) {
        setErrorMsg('Informe o seu nome completo para o currículo.');
        return;
      }
      if (senha.length < 4) {
        setErrorMsg('A senha deve ter pelo menos 4 caracteres.');
        return;
      }
      if (confirmSenha && senha !== confirmSenha) {
        setErrorMsg('As senhas digitadas não coincidem.');
        return;
      }

      const newUser = {
        name: nome,
        email: email,
        avatar: `https://ui-avatars.com/api/?name=${encodeURIComponent(nome)}&background=0f3a68&color=fff`,
        provider: 'email'
      };
      localStorage.setItem('curriculo_auth_user', JSON.stringify(newUser));
      onLoginSuccess(newUser);
    } else {
      // Modo Login por E-mail
      const loggedUser = {
        name: email.split('@')[0].replace('.', ' '),
        email: email,
        avatar: `https://ui-avatars.com/api/?name=${encodeURIComponent(email)}&background=0f3a68&color=fff`,
        provider: 'email'
      };
      localStorage.setItem('curriculo_auth_user', JSON.stringify(loggedUser));
      onLoginSuccess(loggedUser);
    }
  };

  const handleGuestLogin = () => {
    const guestUser = {
      name: 'Pesquisador Convidado',
      email: 'convidado@curiculo.online',
      avatar: 'https://ui-avatars.com/api/?name=Convidado&background=334155&color=fff',
      provider: 'guest'
    };
    localStorage.setItem('curriculo_auth_user', JSON.stringify(guestUser));
    onLoginSuccess(guestUser);
  };

  return (
    <div className="auth-screen-wrapper">
      {/* Barra Superior Discreta com Idioma e Tema */}
      <header className="auth-top-bar">
        <div className="auth-top-inner">
          <div className="auth-brand-badge">
            <BookOpen size={20} className="text-accent" />
            <span style={{ fontWeight: 700, fontSize: '0.95rem', color: 'var(--text-primary)' }}>
              Curriculo<span style={{ color: '#38bdf8' }}>.online</span>
            </span>
          </div>

          <div style={{ display: 'flex', alignItems: 'center', gap: 8 }}>
            {/* Seletor de Idioma */}
            <div style={{ position: 'relative', display: 'flex', alignItems: 'center' }}>
              <select
                className="form-select auth-lang-select"
                value={language}
                onChange={(e) => setLanguage(e.target.value)}
                style={{ padding: '4px 8px 4px 26px', fontSize: '0.78rem', height: 32 }}
                title="Selecione o idioma"
              >
                {languages.map(l => (
                  <option key={l.code} value={l.code}>{l.flag} {l.name}</option>
                ))}
              </select>
              <Globe size={13} style={{ position: 'absolute', left: 8, pointerEvents: 'none', color: 'var(--text-muted)' }} />
            </div>

            {/* Alternador de Tema */}
            <button
              type="button"
              className="btn btn-secondary btn-icon"
              style={{ width: 32, height: 32 }}
              onClick={toggleTheme}
              title={theme === 'dark' ? 'Modo Claro' : 'Modo Escuro'}
            >
              {theme === 'dark' ? <Sun size={15} /> : <Moon size={15} />}
            </button>
          </div>
        </div>
      </header>

      {/* Container Central com Card de Autenticação */}
      <main className="auth-main-container">
        <div className="auth-card">
          {/* Logo e Cabeçalho */}
          <div className="auth-header">
            <div className="auth-logo-circle">
              <BookOpen size={30} />
            </div>
            <h1 className="auth-title">
              {authMode === 'login' ? 'Bem-vindo de volta' : 'Crie sua Conta'}
            </h1>
            <p className="auth-subtitle">
              Modelos de Currículo Lattes & Acadêmicos CNPq em padrão A4 de alta qualidade.
            </p>
          </div>

          {/* Mensagem de Erro (se houver) */}
          {errorMsg && (
            <div className="auth-error-banner" role="alert">
              {errorMsg}
            </div>
          )}

          {/* 1. BOTÃO DE LOGIN COM GOOGLE */}
          <div className="auth-google-section">
            <button
              type="button"
              className="btn-google-auth"
              onClick={() => setShowGoogleAccounts(prev => !prev)}
            >
              <GoogleIcon size={20} />
              <span>Continuar com o Google</span>
            </button>

            {/* Gaveta de Login com Google */}
            {showGoogleAccounts && (
              <div className="google-accounts-picker">
                <form onSubmit={handleCustomGoogleSubmit}>
                  <div style={{ fontSize: '0.8rem', fontWeight: 600, color: 'var(--text-secondary)', marginBottom: 8 }}>
                    Informe sua conta Google:
                  </div>
                  <input
                    type="text"
                    className="form-control"
                    placeholder="Seu Nome Completo"
                    value={googleCustomName}
                    onChange={e => setGoogleCustomName(e.target.value)}
                    style={{ marginBottom: 8, fontSize: '0.85rem', padding: '8px 10px' }}
                    autoFocus
                  />
                  <input
                    type="email"
                    className="form-control"
                    placeholder="seu.email@gmail.com"
                    value={googleCustomEmail}
                    onChange={e => setGoogleCustomEmail(e.target.value)}
                    style={{ marginBottom: 10, fontSize: '0.85rem', padding: '8px 10px' }}
                  />
                  <button 
                    type="submit" 
                    className="btn btn-secondary" 
                    style={{ width: '100%', fontSize: '0.84rem', padding: '8px 12px', justifyContent: 'center' }}
                  >
                    <UserCheck size={16} /> Entrar com esta conta Google
                  </button>
                </form>
              </div>
            )}
          </div>

          {/* Divisor Visual */}
          <div className="auth-divider">
            <span>ou continue com e-mail</span>
          </div>

          {/* Abas Alternadoras: Entrar vs Cadastrar */}
          <div className="auth-tab-switch">
            <button
              type="button"
              className={`auth-switch-btn ${authMode === 'login' ? 'active' : ''}`}
              onClick={() => { setAuthMode('login'); setErrorMsg(''); }}
            >
              Entrar
            </button>
            <button
              type="button"
              className={`auth-switch-btn ${authMode === 'register' ? 'active' : ''}`}
              onClick={() => { setAuthMode('register'); setErrorMsg(''); }}
            >
              Cadastrar-se
            </button>
          </div>

          {/* Formulário de E-mail */}
          <form onSubmit={handleEmailAuthSubmit} className="auth-form">
            {authMode === 'register' && (
              <div className="form-group">
                <label className="form-label required">Nome Completo</label>
                <div className="input-with-icon">
                  <User size={16} className="input-icon" />
                  <input
                    type="text"
                    className="form-control with-icon"
                    placeholder="Digite seu nome completo"
                    value={nome}
                    onChange={e => setNome(e.target.value)}
                    required
                  />
                </div>
              </div>
            )}

            <div className="form-group">
              <label className="form-label required">E-mail</label>
              <div className="input-with-icon">
                <Mail size={16} className="input-icon" />
                <input
                  type="email"
                  className="form-control with-icon"
                  placeholder="seu.email@instituicao.br"
                  value={email}
                  onChange={e => setEmail(e.target.value)}
                  required
                />
              </div>
            </div>

            <div className="form-group">
              <label className="form-label required">Senha</label>
              <div className="input-with-icon">
                <Lock size={16} className="input-icon" />
                <input
                  type="password"
                  className="form-control with-icon"
                  placeholder="Sua senha secreta"
                  value={senha}
                  onChange={e => setSenha(e.target.value)}
                  required
                />
              </div>
            </div>

            {authMode === 'register' && (
              <div className="form-group">
                <label className="form-label required">Confirmar Senha</label>
                <div className="input-with-icon">
                  <Lock size={16} className="input-icon" />
                  <input
                    type="password"
                    className="form-control with-icon"
                    placeholder="Repita sua senha"
                    value={confirmSenha}
                    onChange={e => setConfirmSenha(e.target.value)}
                    required
                  />
                </div>
              </div>
            )}

            <button type="submit" className="btn btn-primary auth-submit-btn">
              <span>{authMode === 'login' ? 'Entrar no Sistema' : 'Criar Conta e Começar'}</span>
              <ArrowRight size={16} />
            </button>
          </form>

          {/* Rodapé do Card com Acesso de Convidado */}
          <div className="auth-card-footer">
            <button
              type="button"
              className="btn-guest-link"
              onClick={handleGuestLogin}
              title="Acessar diretamente sem criar conta"
            >
              Deseja apenas testar? <strong>Continuar como Convidado</strong>
            </button>
          </div>
        </div>

        {/* Garantias e Segurança Acadêmica */}
        <div className="auth-features-bar">
          <div className="auth-feature-item">
            <Shield size={16} className="text-accent" />
            <span>Dados preservados localmente com segurança</span>
          </div>
          <div className="auth-feature-item">
            <CheckCircle size={16} className="text-success" />
            <span>Compatível com padrões CNPq / Lattes</span>
          </div>
        </div>
      </main>
    </div>
  );
}
