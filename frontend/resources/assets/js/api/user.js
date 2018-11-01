import { ROAST_CONFIG } from '../config.js';

export default {

  getUser: function(tok){
      return axios.get( ROAST_CONFIG.API_URL + 'user?tok='+tok);
  },

  getUserDB: function(tok){
      return axios.get( ROAST_CONFIG.API_URL + 'userdb?tok='+tok);
  },

  getBlogs: function(tok){
    return axios.get( ROAST_CONFIG.API_URL + 'blogs?tok='+tok );
  },

  getBlog: function(tok,id){
    return axios.get( ROAST_CONFIG.API_URL + 'blogs/'+id+'?tok='+tok );
  },

  updateBlog: function( nombre, descripcion, id , tok){
    return axios.put( ROAST_CONFIG.API_URL + 'blogs/'+id,
      {
        nombre: nombre,
        descripcion: descripcion,
        tok: tok
      }
    );
  },

  deleteBlog: function(id, tok){
    return axios.post( ROAST_CONFIG.API_URL + 'blogs/del',
      {
        id: id,
        tok: tok
      });
  },

  createBlog: function( nombre, descripcion, tok){
    return axios.post( ROAST_CONFIG.API_URL + 'blogs/crear',
      {
        nombre: nombre,
        descripcion: descripcion,
        tok: tok
      }
    );
  },

  login: function(email,password,remember_me){
    return axios.post( ROAST_CONFIG.API_URL + 'logins',
        {
            email: email,
            password: password,
            remember_me: remember_me
        }
      );
  },

  getLicencia: function(tok){
      return axios.get( ROAST_CONFIG.API_URL + 'licencia?tok='+tok);
  },
  
}
