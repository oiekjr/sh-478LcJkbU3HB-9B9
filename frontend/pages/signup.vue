<template>
  <div class="container">
    <div class="form-wrapper">
      <div class="title">アカウント登録</div>
      <a-form-model
        :model="form"
        :rules="rules"
        @submit="handleSubmit"
        @submit.native.prevent
      >
        <a-form-model-item prop="nickname">
          <a-input v-model="form.nickname" placeholder="ニックネーム">
            <template #prefix>
              <a-icon type="user" style="color: rgba(0, 0, 0, 0.25)" />
            </template>
          </a-input>
        </a-form-model-item>
        <a-form-model-item prop="email">
          <a-input v-model="form.email" placeholder="メールアドレス">
            <template #prefix>
              <a-icon type="mail" style="color: rgba(0, 0, 0, 0.25)" />
            </template>
          </a-input>
        </a-form-model-item>
        <a-form-model-item prop="password">
          <a-input
            v-model="form.password"
            type="password"
            placeholder="パスワード"
          >
            <template #prefix>
              <a-icon type="lock" style="color: rgba(0, 0, 0, 0.25)" />
            </template>
          </a-input>
        </a-form-model-item>
        <a-form-model-item prop="passwordConfirm">
          <a-input
            v-model="form.passwordConfirm"
            type="password"
            placeholder="パスワード確認"
          >
            <template #prefix>
              <a-icon type="lock" style="color: rgba(0, 0, 0, 0.25)" />
            </template>
          </a-input>
        </a-form-model-item>
        <a-form-model-item>
          <a-button
            block
            type="primary"
            html-type="submit"
            :disabled="isSubmitDisabled"
          >
            アカウント登録
          </a-button>
        </a-form-model-item>
      </a-form-model>
      <NuxtLink to="/login">アカウント登録がお済みの方はこちら</NuxtLink>
    </div>
  </div>
</template>

<script lang="ts">
import Vue from 'vue'

export default Vue.extend({
  name: 'AppSignup',
  data() {
    return {
      form: {
        nickname: '',
        email: '',
        password: '',
        passwordConfirm: '',
      },
    }
  },
  computed: {
    rules(): any {
      return {
        nickname: [
          {
            required: true,
            message: 'ニックネームを入力してください',
            trigger: 'blur',
          },
        ],
        email: [
          {
            required: true,
            message: 'メールアドレスを入力してください',
            trigger: 'blur',
          },
          {
            type: 'email',
            message: '正しいメールアドレス形式で入力してください',
            trigger: 'blur',
          },
        ],
        password: [
          {
            required: true,
            message: 'パスワードを入力してください',
            trigger: 'blur',
          },
        ],
        passwordConfirm: [
          {
            required: true,
            message: 'パスワード確認を入力してください',
            trigger: 'blur',
          },
          {
            validator: this.passwordConfirmValidator,
            trigger: 'blur',
          },
        ],
      }
    },
    isSubmitDisabled(): boolean {
      return (
        this.form.nickname === '' ||
        this.form.email === '' ||
        this.form.password === '' ||
        this.form.passwordConfirm === '' ||
        this.form.password !== this.form.passwordConfirm
      )
    },
  },
  methods: {
    handleSubmit(_: Event) {
      console.log(this.form)
    },
    passwordConfirmValidator(_rule: any, value: string, callback: Function) {
      if (value !== this.form.password) {
        callback(new Error('パスワードが一致しません'))
      } else {
        callback()
      }
    },
  },
})
</script>

<style>
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  background-color: #f0f2f5;
}

.form-wrapper {
  width: 400px;
  padding: 40px;
  background: #fff;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  text-align: center;
}

.title {
  font-size: 24px;
  margin-bottom: 32px;
  font-weight: bold;
}
</style>
