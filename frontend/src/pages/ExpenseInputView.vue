<template>
  <v-container>
    <v-card>
      <v-card-title>
        <v-icon class="mr-2">mdi-plus-circle</v-icon>
        支出を追加
      </v-card-title>
      <v-card-text>
        <v-form @submit.prevent="addExpense">
          <v-row>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="expenseForm.date"
                label="日付"
                type="date"
                required
              ></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-select
                v-model="expenseForm.category"
                :items="categories"
                label="カテゴリ"
                required
              ></v-select>
            </v-col>
            <v-col cols="12">
              <v-text-field v-model="expenseForm.item" label="品目" required></v-text-field>
            </v-col>
            <v-col cols="12" md="6">
              <v-text-field
                v-model="expenseForm.amount"
                label="金額"
                type="number"
                prefix="¥"
                required
              ></v-text-field>
            </v-col>
          </v-row>
        </v-form>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="primary" @click="addExpense"> 追加 </v-btn>
        <v-btn @click="$router.push('/dashboard')"> キャンセル </v-btn>
      </v-card-actions>
    </v-card>
  </v-container>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const expenseForm = ref({
  date: new Date().toISOString().substr(0, 10),
  item: '',
  amount: '',
  category: '',
})

const categories = ref(['食費', '交通費', '娯楽', '日用品', '医療費', 'その他'])

const addExpense = () => {
  alert('支出が追加されました')
  router.push('/dashboard')
}
</script>
