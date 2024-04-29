three proyecto

proyecto_gestion_tickets/
│
├── config/
│ └── database.php # Configuración de la base de datos
│
├── controllers/
│ ├── AuthController.php # Controlador para la autenticación
│ ├── TicketController.php # Controlador para la gestión de tickets
│ └── CommentController.php # Controlador para la gestión de comentarios
│
├── models/
│ ├── User.php # Modelo para la gestión de usuarios
│ ├── Ticket.php # Modelo para la gestión de tickets
│ └── Comment.php # Modelo para la gestión de comentarios
│
├── views/
│ ├── auth/
│ │ ├── login.php # Vista para el formulario de inicio de sesión
│ │ └── register.php # Vista para el formulario de registro
│ ├── ticket/
│ │ ├── create.php # Vista para el formulario de creación de tickets
│ │ ├── index.php # Vista para la lista de tickets
│ │ └── show.php # Vista para ver detalles de un ticket
│ └── layout/
│ └── main.php # Vista principal que incluye encabezado y pie de página
│
└── public/
├── css/
├── js/
└── index.php # Punto de entrada de la aplicación
