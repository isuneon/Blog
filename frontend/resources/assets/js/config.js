var api_url = '';

switch( process.env.NODE_ENV ){
  case 'development':
    api_url = 'http://backend.com/api/'; /* sustituir backend.com por el IP o NOMBRE del servicio web */
  break;
  case 'production':
    api_url = 'http://backend.com/api/'; /* sustituir backend.com por el IP o NOMBRE del servicio web */
  break;
}

export const ROAST_CONFIG = {
  API_URL: api_url,
}