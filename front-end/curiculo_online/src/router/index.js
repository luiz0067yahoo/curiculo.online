import { createRouter, createWebHistory } from 'vue-router'
//import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/adm',
      name: 'adm',
      component: () => import('../views/admView.vue')
    },
    {
      path: '/login',
      name: 'login',
      component: () => import('../views/loginView.vue')
    },
    {
      path: '/logout',
      name: 'logout',
      component: () => import('../views/logoutView.vue')
    },
    {
      path: '/',
      name: 'HomeView',
      //component: HomeView
      component: () => import('../views/HomeView.vue')
    },
    {
      path: '/cadastro_usuarios',
      name: 'FormUserView',
      component: () => import('../views/FormUserView.vue')
    },
    {
      path: '/cadastro_estados',
      name: 'FormStateView',
      component: () => import('../views/FormStateView.vue')
    },
    {
      path: '/formacao_academica',
      name: 'FormAcademyTrainingView',
      component: () => import('../views/FormAcademyTrainingView.vue')
    },
    {
      path: '/conhecimentos',
      name: 'FormknowledgeView',
      component: () => import('../views/FormknowledgeView.vue')
    },
    {
      path: '/cargo_pretendido',
      name: 'FormIntendedPositionView',
      component: () => import('../views/FormIntendedPositionView.vue')
    },
    {
      path: '/dados_pessoais',
      name: 'FormPersonalDataView',
      component: () => import('../views/FormPersonalDataView.vue')
    },
    {
      path: '/experiencia_profissional',
      name: 'FormProfessionalExperienceView',
      component: () => import('../views/FormProfessionalExperienceView.vue')
    },
    {
      path: '/novo_usuario',
      name: 'FormNewUserView',
      component: () => import('../views/FormNewUserView.vue')
    },
    {
      path: '/dados_basicos',
      name: 'FormBasicDataView',
      component: () => import('../views/FormBasicDataView.vue')
    },
    {
      path: '/vagas',
      name: 'FormJobVacanciesView',
      component: () => import('../views/FormJobVacanciesView.vue')
    },
    {
      path: '/suas_vagas',
      name: 'FormYourJobVacanciesView',
      component: () => import('../views/FormYourJobVacanciesView.vue')
    },
    {
      path: '/print_curriculum',
      name: 'printCurriculumView',
      component: () => import('../views/printCurriculumView.vue')
    },
    {
      path: '/curriculum',
      name: 'curriculum',
      component: () => import('../views/curriculumView.vue')
    },
  ]
})

export default router
