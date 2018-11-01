<style lang="scss">
  
</style>

<template>
<div>
    <header class="content__title">
        <h1>Crear Blog</h1>

        <div class="actions">
            <a href="" class="actions__item zmdi zmdi-trending-up"></a>
            <a href="" class="actions__item zmdi zmdi-check-all"></a>

            <div class="dropdown actions__item">
                <i data-toggle="dropdown" class="zmdi zmdi-more-vert"></i>
                <div class="dropdown-menu dropdown-menu-right">
                    <a href="" class="dropdown-item">Refresh</a>
                    <a href="" class="dropdown-item">Manage Widgets</a>
                    <a href="" class="dropdown-item">Settings</a>
                </div>
            </div>
        </div>
    </header>
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">Blog</h4>
            <h6 class="card-subtitle"></h6>
            <br>
            <div class="row">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="zmdi zmdi-blogger zmdi-hc-fw"></i></span>
                    </div>
                    <input type="text" class="form-control" v-model="nombre" placeholder="Nombre del Blog...." requires>
                    <i class="form-group__bar"></i>
                    <span v-show="errors.nombre != null" class="text-danger">{{ errors.nombre }}</span>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="zmdi zmdi-assignment zmdi-hc-fw"></i></span>
                    </div>
                    <textarea class="form-control" rows="5" v-model="descripcion" placeholder="Descripcion del Blog...." required></textarea>
                    <i class="form-group__bar"></i>
                    <span v-show="errors.descripcion != null" class="text-danger">{{ errors.descripcion }}</span>
                </div>
                <button type="button" class="btn btn-success" v-on:click="createBlog()">Crear</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    export default {

        data(){
            return {
                nombre: '',
                descripcion: '',
                errors: {
                    nombre: '',
                    descripcion: '',
                }
            }
        },

        created(){
        
        },

        mounted() {

        },

        methods: {
            createBlog() {
                this.errors.nombre = null;
                this.errors.descripcion = null;
                this.$store.dispatch( 'createBlog', {
                    nombre: this.nombre,
                    descripcion: this.descripcion,
                })
                .then(data => { 

                })
                .catch( function(err){
                    console.log(err);
                });
            },
        },

        computed: {
            blogError(){
                return this.$store.getters.getBlogError;
            },

            blogCreateStatus(){
                return this.$store.getters.getBlogCreateStatus;
            },
        },

        watch: {
            'blogError': function(){
                if(this.blogError.nombre != null)
                    this.errors.nombre = this.blogError.nombre[0];
                else
                if(this.blogError.descripcion != null)
                    this.errors.descripcion = this.blogError.descripcion[0];
            },     

            'blogCreateStatus': function(){
                if(this.blogCreateStatus == 1){

                    this.$router.push('/home');    
                }
            },
        },
    }
</script>