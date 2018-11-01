<style lang="scss">
  
</style>

<template>
<div>
    <header class="content__title">
        <h1>Midificar Blog</h1>

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
                <button type="button" class="btn btn-success" v-on:click="updateBlog()">Modificar</button>
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
            this.$store.dispatch( 'loadBlog',{id: this.$route.params.id} );
        },

        mounted() {

        },

        methods: {
            updateBlog() { 
                this.$store.dispatch( 'updateBlog', {
                    nombre: this.nombre,
                    descripcion: this.descripcion,
                    id: this.$route.params.id
                })
                .then(data => {
                
                });
            },
        },

        computed: {
            blog() {
                return this.$store.getters.getBlog;
            },

            blogError(){
                return this.$store.getters.getBlogError;
            },

            blogUpdateStatus(){
                return this.$store.getters.getBlogUpdateStatus;
            },
        },

        watch: {
            'blog': function(){
                if( this.blog != '' ){
                    this.nombre = this.blog[0].nombre;
                    this.descripcion = this.blog[0].descripcion;
                }
            },

            'blogError': function(){
                if(this.blogError.nombre != null)
                    this.errors.nombre = this.blogError.nombre[0];
                else
                if(this.blogError.descripcion != null)
                    this.errors.descripcion = this.blogError.descripcion[0];
            },     

            'blogUpdateStatus': function(){
                if(this.blogUpdateStatus == 1){
                    this.$router.push('/home');
                    $.notify({
                        icon: 'fa fa-check',
                        title: ' Notificación',
                        message: 'Blog Actualizado',
                        url: ''
                    },{
                        element: 'body',
                        type: 'inverse',
                        allow_dismiss: true,
                        placement: {
                            from: 'top',
                            align: 'center'
                        },
                        offset: {
                            x: 20,
                            y: 20
                        },
                        spacing: 10,
                        z_index: 1031,
                        delay: 2500,
                        timer: 1000,
                        url_target: '_blank',
                        mouse_over: false,
                        animate: {
                            enter: 'fadeInDown',
                            exit: 'fadeOutUp'
                        },
                        template:   '<div data-notify="container" class="alert alert-dismissible alert-{0} alert--notify" role="alert">' +
                                    '<span data-notify="icon"></span> ' +
                                    '<span data-notify="title">{1}</span> ' +
                                    '<span data-notify="message">{2}</span>' +
                                    '<div class="progress" data-notify="progressbar">' +
                                        '<div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>' +
                                    '</div>' +
                                    '<a href="{3}" target="{4}" data-notify="url"></a>' +
                                    '<button type="button" aria-hidden="true" data-notify="dismiss" class="alert--notify__close">Close</button>' +
                                '</div>'
                    });
                }
            },  
        },
    }
</script>