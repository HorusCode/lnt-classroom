<template>
    <section class="login-section">
        <login-form @showform="showForm"/>
        <email-form @showform="showForm"/>
        <code-form @showform="showForm"/>
    </section>
</template>

<script>
  import LoginForm from './LoginCards/LoginForm';
  import EmailForm from './LoginCards/EmailForm';
  import CodeForm from './LoginCards/CodeForm';

  export default {
    name: 'LoginFormCards',
    components: {CodeForm, EmailForm, LoginForm},
    data() {
      return {
        showPassword: false,
        activeForm: '.loginForm'
      };
    },
    methods: {
      showForm: function(closeForm, openForm) {
        this.activeForm = openForm;
        let forms = anime.timeline({
          duration: 750,
          easing: 'easeInOutBack',
        });
        forms.add({
          targets: closeForm,
          translateX: '150%',
          complete: () => {
            document.querySelector(openForm).style.display = 'flex';
            document.querySelector(closeForm).style.display = 'none';
          },
        }).add({
          targets: openForm,
          translateX: ['150%', '0%'],
        });
      },
    },
  };
</script>

<style scoped>

</style>