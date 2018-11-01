<style lang="scss">
  
</style>

<template>
<div>
                   <header class="content__title">
                        <h1>Blogs</h1>

                        <div class="actions">
                            <router-link :to="{ name: 'blogcreate' }" role="button" class="btn btn-success btn--icon-text">
                                <i class="zmdi zmdi-file-plus"></i> Agregar Blog
                            </router-link>
                        </div>

                    </header>

                    <div class="card">
                        <div class="card-body">
                             <h4 class="card-title">Basic example</h4>
                        <h6 class="card-subtitle">DataTables is a plug-in for the jQuery Javascript library. It is a highly flexible tool, based upon the foundations of progressive enhancement, and will add advanced interaction controls to any HTML table.</h6>

                        <div class="table-responsive">
                            <table id="data_table" class="table table-hover mb3">
                                <thead class="thead-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Acción</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        </div>
                    </div>
</div>
</template>

<script>

    export default {
        data() {
            return {
                listblogs: {},
            }
        },

        components: {
        
        },

        created() {

        },

        mounted() {
             this.$store.dispatch( 'loadBlogs' );
        },

        methods: {
            filltable(blogs) {
                var page = this;
                $(document).ready(function() {
                    var table;
                    if ( $.fn.dataTable.isDataTable( '#data_table' ) ) {
                        table = $('#data_table').DataTable({
                            data: blogs,
                            "destroy": true,
                            "columnDefs": [ {
                                "targets": -1,
                                "data": null,
                                "render": function ( data, type, full, meta ) {
                                    return '<a href="#/blogs/'+data[0]+'" class="btn btn-light btn--icon btn-sm" title="Editar Blog"><i class="actions__item zmdi zmdi-border-color"></i></a> <button type="button" date="'+data[0]+'" class="btn btn-light btn--icon btn-sm btn-del" title="Eliminar Blog"><i class="actions__item zmdi zmdi-delete"></i></button>';
                                }
                            } ]
                        });
                        /*$('#data_table tbody').on( 'click', 'button', function () {
                            var data = table.row( $(this).parents('tr') ).data();

                            if(data[0] == $(this).attr('date')){
                                page.delBlog(data[0]);
                            }
                        });*/
                        $('.btn-del').on( 'click', function () {
                            var data = table.row( $(this).parents('tr') ).data();
                            if(data[0] == $(this).attr('date')){
                                page.delBlog(data[0]);
                            }
                        });
                    }
                    else {
                        table = $('#data_table').DataTable({
                            data: blogs,
                            "destroy": true,
                            "columnDefs": [ {
                                "targets": -1,
                                "data": null,
                                "render": function ( data, type, full, meta ) {
                                    return '<a href="#/blogs/'+data[0]+'" class="btn btn-light btn--icon btn-sm" title="Editar Blog"><i class="actions__item zmdi zmdi-border-color"></i></a> <button type="button" date="'+data[0]+'" class="btn btn-light btn--icon btn-sm btn-del" title="Eliminar Blog"><i class="actions__item zmdi zmdi-delete"></i></button>';
                                }
                            } ]
                        });
                        /*$('#data_table tbody').on( 'click', 'button', function () {
                            var data = table.row( $(this).parents('tr') ).data();

                            if(data[0] == $(this).attr('date')){
                                page.delBlog(data[0]);
                            }
                        });*/
                        $('.btn-del').on( 'click', function () {
                            var data = table.row( $(this).parents('tr') ).data();
                            if(data[0] == $(this).attr('date')){
                                page.delBlog(data[0]);
                            }
                        });
                    }
                });
            } ,
            delBlog(id) {
                if(confirm('Esta seguro que desea eliminar el BLOG?'))
                {
                    this.$store.dispatch('deleteBlog', {id: id});
                    $.notify({
                    icon: 'fa fa-check',
                    title: ' Notificación',
                    message: 'Blog Eliminado',
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
            }
        },

        computed: {
            blogs(){
                return this.$store.getters.getBlogs;
            },
        },

        watch: {
            'blogs': function() {
                this.listblogs = this.blogs;
                this.filltable(this.blogs);
            }
        },

  }
</script>
