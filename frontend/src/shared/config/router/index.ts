import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'login',
      component: () => import('@pages/LoginView.vue'),
    },
    {
      path: '/dashboard',
      name: 'dashboard',
      component: () => import('@pages/DashboardView.vue'),
    },
    {
      path: '/expense-input',
      name: 'expense-input',
      component: () => import('@pages/ExpenseInputView.vue'),
    },
    {
      path: '/expense-list',
      name: 'expense-list',
      component: () => import('@pages/ExpenseListView.vue'),
    },
    {
      path: '/budget-management',
      name: 'budget-management',
      component: () => import('@pages/BudgetManagementView.vue'),
    },
    {
      path: '/shopping-memo',
      name: 'shopping-memo',
      component: () => import('@pages/ShoppingMemoView.vue'),
    },
    {
      path: '/statistics',
      name: 'statistics',
      component: () => import('@pages/StatisticsView.vue'),
    },
    {
      path: '/user-management',
      name: 'user-management',
      component: () => import('@pages/UserManagementView.vue'),
    },
  ],
})

export default router
