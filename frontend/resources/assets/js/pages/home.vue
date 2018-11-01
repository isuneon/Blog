<style lang="scss">
  
</style>

<template>
    <div id="app">
        <router-view name="header"></router-view>
        <router-view name="sidebar"></router-view>
        
        <section class="content content--full">
           <div class="content__inner">
                <router-view></router-view>

                <router-view name="footer"></router-view>
           </div>
        </section>
    </div>
</template>

<script>


  export default {

    mounted() {

    },

    methods: {
      
    },

    computed: {
          
    },

    watch: {
        
    },

  }
</script>
