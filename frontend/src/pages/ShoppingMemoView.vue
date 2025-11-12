<template>
  <v-container>
    <v-card>
      <v-card-title>
        <v-icon class="mr-2">mdi-cart</v-icon>
        買い物メモ
      </v-card-title>
      <v-card-text>
        <v-row class="mb-4">
          <v-col cols="12" md="8">
            <v-text-field
              v-model="newShoppingItem"
              label="アイテムを追加"
              @keyup.enter="addShoppingItem"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="4">
            <v-btn color="primary" @click="addShoppingItem">
              <v-icon class="mr-2">mdi-plus</v-icon>
              追加
            </v-btn>
          </v-col>
        </v-row>
        <v-list>
          <v-list-item v-for="item in shoppingList" :key="item.id">
            <v-list-item-content>
              <v-list-item-title :class="{ 'text-decoration-line-through': item.completed }">
                {{ item.name }}
              </v-list-item-title>
            </v-list-item-content>
            <v-list-item-action>
              <v-checkbox v-model="item.completed"></v-checkbox>
            </v-list-item-action>
            <v-list-item-action>
              <v-btn icon size="small" color="error" @click="deleteItem(item.id)">
                <v-icon>mdi-delete</v-icon>
              </v-btn>
            </v-list-item-action>
          </v-list-item>
        </v-list>
        <v-divider class="my-4"></v-divider>
        <v-card outlined>
          <v-card-title>共有メンバー</v-card-title>
          <v-card-text>
            <v-chip-group>
              <v-chip
                v-for="member in sharedMembers"
                :key="member.id"
                closable
                @click:close="removeMember(member.id)"
              >
                {{ member.name }}
              </v-chip>
            </v-chip-group>
            <v-text-field
              v-model="newMemberEmail"
              label="メンバーを招待（メールアドレス）"
              class="mt-2"
            ></v-text-field>
            <v-btn color="secondary" @click="inviteMember"> 招待 </v-btn>
          </v-card-text>
        </v-card>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script setup lang="ts">
import { ref } from 'vue'

interface ShoppingItem {
  id: number
  name: string
  completed: boolean
}

interface Member {
  id: number
  name: string
}

const shoppingList = ref<ShoppingItem[]>([
  { id: 1, name: '牛乳', completed: false },
  { id: 2, name: '卵', completed: true },
  { id: 3, name: 'パン', completed: false },
  { id: 4, name: 'りんご', completed: false },
  { id: 5, name: '洗剤', completed: true },
])

const newShoppingItem = ref('')

const sharedMembers = ref<Member[]>([
  { id: 1, name: '田中太郎' },
  { id: 2, name: '田中花子' },
  { id: 3, name: '田中次郎' },
])

const newMemberEmail = ref('')

const addShoppingItem = () => {
  if (newShoppingItem.value.trim()) {
    shoppingList.value.push({
      id: Date.now(),
      name: newShoppingItem.value,
      completed: false,
    })
    newShoppingItem.value = ''
  }
}

const deleteItem = (id: number) => {
  const index = shoppingList.value.findIndex((item) => item.id === id)
  if (index > -1) {
    shoppingList.value.splice(index, 1)
  }
}

const removeMember = (id: number) => {
  const index = sharedMembers.value.findIndex((member) => member.id === id)
  if (index > -1) {
    sharedMembers.value.splice(index, 1)
  }
}

const inviteMember = () => {
  if (newMemberEmail.value.trim()) {
    alert(`${newMemberEmail.value} に招待を送信しました`)
    newMemberEmail.value = ''
  }
}
</script>
