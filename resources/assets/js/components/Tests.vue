<template>
    <div>
        <button
                class="btn btn-secondary size-1"
                @click="showModal = true, updatingTest = {}"
        >
            <i class="mdi mdi-plus"/>
            Создать
        </button>
        <div class="table-wrapper">
            <table class="table">
                <thead>
                <tr>
                    <th>Название теста</th>
                    <th>Количество вопросов</th>
                    <th>Создан</th>
                    <th>Правлен</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <tr
                        v-for="(test, index) in tests"
                        :key="index"
                >
                    <td>
                        {{ test.title }}
                    </td>
                    <td>
                        {{ test.questions.length }}
                    </td>
                    <td>
                        {{ test.created_at }}
                    </td>
                    <td>
                        {{ test.updated_at }}
                    </td>
                    <td>
                        <button
                                class="btn btn-primary is-small width-1 m-0"
                                @click="updateModalTest(test)"
                        >
                            Редактировать
                        </button>
                        <button
                                class="btn btn-danger is-small width-1 m-0"
                                @click="updateModalTest(test)"
                        >
                            Удалить
                        </button>
                    </td>
                </tr>
                </tbody>

            </table>
        </div>

        <modal-create-test
                v-if="showModal"
                anim="slideDownLarge"
                :updating-test="updatingTest"
                @close="showModal = false"
        />
    </div>

</template>

<script>
  import ModalCreateTest from './ModalCreateTest';

  export default {
    name: 'Tests',
    components: {
      ModalCreateTest,
    },
    data() {
      return {
        showModal: false,
        tests: [],
        updatingTest: {},
      };
    },
    mounted() {
      axios.get('api/tests').then(result => {
        this.tests = result.data;
      });
    },
    methods: {
      updateModalTest(test) {
        this.updatingTest = JSON.parse(JSON.stringify(test));
        this.showModal = true;
      },
    },
  };
</script>

<style scoped>

</style>