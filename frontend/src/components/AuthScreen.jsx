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
  Shield,
  UserCheck,
  Loader2
} from 'lucide-react';
import { useI18n } from '../i18n/I18nContext';
import { GoogleIcon } from './GoogleAuthModal';
import { apiService } from '../services/api';

export default function AuthScreen({ 
  onLoginSuccess, 
  theme, 
  toggleTheme 
}) {
  const { language, setLanguage, languages } = useI18n();
  const [authMode, setAuthMode] = useState('login'); // 'login' | 'register'
  
  // Estados do formulário de e-mail e senha
  const [nome, setNome] = useState('');
  const [email, setEmail] = useState('');
  const [senha, setSenha] = useState('');
  const [confirmSenha, setConfirmSenha] = useState('');
  const [errorMsg, setErrorMsg] = useState('');
  const [isLoading, setIsLoading] = useState(false);
  
  // Estados para login / cadastro com conta Google integrada ao backend
  const [showGoogleAccounts, setShowGoogleAccounts] = useState(false);
  const [googleCustomName, setGoogleCustomName] = useState('');
  const [googleCustomEmail, setGoogleCustomEmail] = useState('');
  const [googleCustomPassword, setGoogleCustomPassword] = useState('');

  // Limpeza preventiva de contas de exemplo antigas
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

  const persistAndContinue = (user, curriculo = null) => {
    localStorage.setItem('curriculo_auth_user', JSON.stringify(user));
    if (user.provider === 'google') {
      localStorage.setItem('curriculo_google_user', JSON.stringify(user));
    }
    onLoginSuccess(user, curriculo);
  };

  const handleCustomGoogleSubmit = async (e) => {
    e.preventDefault();
    setErrorMsg('');

    if (!googleCustomEmail || !googleCustomPassword) {
      setErrorMsg('Informe o e-mail da sua conta Google e a senha de acesso.');
      return;
    }
    if (googleCustomPassword.length < 4) {
      setErrorMsg('A senha deve ter pelo menos 4 caracteres.');
      return;
    }

    setIsLoading(true);
    try {
      const res = await apiService.googleAuth({
        name: googleCustomName,
        email: googleCustomEmail,
        password: googleCustomPassword
      });
      persistAndContinue(res.user, res.curriculo);
    } catch (err) {
      setErrorMsg(err.message || 'Erro ao autenticar com a conta Google no servidor.');
    } finally {
      setIsLoading(false);
    }
  };

  const handleEmailAuthSubmit = async (e) => {
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
      }
      if (confirmSenha && senha !== confirmSenha) {
        setErrorMsg('As senhas digitadas não coincidem.');
        return;
      }

      setIsLoading(true);
      try {
        const res = await apiService.register({
          name: nome,
          email: email,
          password: senha
        });
        persistAndContinue(res.user, res.curriculo);
      } catch (err) {
        setErrorMsg(err.message || 'Não foi possível criar a conta.');
      } finally {
        setIsLoading(false);
      }
    } else {
      // Modo Login por E-mail e Senha no Backend
      setIsLoading(true);
      try {
        const res = await apiService.login({
          email: email,
          password: senha
        });
        persistAndContinue(res.user, res.curriculo);
      } catch (err) {
        setErrorMsg(err.message || 'E-mail ou senha incorretos.');
      } finally {
        setIsLoading(false);
      }
    }
  };

  const handleGuestLogin = () => {
    const guestUser = {
      name: 'Profissional Convidado',
      email: 'convidado@curiculo.online',
      avatar: 'https://ui-avatars.com/api/?name=Profissional&background=334155&color=fff',
      provider: 'guest'
    };
    localStorage.setItem('curriculo_auth_user', JSON.stringify(guestUser));
    onLoginSuccess(guestUser, null);
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
              Modelos de Currículo Lattes & Acadêmicos CNPq sincronizados com o servidor.
            </p>
          </div>

          {/* Mensagem de Erro (se houver) */}
          {errorMsg && (
            <div className="auth-error-banner" role="alert">
              {errorMsg}
            </div>
          )}

          {/* 1. BOTÃO DE LOGIN E SENHA COM CONTA GOOGLE */}
          <div className="auth-google-section">
            <button
              type="button"
              className="btn-google-auth"
              onClick={() => {
                setShowGoogleAccounts(prev => !prev);
                setErrorMsg('');
              }}
            >
              <GoogleIcon size={20} />
              <span>Entrar ou Criar Senha com Google</span>
            </button>

            {/* Gaveta de Login e Senha com Conta Google (Integrada ao Backend) */}
            {showGoogleAccounts && (
              <div className="google-accounts-picker">
                <form onSubmit={handleCustomGoogleSubmit}>
                  <div style={{ fontSize: '0.8rem', fontWeight: 600, color: 'var(--text-secondary)', marginBottom: 8 }}>
                    Acesse ou crie seu login e senha com sua conta Google:
                  </div>
                  <div className="input-with-icon" style={{ marginBottom: 8 }}>
                    <User size={15} className="input-icon" />
                    <input
                      type="text"
                      className="form-control with-icon"
                      placeholder="Seu Nome Completo (para novos cadastros)"
                      value={googleCustomName}
                      onChange={e => setGoogleCustomName(e.target.value)}
                      style={{ fontSize: '0.84rem', padding: '8px 10px 8px 34px' }}
                    />
                  </div>
                  <div className="input-with-icon" style={{ marginBottom: 8 }}>
                    <Mail size={15} className="input-icon" />
                    <input
                      type="email"
                      className="form-control with-icon"
                      placeholder="seu.email@gmail.com"
                      value={googleCustomEmail}
                      onChange={e => setGoogleCustomEmail(e.target.value)}
                      style={{ fontSize: '0.84rem', padding: '8px 10px 8px 34px' }}
                      required
                      autoFocus
                    />
                  </div>
                  <div className="input-with-icon" style={{ marginBottom: 10 }}>
                    <Lock size={15} className="input-icon" />
                    <input
                      type="password"
                      className="form-control with-icon"
                      placeholder="Crie ou digite sua senha (mín. 4 caracteres)"
                      value={googleCustomPassword}
                      onChange={e => setGoogleCustomPassword(e.target.value)}
                      style={{ fontSize: '0.84rem', padding: '8px 10px 8px 34px' }}
                      required
                    />
                  </div>
                  <button 
                    type="submit" 
                    className="btn btn-primary" 
                    disabled={isLoading}
                    style={{ width: '100%', fontSize: '0.84rem', padding: '9px 12px', justifyContent: 'center' }}
                  >
                    {isLoading ? <Loader2 size={16} /> : <UserCheck size={16} />}
                    <span>{isLoading ? 'Autenticando...' : 'Autenticar Conta Google'}</span>
                  </button>
                </form>
              </div>
            )}
          </div>

          {/* Divisor Visual */}
          <div className="auth-divider">
            <span>ou use login e senha direto</span>
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

          {/* Formulário de E-mail e Senha Integrado ao Backend */}
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
              <label className="form-label required">E-mail (Login)</label>
              <div className="input-with-icon">
                <Mail size={16} className="input-icon" />
                <input
                  type="email"
                  className="form-control with-icon"
                  placeholder="seu.email@gmail.com"
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
                  placeholder="Sua senha secreta (mín. 4 caracteres)"
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

            <button type="submit" className="btn btn-primary auth-submit-btn" disabled={isLoading}>
              <span>
                {isLoading 
                  ? 'Processando no servidor...' 
                  : (authMode === 'login' ? 'Entrar no Sistema' : 'Criar Conta e Começar')}
              </span>
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
            <span>Autenticação criptografada integrada ao Backend PHP</span>
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
