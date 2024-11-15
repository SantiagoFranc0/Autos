# Autos
Tercer entrega web2

Hice todos los puntos menos el de paginado, el resto esta todo 


Métodos para Obtener Información

. Obtener un auto por ID
   URL: http://localhost/Tp3/api/autos/{id}
   Método: GET

   Ejemplo de solicitud:
   GET http://localhost/Tp3/api/autos/1


. Obtener todos los autos
   URL: http://localhost/Tp3/api/autos
   Método: GET
   Parámetros de consulta:
     - orderBy: Ordenar por un campo específico (opcional)
     - ordenar: Orden de la consulta (ASC o DESC) (opcional)
     - anio: Filtrar autos por año (opcional)

   Ejemplo de solicitud:
   GET http://localhost/Tp3/api/autos?orderBy=color&ordenar=DESC&anio=2019


. Obtener todos los autos de una marca
   URL: http://localhost/Tp3/api/marcas/{id}
   Método: GET


   Ejemplo de solicitud:
   GET http://localhost/Tp3/api/marcas/1


. Obtener todas las marcas
   URL: http://localhost/Tp3/api/marcas
   Método: GET


Métodos para Agregar Información

. Agregar un auto
   URL: http://localhost/Tp3/api/autos
   Método: POST
   Entradas (Body):
   {
     "nombre_modelo": "Corolla",
     "anio": 2019,
     "color": "Negro",
     "id_marca": 1
   }

 

. Agregar una marca
   URL: http://localhost/Tp3/api/marcas
   Método: POST
   Entradas (Body):
   {
     "nombre": "Toyota",
     "lugar_fabricacion": "Japón"
   }


Métodos para Editar Información

. Editar un auto
   URL: http://localhost/Tp3/api/autos/{id}
   Método: PUT
   Entradas (Body):
   {
     "nombre_modelo": "Corolla",
     "anio": 2019,
     "color": "Negro",
     "id_marca": 1
   }

. Para registrarse 
http://localhost/Tp3/api/usuarios/token

creo que no falto ninguno, mi compañero dejo la carrera  lo termine haciendo solo mi dni es 45 035 256 
