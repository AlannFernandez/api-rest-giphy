# Configuración para usar la colección de postman
Breve descripción de como configurar el entorno de postman para el uso de los endpoints de la api.

- **Creación del enviroment:** Debes crear un enviroment para almacenar las variables 
- **Creación de las variables:** Como primer paso debes crear 2 variables necesarias, la primera es `url` y debe contener la url donde se esta exponiendo la api (por defecto la url es http://localhost:8000). La segunda variable es `token` y se utilizara para almacenar el jwt que retorna la api en caso de el login sea existoso, este token es requerido para los servicios con autententicación y tiene una duración de 30 minutos.