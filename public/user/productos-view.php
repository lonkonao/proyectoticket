<?php
date_default_timezone_set('America/Santiago');
if (isset($_SESSION['nombre']) && isset($_SESSION['tipo'])) {


    if (isset($_POST['fecha_ticket']) && isset($_POST['name_ticket']) && isset($_POST['email_ticket'])) {

        /*Este codigo nos servira para generar un numero diferente para cada ticket*/
        $codigo = "";
        $longitud = 2;
        for ($i = 1; $i <= $longitud; $i++) {
            $numero = rand(0, 9);
            $codigo .= $numero;
        }
        $num = Mysql::consulta("SELECT id FROM ticket");
        $numero_filas = mysqli_num_rows($num);

        $numero_filas_total = $numero_filas + 1;
        $id_ticket = "IN" . $codigo . "N" . $numero_filas_total;
        /*Fin codigo numero de ticket*/

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Verifica si se seleccionó al menos un producto
            if (isset($_POST['producto_ticket']) && !empty($_POST['producto_ticket'])) {
                // Recoge los datos del formulario
                $productos = $_POST['producto_ticket'];

                // Resto del código...
            } else {
                echo "No se seleccionó ningún producto.";
            }
        }


        $fecha_ticket = MysqlQuery::RequestPost('fecha_ticket');
        $nombre_ticket = MysqlQuery::RequestPost('name_ticket');
        $email_ticket = MysqlQuery::RequestPost('email_ticket');
        $departamento_ticket = MysqlQuery::RequestPost('departamento_ticket');
        $asunto_ticket = "Solicitud Insumos";
        $producto_ticket = isset($_POST['producto_ticket']) ? $_POST['producto_ticket'] : [];
        $mensaje_ticket = ""; // Inicializamos el mensaje

        // Verifica si se seleccionó al menos un producto
        if (isset($_POST['producto_ticket']) && !empty($_POST['producto_ticket'])) {
            // Recoge los productos seleccionados
            $producto_ticket = $_POST['producto_ticket'];
            // Recorre los productos seleccionados
            // Inicializa la variable $nombres_producto
            $nombres_producto = [];

            // Recorre los productos seleccionados
            foreach ($producto_ticket as $producto_id) {
                // Busca el nombre del producto en la base de datos
                $producto_nombre = Mysql::consulta("SELECT nombre FROM producto WHERE id_producto = '$producto_id'");
                // Verifica si se encontró el producto
                if ($producto_nombre && mysqli_num_rows($producto_nombre) > 0) {
                    // Obtiene el nombre del producto
                    $nombre = mysqli_fetch_assoc($producto_nombre)['nombre'];
                    // Agrega el nombre del producto al array $nombres_producto
                    $nombres_producto[] = $nombre;
                }
            }
            // Actualiza el stock de productos seleccionados
            foreach ($producto_ticket as $producto_id) {
                // Actualiza el stock del producto restando 1
                $condicion = "id_producto = '$producto_id'";
                $campos = "stock = stock - 1";
                if (!MysqlQuery::Actualizar("producto", $campos, $condicion)) {
                    // Manejo de errores si la actualización falla
                    die("Error al actualizar el stock del producto");
                }
            }

            // Convierte el array de nombres de productos en una cadena
            $productosCadena = implode(", ", $nombres_producto);
            // Agrega la cadena de productos al mensaje
            $mensaje_ticket = "Productos seleccionados: " . $productosCadena;

            // Convierte el array de productos en una cadena
            $productosCadena = implode(", ", $nombres_producto);
            // Agrega la cadena de productos al mensaje
            $mensaje_ticket = $productosCadena;
        }

        // Si hay un mensaje adicional, agrégalo al mensaje del ticket
        if (!empty($_POST['mensaje_ticket'])) {
            $mensajeAdicional = MysqlQuery::RequestPost('mensaje_ticket');
            $mensaje_ticket .= "Mensaje adicional: " . $mensajeAdicional . "\n";
        }

        $estado_ticket = "Pendiente";
        $cabecera = "From: Depto Informatica <informatica@mdonihue.cl>";
        $mensaje_mail = "¡Gracias por reportarnos su problema! Buscaremos una solución para su producto lo mas pronto posible. Su ID ticket es: " . $id_ticket;
        $mensaje_mail = wordwrap($mensaje_mail, 70, "\r\n");


        if (MysqlQuery::Guardar("ticket", "fecha,nombre_usuario,email_cliente,departamento,asunto,mensaje,estado_ticket,serie,solucion", "'$fecha_ticket','$nombre_ticket','$email_ticket','$departamento_ticket','$asunto_ticket','$mensaje_ticket', '$estado_ticket','$id_ticket',''")) {

            /*----------  Enviar correo con los datos del ticket
            mail($email_ticket, $asunto_ticket, $mensaje_mail, $cabecera)
            ----------*/

            echo '
                <div class="alert alert-info alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="text-center">TICKET CREADO</h4>
                    <p class="text-center">
                        Ticket creado con exito ' . $_SESSION['nombre'] . '<br>El TICKET ID es: <strong>' . $id_ticket . '</strong>
                    </p>
                </div>
            ';
        } else {
            echo '
                <div class="alert alert-danger alert-dismissible fade in col-sm-3 animated bounceInDown" role="alert" style="position:fixed; top:70px; right:10px; z-index:10;"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <h4 class="text-center">OCURRIÓ UN ERROR</h4>
                    <p class="text-center">
                        No hemos podido crear el ticket. Por favor intente nuevamente.
                    </p>
                </div>
            ';
        }
    }
