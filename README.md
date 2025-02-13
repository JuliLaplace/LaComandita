# 🌟 La Comandita - Sistema de Gestión para Restaurantes

## 📖 Descripción
La Comandita es un sistema de gestión para restaurantes que permite administrar pedidos, mesas, empleados y reportes de ventas. Implementa un backend en **PHP con Slim v4** y una base de datos en **MySQL**, proporcionando una API RESTful segura.

## 🚀 Características Principales
- ✅ Gestión de pedidos con actualización de estados (**pendiente**, **en preparación**, **listo para servir**).
- ✅ Autenticación y roles (mozos, cocineros, socios).
- ✅ Administración de mesas y clientes con códigos únicos.
- ✅ Encuestas de satisfacción al finalizar el servicio.

## 🛠 Tecnologías Utilizadas
- **Backend:** PHP (Slim v4), MySQL, PDO
- **Herramientas:** Postman, Composer


## 📡 Endpoints de la API
Algunos de los principales endpoints:

```http
GET /listar_mesas   # Obtener listado de todas las mesas con sus respectivos estados (ocupada, libre, etc)
POST /auth/login          # Se agrega usuario y clave para loguear un usuario
PUT /empleados/modificar  # Actualizar los datos de un empleado específico
DELETE /productos/tiramisu  # Elimina el producto que se especifica por URL (tiramisú en este caso)
POST  //pedidos/pedido  # Se carga el detalle del pedido por medio del codigo que éste tiene, agregando el producto elegido y su cantidad.
```

## 🎨 Capturas de Pantalla (Opcional)


---
💻 **Desarrollado por:** Julieta Laplace
