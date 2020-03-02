<template>
    <div>

        <div class="input-line row">
            <label class="input-label">Группа</label>
            <autocomplete :suggestions="groups" v-model="selection" @input="searchGroup"></autocomplete>
        </div>
        <div class="table-wrapper">
            <div class="table-header d-flex align-items-center">
                <div class="input-line row">
                    <label class="input-label">Кол-во студентов</label>
                    <input class="input square transparent" type="text" v-model="count">
                </div>
                <div class="spacer"></div>
                <button type="button" class="btn btn--rounded btn-secondary" @click="generateStudents">
                    <span class="mdi mdi-plus"></span>
                </button>
                <button type="button" class="btn btn--rounded btn-danger" @click="data = []">
                    <span class="mdi mdi-delete-forever"></span>
                </button>
                <hr class="v-divider mx-1">
                <button type="button" class="btn btn--rounded btn-primary">
                    <span class="mdi mdi-printer"></span>
                </button>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th>№</th>
                    <th>E-mail</th>
                    <th>Ключ</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(s, i) in data" :key="i">
                    <td>{{ i + 1 }}</td>
                    <td>
                        <input type="text" class="input default" v-model="s.email">
                    </td>
                    <td>{{ s.code }}</td>
                    <td>
                        <button type="button" class="btn btn--rounded btn-warning-outline" @click="removeStudent(i)">
                            <span class="mdi mdi-delete-forever"></span>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
  import Autocomplete from './Autocomplete';
  export default {
    name: 'AddStudentForm',
    components: {Autocomplete},
    data() {
      return {
        data: [],
        count: 1,
        selection: '',
        groups: []
      };
    },
    methods: {
      generateStudents() {
        for (let i = 0; i < this.count; i++) {
          this.data.push({
            email: '',
            code: Math.random().toString(36).substr(2, 10).toUpperCase(),
          });
        }
      },
      removeStudent(i) {
        this.data.splice(i, 1);
      },
      searchGroup(value) {
        axios.get(`/api/groups/search?group=${value}`).then(response => {
          this.groups = response.data;
        });
      },
    },
  };
</script>

<style scoped>
    .mdi-delete {
        cursor: pointer;
    }
</style>