?>
    <div class="container">
        <div class="row well">
            <div class="col-sm-3">
                <img src="img/insumos.png" class="img-responsive" alt="Image">
            </div>
            <div class="col-sm-9 lead">
                <h2 class="text-info">¿Cómo Solicitar un Producto?</h2>
                <p>Para solicitar un producto, complete todos los campos del siguiente formulario.</p>
            </div>

        </div><!--fin row 1-->

        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title text-center"><strong><i class="fa fa-ticket"></i>&nbsp;&nbsp;&nbsp;Produtos</strong></h3>
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-4 text-center">
                                <br><br><br>
                                <img src="img/solicitud.png" alt="" style="width:50%"><br><br>
                                <p class="text-primary text-justify">Por favor llene todos los datos de este formulario para solicitar su producto. </p>
                            </div>
                            <div class="col-sm-8">
                                <form class="form-horizontal" role="form" action="" method="POST" onsubmit="guardarProductos()">
                                    <fieldset>
                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Fecha</label>
                                            <div class='col-sm-10'>
                                                <div class="input-group">
                                                    <input class="form-control" type="date" id="fechainput" placeholder="Fecha" name="fecha_ticket" required="" readonly value="<?php echo date('Y-m-d'); ?>">
                                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Nombre</label>
                                            <div class="col-sm-10">
                                                <div class='input-group'>
                                                    <input type="text" class="form-control" placeholder="Nombre" required="" pattern="[a-zA-Z ]{1,30}" name="name_ticket" title="Nombre Apellido" value="<?php echo $_SESSION['nombre_completo']; ?>">
                                                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                                            <div class="col-sm-10">
                                                <div class='input-group'>
                                                    <input type="email" class="form-control" id="inputEmail3" placeholder="Email" name="email_ticket" required="" title="Ejemplo@dominio.com" value="<?php echo $_SESSION['email']; ?>">
                                                    <span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Departamento</label>
                                            <div class="col-sm-10">
                                                <div class='input-group'>
                                                    <select class="form-control" name="departamento_ticket">
                                                        <option value="OMIL">OMIL</option>
                                                        <option value="FINANZAS">FINANZAS</option>
                                                        <option value="SECRETARIA">SECRETARÍA</option>
                                                    </select>
                                                    <span class="input-group-addon"><i class="fa fa-users"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Insumos</label>
                                            <div class="col-sm-10">
                                                <div class='input-group'>
                                                    <select class="form-control" name="producto_ticket[]" multiple>
                                                        <?php
                                                        $productos = Mysql::consulta("SELECT * FROM producto WHERE stock > 1");
                                                        while ($row = mysqli_fetch_array($productos)) {
                                                            echo '<option value="' . $row['id_producto'] . '">' . $row['nombre'] . " - Stock = " . $row['stock'] . '.-</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                    <span class="input-group-addon"><i class="fa fa-paperclip"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="submit" class="btn btn-info">Enviar Solicitud</button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
    require('lib/fpdf/fpdf.php');

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Recoge los datos del formulario
        $fecha = $_POST['fecha_ticket'];
        $nombre = $_POST['name_ticket'];

        // Crea una nueva instancia de PDF
        $pdf = new FPDF();
        $pdf->AddPage();

        // Define el contenido del PDF
        $pdf->SetFont('Arial', 'B', 16);
        $pdf->Cell(40, 10, "Fecha: $fecha");
        $pdf->Ln();
        $pdf->Cell(40, 10, "Nombre: $nombre");

        // Cierra y genera el PDF
        $pdf->Output();
    }
    ?>
<?php
} else {
?>
    <div class="container">
        <div class="row">
            <div class="col-sm-4">
                <img src="./img/logoInformatica.png" alt="Image" class="img-responsive" />
            </div>
            <div class="col-sm-7 text-center">
                <h1 class="text-danger">Lo sentimos esta página es solamente para usuarios registrados</h1>
                <h3 class="text-info">Inicia sesión para poder acceder</h3>
            </div>
            <div class="col-sm-1">&nbsp;</div>
        </div>
    </div>
<?php
}
?>

<script>
    function guardarProductos(event) {
        // Evita que el formulario se envíe automáticamente
        event.preventDefault();

        // Selecciona el elemento select
        var selectElement = document.getElementById("productos");
        // Obtiene todos los productos seleccionados
        var productosSeleccionados = [];
        for (var i = 0; i < selectElement.options.length; i++) {
            var option = selectElement.options[i];
            if (option.selected) {
                productosSeleccionados.push(option.text);
            }
        }
        // Une los productos en una sola cadena
        var productosCadena = productosSeleccionados.join(", ");
        // Agrega la cadena de productos como un campo oculto al formulario
        var productosInput = document.createElement("input");
        productosInput.type = "hidden";
        productosInput.name = "productos_seleccionados";
        productosInput.value = productosCadena;
        document.querySelector("form").appendChild(productosInput);

        // Envía el formulario
        this.submit();
    }
</script>