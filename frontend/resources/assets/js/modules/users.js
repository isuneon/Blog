import UserAPI from '../api/user.js';

export const users = {
  /*
    Defines the state being monitored for the module.
  */
	state: {
    	user: {},
      blogs: [],
      blog: {},
    	userLoadStatus: 0,
    	blogUpdateStatus: 0,
      blogCreateStatus: 0,
      loadLicencia: 0,
    	userError: '',
      blogError: '',
      isLoggedIn: !!localStorage.getItem("token")
  	},

  	actions: {
    	licencia( { commit } ){
          commit('setLoadLicencia' , 0);
          UserAPI.getLicencia(localStorage.getItem("token"))
          .then( function( response ){
              commit('setLoadLicencia' , response.data);
          })
          .catch( function(){
              commit('setLoadLicencia' , 0);
          });
      },

      loadUser( { commit } ){
      		commit( 'setUserLoadStatus', 1 );

      		UserAPI.getUser(localStorage.getItem("token"))
        	.then( function( response ){
          		commit( 'setUser', response.data );
          		commit( 'setUserLoadStatus', 2 );
        	})
        	.catch( function(){
          		commit( 'setUser', {} );
          		commit( 'setUserLoadStatus', 3 );
        	});
    	},

      loadToken( { commit } ){
          commit('logoutUser');
          if(localStorage.getItem("token"))
              commit('loginUser')
          else
              commit('logoutUser');
      },

      changeDB( { commit } ){
          UserAPI.getUserDB(localStorage.getItem("token"))
          .then( function( response ){
              
          })
          .catch( function(){

          });
      },

      loadBlogs( { commit } ){
          UserAPI.getBlogs(localStorage.getItem("token"))
          .then( function( response ){
              commit( 'setBlogs', response.data );
          })
          .catch( function(err){
              commit( 'setBlogs', [] );
          });
      },

      loadBlog( { commit }, data ){
          UserAPI.getBlog(localStorage.getItem("token"), data.id)
          .then( function( response ){
              commit( 'setBlog', response.data );
          })
          .catch( function(){
              commit( 'setBlog', '');
          });
      },

      updateBlog( { commit }, data ){
        commit( 'setBlogUpdateStatus', 0);
        UserAPI.updateBlog( data.nombre, data.descripcion, data.id, localStorage.getItem("token") )
        .then( function( response ){
          commit( 'setBlogUpdateStatus', 1 );
        })
        .catch( function(err){
            commit( 'setBlogError', err.response.data.errors);
            commit( 'setBlogUpdateStatus', 0 );
        });
      },

      deleteBlog( { commit, state, dispatch }, data ){

        UserAPI.deleteBlog( data.id, localStorage.getItem("token") )
        .then( function( response ){
          dispatch( 'loadBlogs');
        })
        .catch( function(err){
            commit( 'setBlogError', err.response.data.errors);
        });
      },

      createBlog( { commit }, data ){
        commit( 'setBlogCreateStatus', 0 );
        UserAPI.createBlog( data.nombre, data.descripcion, localStorage.getItem("token") )
        .then( function( response ){
          commit( 'setBlogCreateStatus', 1 );
        })
        .catch( function(err){
            commit( 'setBlogError', err.response.data.errors);
            commit( 'setBlogCreateStatus', 0 );
        });
      },

      logoutUser( { commit } ){
        commit( 'setUserLoadStatus', 0 );
        commit( 'setUser', {} );
        localStorage.removeItem('token');
        commit('logoutUser');
      },

      login( { commit }, data ){
        commit( 'setUserLoadStatus', 1 );
        commit( 'setUserError', '' );

        UserAPI.login( data.email, data.password, data.remember_me )
        .then( function( response ){
          commit('loginUser');
          localStorage.setItem('token', response.data.token);
          commit( 'setUser', response.data );
          commit( 'setUserLoadStatus', 2 );
          commit( 'setUserError', '' );
        })
        .catch( function(err){
          commit( 'setUser', null );
          commit( 'setUserLoadStatus', 3 );
          if(err.response.status === 401)
            commit( 'setUserError', 'Usuario y/o Contraseña incorrectos' );
          else
          if(err.response.status === 500)
            commit( 'setUserError', 'Usuario inactivo comuníquese con soporte' );
          else {
            if(err.response.data.errors.email)
              commit( 'setUserError', err.response.data.errors.email );
            else
            if(err.response.data.errors.password)
              commit( 'setUserError', err.response.data.errors.password );
          }
        });
      },

	},

	mutations: {

      loginUser (state) {
          state.isLoggedIn = true;
      },

      logoutUser (state) {
          state.isLoggedIn = false;
      },

    	setUserLoadStatus( state, status ){
      		state.userLoadStatus = status;
    	},

    	setUser( state, user ){
      		state.user = user;
    	},

      setBlogs(state, status) {
        state.blogs = status;
      },

      setBlog( state, blog ){
          state.blog = blog;
      },

    	setBlogUpdateStatus( state, status ){
      		state.blogUpdateStatus = status;
    	},

      setBlogError(state, status) {
          state.blogError = status;
      },

      setBlogCreateStatus( state, status ){
          state.blogCreateStatus = status;
      },

    	setUserError(state, status) {
      		state.userError = status;
    	},

      setLoadLicencia(state, status) {
          state.loadLicencia = status;
      },

  	},

  	getters: {

      getIsLoggedIn( state ){
        return function(){
          return state.isLoggedIn;
        }
      },

    	getUserLoadStatus( state ){
       		return state.userLoadStatus;
    	},

    	getUser( state ){
      		return state.user;
    	},

      getBlogs(state) {
        return state.blogs;
      },

      getBlog( state ){
          return state.blog;
      },

    	getBlogUpdateStatus( state, status ){
      		return state.blogUpdateStatus;
    	},

      getBlogError( state ){
          return state.blogError;
      },

      getBlogCreateStatus( state, status ){
          return state.blogCreateStatus;
      },

    	getUserError( state ){
      		return state.userError;
    	},

      getLoadLicencia( state ){
          return state.loadLicencia;
      },

  	}

}
