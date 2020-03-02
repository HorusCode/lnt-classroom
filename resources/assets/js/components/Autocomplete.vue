<template>

        <div class="input-group">
            <span class="mdi mdi-search-web pos-left"/>
            <input class="input default" type="text" :value="value" @input="updateValue($event.target.value)"
                   @blur="open = openSuggestion"
                   @keydown.enter='enter'
                   @keydown.down='down'
                   @keydown.up='up'>
            <ul class="dropdown-menu" v-if="open">
                <li class="dropdown-menu__item" v-for="(suggestion, index) in matches"
                    v-bind:class="{'active': isActive(index)}"
                    @click="suggestionClick(index)">
                    {{ suggestion.group }}
                </li>
            </ul>
        </div>

</template>

<script>
  export default {
    name: 'Autocomplete',
    props: {
      value: {
        type: String,
        required: true,
      },
      suggestions: {
        type: Array,
        required: true,
      },
    },
    data() {
      return {
        open: false,
        current: 0,
        selection: '',
      };
    },
    computed: {
      // Filtering the suggestion based on the input
      matches() {
        return this.suggestions.filter((obj) => {
          return obj.group.toLowerCase().indexOf(this.value.toLowerCase()) >= 0;
        });
      },

      openSuggestion () {
        return this.selection !== '' &&
            this.matches.length !== 0 &&
            this.open === true
      }
    },
    methods: {
      updateValue: function(value) {
        this.selection = value;
        if (this.open === false) {
          this.open = true;
          this.current = 0;
        }
        this.$emit('input', value);
      },
      // When enter pressed on the input
      enter() {
        this.$emit('input', this.matches[this.current].group);
        this.open = false;
      },
      // When up pressed while suggestions are open
      up() {
        if (this.current > 0) {
          this.current--;
        }
      },
      // When up pressed while suggestions are open
      down() {
        if (this.current < this.matches.length - 1) {
          this.current++;
        }
      },
      handleClickOutside(evt) {
        if (!this.$el.contains(evt.target)) {
          this.open = false;
          this.counter = 0;
        }
      },
      // For highlighting element
      isActive(index) {
        return index === this.current;
      },
      // When one of the suggestion is clicked
      suggestionClick(index) {
        this.$emit('input', this.matches[index].group);
        this.open = false;
      },
    },
    mounted() {
      document.addEventListener("click", this.handleClickOutside);
    },
    destroyed() {
      document.removeEventListener("click", this.handleClickOutside);
    }
  };
</script>

<style scoped>

</style>