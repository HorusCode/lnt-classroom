<template>
    <div class="card loginForm login--form">
        <div class="card-content">
            <header class="card-header">
                <h3 class="text-center mx-1"><span class="text-primary">Login</span> your account</h3>
            </header>
            <form @submit.prevent="login">
                <input type="hidden" name="_token" :value="csrf">
                <div class="input-line">
                    <label for="login" class="input-label">Email</label>
                    <div class="input-group">
                        <span class="mdi mdi-email pos-left"/>
                        <input type="text" id="login" class="input" name="email" v-model="email">
                    </div>
                    <span class="invalid-feedback" v-if="'email' in errors">{{ errors.email[0] }}</span>
                </div>
                <div class="input-line">
                    <label for="password" class="input-label">Password</label>
                    <div class="input-group">
                        <span class="mdi mdi-textbox-password pos-left"/>
                        <input v-bind:type="showPassword ? 'text' : 'password'"
                               id="password"
                               class="input"
                               name="password"
                        v-model="password">
                        <span class="mdi  pos-right eye-password"
                              :class="[{'mdi-eye-outline':showPassword}, 'mdi-eye-off-outline']"
                              @click="showPassword = !showPassword"/>
                    </div>
                    <span class="invalid-feedback" v-if="'password' in errors">{{ errors.password[0] }}</span>
                </div>
                <div class="d-flex justify-content-between">
                        <span class="label-link"
                              @click="$emit('showform', '.loginForm','.codeForm')">Is this your first time?</span>
                    <span class="label-link" @click="$emit('showform', '.loginForm','.emailForm')">Forget password?</span>
                </div>
                <div class="d-flex align-items-center justify-content-center mx-1">
                    <button type="submit" class="btn btn-primary width-1">
                        <div class="spinner spinner-3 s-24" v-if="loading"></div>
                        <span v-else>Вход</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>

  export default {
    name: 'LoginForm',
    data() {
      return {
        showPassword: false,
        email: '',
        password: '',
        csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
        errors: {},
        loading: false,
      };
    },
    methods: {
      login() {
        this.errors = {};
        this.loading = true;
        axios.post('/login', {
          'email': this.email,
          'password': this.password,
          '_token': this.csrf
        })
        .then((response) => {
          window.location.href = response.data.redirect;
        })
        .catch((error) => {
          this.errors = error.response.data.errors;
        }).finally(() => {
          this.loading = false;
        });
      }
    }
  };
</script>

<style scoped>

</style>