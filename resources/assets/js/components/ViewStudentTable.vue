<template>
    <div>
        <div class="input-line row justify-content-end">
            <search :array-object="data" @return="filtered = $event"/>
        </div>
        <div class="table-wrapper">
            <table class="table">
                <thead>
                <tr>
                    <th>№</th>
                    <th>ФИО</th>
                    <th>Email</th>
                    <th>Группа</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(val, i) in filtered" :key="i">
                    <td>
                        {{ i+1 }}
                    </td>
                    <td>
                        {{ getFullName(val) === false ? 'Нет данных' : getFullName(val) }}
                    </td>
                    <td>
                        {{ val.email }}
                    </td>
                    <td>
                        {{ val.group }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
  import Autocomplete from './Autocomplete';
  import {maxValue, numeric, email} from 'vuelidate/lib/validators';

  export default {
    name: 'ViewStudentTable',
    components: {Autocomplete},
    data() {
      return {
        data: [],
        filtered: []
      };
    },
    methods: {
      getData() {
        axios.get('api/students')
        .then(result => {
          this.data = result.data;
          this.filtered = this.data;
        })
      },
      getFullName(arr) {
        if(arr.firstname === null) {
          return  false;
        }
        return `${arr.lastname} ${arr.firstname} ${arr.patronymic}`;
      },
    },
    mounted() {
     this.getData();
    }
  };
</script>

<style scoped>
    .mdi-delete {
        cursor: pointer;
    }
</style>