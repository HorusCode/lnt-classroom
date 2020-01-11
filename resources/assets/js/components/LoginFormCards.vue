<template>
    <section>
        <div class="card loginForm">
            <div class="card-content">
                <header class="card-header">
                    <h3 class="text-center mx-1"><span class="text-primary">Login</span> your account</h3>
                </header>
                <form>
                    <div class="input-line">
                        <label for="login" class="input-label">Login</label>
                        <div class="input-group">
                            <span class="mdi mdi-login-variant pos-left"/>
                            <input type="text" id="login" class="input">
                        </div>
                    </div>
                    <div class="input-line">
                        <label for="password" class="input-label">Password</label>
                        <div class="input-group">
                            <span class="mdi mdi-textbox-password pos-left"/>
                            <input v-bind:type="showPassword ? 'text' : 'password'" id="password" class="input">
                            <span class="mdi  pos-right eye-password"
                                  :class="[{'mdi-eye-outline':showPassword}, 'mdi-eye-off-outline']"
                                  @click="showPassword = !showPassword"/>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="label-link"
                              @click="showForm('.codeForm','.loginForm')">Is this your first time?</span>
                        <span class="label-link" @click="showForm('.emailForm','.loginForm')">Forget password?</span>
                    </div>
                    <div class="d-flex align-items-center justify-contentYt
                       -center mx-1">
                        <button type="submit" class="btn btn-primary width-3">Login</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card codeForm">
            <div class="card-content">
                <header class="card-header">
                    <h3 class="text-center mx-1">Write <span class="text-primary">code</span> your account</h3>
                </header>
                <form>
                    <div class="input-line">
                        <label for="code" class="input-label">Code</label>
                        <div class="input-group">
                            <span class="mdi mdi-code-brackets pos-left"></span>
                            <input type="text" id="code" class="input">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="label-link" @click="showForm('.loginForm','.codeForm')">← Back</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center mx-1">
                        <button type="submit" class="btn btn-primary width-3">Send</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card emailForm">
            <div class="card-content">
                <header class="card-header">
                    <h3 class="text-center mx-1">Write your <span class="text-primary">email</span> for pass</h3>
                </header>
                <form>
                    <div class="input-line">
                        <label for="email" class="input-label">Email</label>
                        <div class="input-group">
                            <span class="mdi mdi-email-outline pos-left"></span>
                            <input type="text" id="email" class="input">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="label-link" @click="showForm('.loginForm','.emailForm')">← Back</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center mx-1">
                        <button type="submit" class="btn btn-primary width-3">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</template>

<script>
    export default {
        name: "LoginFormCards",
        data() {
            return {
                showPassword: false,
            }
        },
        methods: {
            showForm: function (openForm, closeForm) {
                let forms = anime.timeline({
                    duration: 750,
                    easing: 'easeInOutBack'
                });
                forms.add({
                    targets: closeForm,
                    translateX: '150%',
                    complete: () => {
                        document.querySelector(openForm).style.display = 'flex';
                        document.querySelector(closeForm).style.display = 'none';
                    }
                }).add({
                    targets: openForm,
                    translateX: ['150%', '0%']
                });
            }
        }
    }
</script>

<style scoped>

</style>