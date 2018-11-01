<style lang="scss">
  
</style>

<template>
          <footer class="footer hidden-xs-down">
                    <p>© Material Admin Responsive. All rights reserved.</p>

                    <ul class="nav footer__nav">
                        <a class="nav-link" href="">Homepage</a>

                        <a class="nav-link" href="">Company</a>

                        <a class="nav-link" href="">Support</a>

                        <a class="nav-link" href="">News</a>

                        <a class="nav-link" href="">Contacts</a>
                    </ul>
                </footer>
</template>

<script>
    import moment from 'moment';

    export default {
        data() {
            return {
                year: '',
            }
        },

        mounted() {
            this.year = moment().format('YYYY');
        },

        methods: {
      
        },

        computed: {
      
        },

        watch: {
      
        },

    }
</script>
