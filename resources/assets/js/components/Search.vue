<template>
    <div class="input-group">
        <span class="mdi mdi-search-web pos-left"/>
        <input class="input default" v-model="searchWord" @input="$emit('return', filtered)" type="text">
    </div>
</template>

<script>
  export default {
    name: 'Search',
    props: {
      arrayObject: {
        type: Array,
        required: true,
        default: []
      }
    },
    data() {
      return {
        searchWord: ''
      };
    },
    computed: {
      filtered: function () {
        let data = this.arrayObject,
            search = this.searchWord && this.searchWord.toLowerCase();
        let filter = (val, arr) => {
          return arr.filter(row => {
            return Object.keys(row).some(key => {
              return this.inArr(search, row[key]);
            });
          });
        };

        if (search) {
          data = filter(search, data);
        }
        return data;
      }
    },
    methods: {
      inArr: function (val, arr) {
        if(!(arr instanceof Object)) return String(arr).toLowerCase().indexOf(val) > -1;
        return Object.keys(arr).some(key => this.inArr(val, arr[key]));
      }
    },

  };
</script>

<style scoped>

</style>