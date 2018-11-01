<style lang="scss">
  
</style>

<template>
    <div class="login">

            <div class="login__block active" id="l-login">
                <div class="login__block__header">
                    <i class="zmdi zmdi-account-circle"></i>
                    Estas aquÃ­! Por favor acceda
                </div>

                <div class="login__block__body">
                    <div class="form-group form-group--float form-group--centered">
                        <input type="text" class="form-control" v-model="email">
                        <label>Email Address</label>
                        <i class="form-group__bar"></i>
                    </div>

                    <div class="form-group form-group--float form-group--centered">
                        <input type="password" class="form-control" v-model="password">
                        <label>Password</label>
                        <i class="form-group__bar"></i>
                    </div>

                    <button v-on:click="logins()" class="btn btn--icon login__block__btn"><i class="zmdi zmdi-long-arrow-right"></i></button>
                </div>
            </div>
        </div>
</template>

<script>
  export default {
    data(){
      return {
        email: '',
        password: '',
        remember_me: true
      }
    },

    methods: {
      logins(){
        this.$store.dispatch( 'login', {
          email: this.email,
          password: this.password,
          remember_me: this.remember_me
        })
        .then(data => {
              /*this.$router.push(data.url);*/
        });
      },
    },

    computed: {
      userError(){
        return this.$store.getters.getUserError;
      },

      /*userUrl(){
        return this.$store.getters.getUrl;
      },*/
      
      user(){
        return this.$store.getters.getUser;
      }
    },

    watch: {
      'userError': function(){
        if( this.userError != '' ){
          /*alert(this.userError);*/
          this.password = "";
          this.email = "";
          $.notify({
                    icon: 'fa fa-check',
                    title: ' Notificación',
                    message: this.userError,
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

      /*'userUrl': function(){
        if( this.userUrl != '' ){
          this.$router.push(this.userUrl);
        }
      },*/
      
      'user': function(){
        if( this.user != null ){
            this.$router.push('/home');
        }
      }
    },

  }
</script>
