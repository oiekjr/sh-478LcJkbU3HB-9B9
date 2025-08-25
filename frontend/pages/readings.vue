<template>
  <div>
    <div style="text-align: right; margin-bottom: 16px">
      <a-button type="primary" @click="openAddReadingModal"
        >感想を追加する</a-button
      >
    </div>
    <a-modal
      v-model="isAddModalVisible"
      title="感想を追加"
      ok-text="保存する"
      cancel-text="キャンセル"
      @ok="addReading"
      @cancel="isAddModalVisible = false"
    >
      <a-form layout="vertical">
        <a-form-item label="タイトル">
          <a-input v-model="draftAdd.title" placeholder="タイトルを入力" />
        </a-form-item>
        <a-form-item label="読んだ日付">
          <a-date-picker
            v-model="draftAdd.read_on"
            format="YYYY-MM-DD"
            style="width: 100%"
          />
        </a-form-item>
        <a-form-item label="感想">
          <a-textarea
            v-model="draftAdd.impression"
            rows="4"
            placeholder="感想を入力"
          />
        </a-form-item>
      </a-form>
    </a-modal>
    <a-modal
      v-model="isEditModalVisible"
      :title="`#${draftEdit.id} を編集中`"
      ok-text="保存する"
      cancel-text="キャンセル"
      @ok="editReading"
      @cancel="isEditModalVisible = false"
    >
      <a-form layout="vertical">
        <a-form-item label="タイトル">
          <a-input v-model="draftEdit.title" placeholder="タイトルを入力" />
        </a-form-item>
        <a-form-item label="読んだ日付">
          <a-date-picker
            v-model="draftEdit.read_on"
            format="YYYY-MM-DD"
            style="width: 100%"
          />
        </a-form-item>
        <a-form-item label="感想">
          <a-textarea
            v-model="draftEdit.impression"
            rows="4"
            placeholder="感想を入力"
          />
        </a-form-item>
      </a-form>
    </a-modal>
    <a-table
      class="table"
      :columns="columns"
      :data-source="readings"
      row-key="id"
      :loading="isLoading"
      :pagination="false"
    >
      <template #readOn="readOn">
        <span>{{
          new Date(readOn).toLocaleDateString('ja-JP', {
            year: 'numeric',
            month: 'long',
            day: 'numeric',
            timeZone: 'Asia/Tokyo',
          })
        }}</span>
      </template>
      <template #impression="impression">
        <div style="white-space: pre-wrap">{{ impression }}</div>
      </template>
      <template #action="_, record">
        <div class="action-col">
          <a href="#" @click.prevent="openEditReadingModal(record)">編集</a>
          <a-popconfirm
            :title="`「${record.title}」の感想を削除しますか？`"
            @confirm="() => removeReading(record.id)"
          >
            <a href="javascript:void(0)">削除</a>
          </a-popconfirm>
        </div>
      </template>
    </a-table>
  </div>
</template>

<script lang="ts">
import Vue from 'vue'

type Reading = {
  id: number
  title: string
  read_on: string
  impression: string
  created_at: string
  updated_at: string
}

type ReadingStore = {
  title: string
  read_on: string
  impression: string
}

type ReadingsUpdate = ReadingStore & {
  id: number
}

export default Vue.extend({
  name: 'ReadingsPage',
  layout: 'auth',
  data() {
    return {
      isLoading: false,
      readings: [] as Array<Reading>,
      columns: [
        { title: '#', dataIndex: 'id', key: 'id', width: '10%' },
        { title: 'タイトル', dataIndex: 'title', key: 'title', width: '20%' },
        {
          title: '読んだ日付',
          dataIndex: 'read_on',
          key: 'read_on',
          width: '15%',
          scopedSlots: { customRender: 'readOn' },
        },
        {
          title: '感想',
          dataIndex: 'impression',
          key: 'impression',
          scopedSlots: { customRender: 'impression' },
        },
        {
          title: '操作',
          key: 'action',
          width: '10%',
          scopedSlots: { customRender: 'action' },
        },
      ],
      isAddModalVisible: false,
      draftAdd: {
        title: '',
        read_on: '',
        impression: '',
      } as ReadingStore,
      isEditModalVisible: false,
      draftEdit: {
        id: 0,
        title: '',
        read_on: '',
        impression: '',
      } as ReadingsUpdate,
    }
  },
  async created() {
    await this.fetchReadings()
  },
  methods: {
    /**
     * 読書記録一覧の取得
     */
    async fetchReadings() {
      if (this.isLoading) {
        return
      }

      this.isLoading = true
      try {
        const response = await this.$axios.get<Array<Reading>>('/readings')
        this.readings = response.data
      } catch (error) {
        console.error('Error fetching readings:', error)
      } finally {
        this.isLoading = false
      }
    },
    /**
     * 読書記録の追加モーダルを開く
     */
    openAddReadingModal() {
      this.draftAdd = { title: '', read_on: '', impression: '' }
      this.isAddModalVisible = true
    },
    /**
     * 読書記録の追加
     */
    async addReading() {
      try {
        const response = await this.$axios.post<Reading>(
          '/readings',
          this.draftAdd
        )
        // 追加したレコードをリストに反映
        this.readings.push(response.data)
        this.isAddModalVisible = false
      } catch (error) {
        // TODO: エラーハンドリング
        console.error(error)
      }
    },
    /**
     * 読書記録の編集モーダルを開く
     * @param reading
     */
    openEditReadingModal(reading: Reading) {
      this.draftEdit = {
        id: reading.id,
        title: reading.title,
        read_on: reading.read_on,
        impression: reading.impression,
      }
      this.isEditModalVisible = true
    },
    /**
     * 読書記録の編集
     */
    async editReading() {
      try {
        const { id, ...updateData } = this.draftEdit
        const response = await this.$axios.put<Reading>(
          `/readings/${id}`,
          updateData
        )
        // 編集したレコードをリストに反映
        const idx = this.readings.findIndex((r) => r.id === id)
        if (idx !== -1) {
          this.readings.splice(idx, 1, response.data)
        }
        this.isEditModalVisible = false
      } catch (error) {
        // TODO: エラーハンドリング
        console.error(error)
      }
    },
    /**
     * 読書記録の削除
     * @param readingId
     */
    async removeReading(readingId: number) {
      try {
        await this.$axios.delete(`/readings/${readingId}`)
        this.readings = this.readings.filter((r) => r.id !== readingId)
      } catch (error) {
        // TODO: エラーハンドリング
        console.error(error)
      }
    },
    /**
     * 感想の表示形式を整形
     * @param impression
     * @returns
     */
    formatImpression(impression: string) {
      return impression.replace(/\n/g, '<br>')
    },
  },
})
</script>

<style>
.table {
  background: white;
}

.action-col {
  display: flex;
  gap: 12px;
}
</style>
