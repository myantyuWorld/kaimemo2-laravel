<template>
  <v-container>
    <v-card>
      <v-card-title>
        <v-icon class="mr-2">mdi-account-group</v-icon>
        ユーザー管理
      </v-card-title>
      <v-card-text>
        <v-btn color="primary" class="mb-4" @click="addNewMember">
          <v-icon class="mr-2">mdi-plus</v-icon>
          新しいメンバーを追加
        </v-btn>
        <v-data-table :headers="userHeaders" :items="familyMembers" :items-per-page="10">
          <template v-slot:[`item.role`]="{ item }">
            <v-chip :color="item.role === '管理者' ? 'primary' : 'secondary'">
              {{ item.role }}
            </v-chip>
          </template>
          <template v-slot:[`item.actions`]="{ item }">
            <v-btn icon size="small" color="primary" @click="editUser(item.id)">
              <v-icon>mdi-pencil</v-icon>
            </v-btn>
            <v-btn
              icon
              size="small"
              color="error"
              v-if="item.role !== '管理者'"
              @click="deleteUser(item.id)"
            >
              <v-icon>mdi-delete</v-icon>
            </v-btn>
          </template>
        </v-data-table>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script setup lang="ts">
import { ref } from 'vue'

interface User {
  id: number
  name: string
  email: string
  role: string
}

const familyMembers = ref<User[]>([
  { id: 1, name: '田中太郎', email: 'taro@example.com', role: '管理者' },
  { id: 2, name: '田中花子', email: 'hanako@example.com', role: 'メンバー' },
  { id: 3, name: '田中次郎', email: 'jiro@example.com', role: 'メンバー' },
])

const userHeaders = ref([
  { title: '名前', key: 'name' },
  { title: 'メールアドレス', key: 'email' },
  { title: '権限', key: 'role' },
  { title: '操作', key: 'actions', sortable: false },
])

const addNewMember = () => {
  alert('新しいメンバーを追加する機能は実装中です')
}

const editUser = (id: number) => {
  alert(`ユーザー ID: ${id} を編集する機能は実装中です`)
}

const deleteUser = (id: number) => {
  const index = familyMembers.value.findIndex((user) => user.id === id)
  if (index > -1) {
    familyMembers.value.splice(index, 1)
  }
}
</script>
