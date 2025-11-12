<template>
  <v-container class="fill-height" fluid>
    <v-row align="center" justify="center">
      <v-col cols="12" sm="8" md="4">
        <v-card class="elevation-12">
          <v-card-title class="text-h4 justify-center">
            <v-icon size="large" class="mr-2">mdi-calculator</v-icon>
            家計簿アプリ
          </v-card-title>
          <v-card-text>
            <v-form @submit.prevent="login">
              <v-text-field
                v-model="loginForm.email"
                label="メールアドレス"
                type="email"
                prepend-icon="mdi-email"
                required
              ></v-text-field>
              <v-text-field
                v-model="loginForm.password"
                label="パスワード"
                type="password"
                prepend-icon="mdi-lock"
                required
              ></v-text-field>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="primary" @click="login">ログイン</v-btn>
          </v-card-actions>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

const loginForm = ref({
  email: 'user@example.com',
  password: '',
})

const login = () => {
  router.push('/dashboard')
}
</script>
