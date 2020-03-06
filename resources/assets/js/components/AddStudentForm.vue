<template>
    <div>
        <div class="input-line row">
            <label class="input-label">Группа</label>
            <autocomplete :suggestions="groups" :loading="loading" v-model="selection" @input="searchDebounce"></autocomplete>
        </div>
        <div class="table-wrapper">
            <div class="table-header d-flex align-items-center">
                <div class="input-line row">
                    <label class="input-label">Кол-во студентов</label>
                    <div>
                        <input class="input square transparent"
                               type="text"
                               v-model.number="count"
                               @keypress="validateKey">
                        <span class="invalid-feedback" v-if="!$v.count.maxValue">Максимум {{ $v.count.$params.maxValue.max }}</span>
                    </div>
                </div>
                <div class="spacer"></div>
                <button type="button" class="btn btn--rounded btn-secondary" @click="generateStudents" :disabled="$v.count.$invalid">
                    <span class="mdi mdi-plus"></span>
                </button>
                <button type="button" class="btn btn--rounded btn-danger" @click="data = []">
                    <span class="mdi mdi-delete-forever"></span>
                </button>
                <hr class="v-divider mx-1">
                <button type="button" class="btn btn--rounded btn-primary">
                    <span class="mdi mdi-printer"></span>
                </button>
                <button type="button"
                        :disabled="data.length === 0 || $v.$invalid"
                        class="btn btn--rounded btn-primary-outline"
                        @click="sendStudents"
                >
                    <span class="mdi mdi-account-edit-outline"></span>
                </button>
                <span class="text-danger">
                    {{ data.length }} / {{ maxCount }}
                </span>
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
                        <input type="text"
                               class="input default"
                               v-model="s.email"
                               :class="{'invalid': $v.data.$each[i].email.$invalid}"
                        >
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
  import { maxValue, numeric, email } from 'vuelidate/lib/validators';

  export default {
    name: 'AddStudentForm',
    components: {Autocomplete},
    data() {
      return {
        data: [],
        count: 1,
        selection: '',
        groups: [],
        loading: false,
        maxCount: 35,
        create: false
      };
    },
    validations() {
      return {
        count: {
          maxValue: maxValue(this.maxCount - this.data.length),
          numeric
        },
        data: {
          $each: {
            email: {
              email,
              isDuplicate(email, val) {
                const valIndex = this.data.findIndex(
                    v => v.email === email
                );
                let isWrong = true;
                this.data.forEach((valObject, index) => {
                  if (index !== valIndex) {
                    if (valObject.email === val.email) {
                      isWrong = false;
                    }
                  }
                });

                return isWrong;
              },
              empty: val => val.length > 0,
            }
          }
        }
      }
    },
    methods: {
      generateStudents() {
          for (let i = 0; i < this.count; i++) {
            if(this.data.length < this.maxCount) {
              this.data.push({
                email: '',
                code: Math.random().toString(36).substr(2, 10).toUpperCase(),
              });
            }
          }
      },
      validateKey(ev) {
        if(!/\d/.test(ev.key) || !this.$v.count.maxValue) {
          return ev.preventDefault();
        }
      },
      removeStudent(i) {
        this.data.splice(i, 1);
      },
      sendStudents() {
        axios.post('/api/students', JSON.stringify(this.data))
        .then(response => {
          console.log(response);
        })
      },
      searchDebounce: _.debounce(function(value) {
        this.search(value);
      }, 800),
      search(value) {
        this.loading = true;
        axios.get(`/api/groups/search?group=${value}`).then(response => {
          this.groups = response.data;
          this.loading = false;
        });
      }
    },
  };
</script>

<style scoped>
    .mdi-delete {
        cursor: pointer;
    }
</style>