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
![Image](https://github.com/user-attachments/assets/b08c2713-4f71-4fcd-9e6e-d8b6f2eb1790)

![Image](https://github.com/user-attachments/assets/498b88bf-4d98-4994-831f-b8dd486dd097)

![Image](https://github.com/user-attachments/assets/c658d650-7dad-4b67-bcf6-985c00ab6a4f)

![Image](https://github.com/user-attachments/assets/8fef1f62-2b7e-4b62-94ae-65a4d36bd8a6)

---
💻 **Desarrollado por:** Julieta Laplace
