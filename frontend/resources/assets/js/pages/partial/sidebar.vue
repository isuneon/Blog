<style lang="scss">

</style>

<template>
          <aside class="sidebar sidebar--hidden">
                <div class="scrollbar-inner">
                    <div class="user">
                        <div class="user__info" data-toggle="dropdown">
                            <img class="user__img" src="/img/profile-pics/8.jpg" alt="">
                            <div>
                                <div class="user__name">{{this.user.name}}</div>
                                <div class="user__email">{{this.user.email}}</div>
                            </div>
                        </div>

                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="#" v-on:click="logout()">Cerrar Sección</a>
                        </div>
                    </div>

                    <ul class="navigation">
                        <li><a href="#/home"><i class="zmdi zmdi-home"></i> Home</a></li>
                    </ul>
                </div>
            </aside>
</template>

<script>

    export default {

        created() {
            this.$store.dispatch( 'loadUser' );
            this.$store.dispatch('licencia');
        },

        methods: {
    		logout(){
        		this.$store.dispatch('logoutUser');
                this.$router.push({ name: 'login' });
      		},

        },

        computed: {
            user(){
                return this.$store.getters.getUser;
            },

            diff() {
                return this.$store.getters.getLoadLicencia;
            }
        },

        watch: {
            'diff': function() { 
                if(this.diff != 0) {
                    if(this.diff < 10)
                        $.notify({
                            icon: 'fa fa-check',
                            title: ' Notificación',
                            message: 'Licencia próxima a vencer en '+this.diff+' días',
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
