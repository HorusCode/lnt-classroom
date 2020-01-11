<template>
    <div class="modal">
        <div class="modal-container">
            <div class="modal__card">
                <div class="close" @click="closeModal"><span>&#43;</span></div>
                <div class="modal__header">
                    <h2 class="text-title">Modal title</h2>
                </div>
                <div class="modal__content">
                    <div class="input-line square">
                        <input type="text" class="input rad-def" placeholder="Login">
                    </div>
                </div>
                <div class="d-flex justify-content-end">
                    <button class="btn is-small btn-default-text" @click="closeModal">Cancel</button>
                    <button class="btn is-small btn-primary-text">Accept</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "CreateCourse",
        props: ['anim'],
        data() {
            return {
                modal: null
            }
        },
        mounted: function () {
            this.modal = document.querySelector('.modal');
            this.modal.classList.remove(`out`);
            this.modal.classList.add(`${this.anim}`);
        },
        methods: {
            closeModal: function () {
                this.modal.classList.add('out');
                this.modal.addEventListener('animationend', () => {
                    this.$emit('close')
                }, false);
            }
        }
    }
</script>

<style scoped>

</style>