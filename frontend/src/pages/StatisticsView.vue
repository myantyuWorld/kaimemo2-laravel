<template>
  <v-container>
    <v-card>
      <v-card-title>
        <v-icon class="mr-2">mdi-chart-line</v-icon>
        支出集計
      </v-card-title>
      <v-card-text>
        <v-row class="mb-4">
          <v-col cols="12" md="4">
            <v-text-field
              v-model="statisticsFilter.startDate"
              label="開始日"
              type="date"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="4">
            <v-text-field
              v-model="statisticsFilter.endDate"
              label="終了日"
              type="date"
            ></v-text-field>
          </v-col>
          <v-col cols="12" md="4">
            <v-select
              v-model="statisticsFilter.period"
              :items="['週間', '月間', '年間']"
              label="集計期間"
            ></v-select>
          </v-col>
        </v-row>

        <v-row>
          <v-col cols="12" md="6">
            <v-card outlined>
              <v-card-title>カテゴリ別支出</v-card-title>
              <v-card-text>
                <div class="chart-placeholder">円グラフ（カテゴリ別）</div>
              </v-card-text>
            </v-card>
          </v-col>
          <v-col cols="12" md="6">
            <v-card outlined>
              <v-card-title>期間別支出推移</v-card-title>
              <v-card-text>
                <div class="chart-placeholder">線グラフ（時系列）</div>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>

        <v-row class="mt-4">
          <v-col cols="12">
            <v-card outlined>
              <v-card-title>サマリー</v-card-title>
              <v-card-text>
                <v-row>
                  <v-col cols="12" md="3">
                    <v-card color="primary" dark>
                      <v-card-text>
                        <div class="text-h4">¥{{ weeklyTotal.toLocaleString() }}</div>
                        <div>今週の支出</div>
                      </v-card-text>
                    </v-card>
                  </v-col>
                  <v-col cols="12" md="3">
                    <v-card color="secondary" dark>
                      <v-card-text>
                        <div class="text-h4">¥{{ monthlyTotal.toLocaleString() }}</div>
                        <div>今月の支出</div>
                      </v-card-text>
                    </v-card>
                  </v-col>
                  <v-col cols="12" md="3">
                    <v-card color="success" dark>
                      <v-card-text>
                        <div class="text-h4">¥{{ averageDaily.toLocaleString() }}</div>
                        <div>1日平均</div>
                      </v-card-text>
                    </v-card>
                  </v-col>
                  <v-col cols="12" md="3">
                    <v-card color="warning" dark>
                      <v-card-text>
                        <div class="text-h4">{{ budgetUsageRate }}%</div>
                        <div>予算使用率</div>
                      </v-card-text>
                    </v-card>
                  </v-col>
                </v-row>
              </v-card-text>
            </v-card>
          </v-col>
        </v-row>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const statisticsFilter = ref({
  startDate: '',
  endDate: '',
  period: '週間',
})

const weeklyTotal = ref(15280)
const monthlyTotal = ref(127450)
const averageDaily = ref(4248)
const budgetUsageRate = ref(67)
</script>

<style scoped>
.chart-placeholder {
  height: 300px;
  background: #f5f5f5;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 4px;
}
</style>
