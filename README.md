# PruebaTecnica

## Instrucciones para instalar y configurar el proyecto e iniciar el backend y frontend

Requisitos previos

- PHP version 8.2 o superior
- Composer version 2.8.4 https://getcomposer.org/download/
- Node.js version 18.15 o superior
- npm

Configurar backend
 1. Abrir la consola
 2. "cd backend" => Navegar a la carpeta backend 
 3. "composer install" => Instalar las dependencias
 4. Duplicar el archivo .env.example y renombrar la copia a .env
 5. "php artisan migrate" => Ejecutar las migraciones
 6. "php artisan db:seed" => Poblar la base de datos
 7. "php artisan serve" => Iniciar el servidor
*El backend estará disponible

Configurar frontend
 1. Abrir la consola
 2. "cd frontend" => Navegar a la carpeta frontend
 3. "npm install" => Instalar las dependencias
 4. "npm run build" 
 5. "npm run preview" 
*El frontend estará disponible en http://localhost:4173

## Ejemplo de consulta a los endpoints RESTful
 - Listar los usuarios (paginado por defecto 20 itemsPerPage): http://localhost:8000/api/user
 - Ver estadisticas: http://localhost:8000/api/statistics
 - Listar con filtro por rol y paginacion: http://localhost:8000/api/user?role=manager&page=1&%20perPage=10
  
*Se implementaron los endpoint necesarios para un CRUD completo sobre los usuarios y se añadió un filtro por nombre de usuario
- Listar los usuarios con filtro por nombre: http://localhost:8000/api/user?name=Alejandro
- Mostrar un usuario por su id: http://localhost:8000/api/user/99
- Registrar un usuario: POST http://localhost:8000/api/user {"name": "nombre del usuario", "email": "usuario@gmail.com", "role": "manager"}
- Modificar un usuario: PUT http://localhost:8000/api/user/{id_usuario} {"campo": "valor"}
- Eliminar un usuario: DELETE http://localhost:8000/api/user/{id_usuario}
