<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light contenedorPrincipal">
  <div class="container-fluid">
    <a class="navbar-brand btn btn-bg-transparent text-primary fw-bold fst-italic p-3" href="<?php echo base_url('Main/index')?>">AUTENTICARSE</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle textDropDowns" href="#" id="navbarDropdownMenuLink " role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Iniciando Sesión
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#pasosIniciarSesionModal"> Como Iniciar Sesión</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#estadoModal">Estado de Cuenta</a></li>
          </ul>
        </li>
      </ul>
    </div>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle textDropDowns" href="#" id="navbarDropdownMenuLink " role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Operaciones con Empleados
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#crearEmpleadoModal">Crear Empleado</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editarEmpleadoModal">Editar Empleado</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#eliminarEmpleadoModal">Eliminar Empleado</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#actDsactEmpleadoModal">Activar / Desactivar</a></li>
          </ul>
        </li>
      </ul>
    </div>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle textDropDowns" href="#" id="navbarDropdownMenuLink " role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Operaciones con Productos
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#crearProductoModal">Crear Producto</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editarProductoModal">Editar Producto</a></li>
            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#actDsactProductoModal">Activar / Desactivar</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- Modal para Pasos para Iniciar Sesión -->
<div class="modal fade mx-auto" id="pasosIniciarSesionModal" tabindex="-1" aria-labelledby="pasosIniciarSesionModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pasosIniciarSesionModalLabel">Como Iniciar Sesión?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>1. Ingresa tu correo electrónico y tu contraseña.</p>
        <p>2. Haz clic en el botón "Entrar".</p>
        <p>3. Si los datos son correctos, serás redirigido a tu cuenta.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Estado -->
<div class="modal fade mx-auto" id="estadoModal" tabindex="-1" aria-labelledby="estadoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="estadoModalLabel">Estado de Cuenta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Tu estado de cuenta lo controla un Administrador y puede ser <span class="badge bg-success">Activo</span> o <span class="badge bg-danger">Inactivo</span>, si se encuentra activo podrás logearte y realizar las operaciones permitidas en tu cuenta, sino, no podrás realizar nada de lo mencionado anteriormente.  </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
 </div>
</div>

<!-- Modal para Pasos para CREAR un empleado -->
<div class="modal fade mx-auto" id="crearEmpleadoModal" tabindex="-1" aria-labelledby="crearEmpleadoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="crearEmpleadoModalLabel">Como Crear un Empleado?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>1. Tienes que tener role de ADMINISTRADOR.</p>
        <p>2. Entra en la sección <span class="text-primary fst-italic">Lista De Empleados</span></p>
        <p>3. Haz clic en el botón <button class="btn btn-success">Crear Empleado</button>.</p>
        <p>4. Complete los campos y presiona en <span class="btn btn-primary">Guardar</span></p>
        <p class="badge bg-warning fw-bold p-2 mt-4"><span class="text-black">IMPORTANTE</span></p>
        <p class="text-warning">No se pueden crear dos empleados con la misma dirección de correo.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Pasos para EDITAR un empleado -->
<div class="modal fade mx-auto" id="editarEmpleadoModal" tabindex="-1" aria-labelledby="editarEmpleadoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarEmpleadoModalLabel">Como Editar un Empleado?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>1. Tienes que tener role de ADMINISTRADOR.</p>
        <p>2. Entra en la sección <span class="text-primary fst-italic">Lista De Empleados</span></p>
        <p>3. Haz clic en el botón <button class="ms-1 me-1 btn btn-sm btn-warning"><span class="mdi mdi-account-edit-outline" title="Editar Empleado"></span></button>.</p>
        <p>4. Edita los datos que desees y presiona en <span class="btn btn-primary">Guardar</span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Pasos para ELIMINAR un empleado -->
<div class="modal fade mx-auto" id="eliminarEmpleadoModal" tabindex="-1" aria-labelledby="eliminarEmpleadoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="elimintarEmpleadoModalLabel">Como Eliminar un Empleado?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>1. Tienes que tener role de ADMINISTRADOR.</p>
        <p>2. Entra en la sección <span class="text-primary fst-italic">Lista De Empleados</span></p>
        <p>3. Haz clic en el botón <button class="ms-1 me-1 btn btn-sm btn-danger btn-delete-employee"><span class="mdi mdi-trash-can-outline" title="Eliminar Empleado"></span></button> del empleado al que deseas eliminar.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Pasos para ACTIVAR / DESACTIVAR un empleado -->
<div class="modal fade mx-auto" id="actDsactEmpleadoModal" tabindex="-1" aria-labelledby="actDsactEmpleadoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eactDsactEmpleadoModalLabel">Como Activar / Desactivar un Empleado?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>1. Tienes que tener role de ADMINISTRADOR.</p>
        <p>2. Entra en la sección <span class="text-primary fst-italic">Lista De Empleados</span></p>
        <p>3. Haz clic en el <span class="text-primary fst-italic">switch</span> a la derecha del empleado al que deseas Activar o Desactivar.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Pasos para CREAR un Producto -->
<div class="modal fade mx-auto" id="crearProductoModal" tabindex="-1" aria-labelledby="crearProductoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="crearProductoModalLabel">Como Crear un Producto?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>1. Tienes que tener role de ADMINISTRADOR.</p>
        <p>2. Entra en la sección <span class="text-primary fst-italic">Lista De Productos</span></p>
        <p>3. Haz clic en el botón <button class="btn btn-success">Crear Producto</button>.</p>
        <p>4. Complete los campos y presiona en <span class="btn btn-primary">Guardar</span></p>
        <p class="badge bg-warning fw-bold p-2 mt-4"><span class="text-black">IMPORTANTE</span></p>
        <p class="text-warning">No se pueden crear dos productos con el mismo nombre.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Pasos para EDITAR un Producto -->
<div class="modal fade mx-auto" id="editarProductoModal" tabindex="-1" aria-labelledby="editarProductoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarProductoModalLabel">Como Editar un Producto?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>1. Tienes que tener role de ADMINISTRADOR.</p>
        <p>2. Entra en la sección <span class="text-primary fst-italic">Lista De Productos</span></p>
        <p>3. Haz clic en el botón <button class="ms-1 me-1 btn btn-sm btn-warning"><span class="mdi mdi-pencil" title="Editar Producto"></span></button>.</p>
        <p>4. Edita los datos que desees y presiona en <span class="btn btn-primary">Guardar</span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Pasos para ACTIVAR / DESACTIVAR un Producto -->
<div class="modal fade mx-auto" id="actDsactProductoModal" tabindex="-1" aria-labelledby="actDsactProductoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="eactDsactProductoModalLabel">Como Activar / Desactivar un Producto?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>1. Tienes que tener role de ADMINISTRADOR.</p>
        <p>2. Entra en la sección <span class="text-primary fst-italic">Lista De Productos</span></p>
        <p>3. Haz clic en el <span class="text-primary fst-italic">switch</span> a la derecha del producto al que deseas Activar o Desactivar.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

</div>    
</body>
</html>

<style>

    .contenedorPrincipal{
        box-shadow: 0px 0px 10px black;
        border-radius: 10px;
        max-width: fit-content;
    }

    .textDropDowns{
        border-radius: 5px;
    }

    .textDropDowns:hover{
        background-color: #038edc;
        transition: 0.5s;
        border-radius: 5px;
        box-shadow: 2px 4px 8px #038edc;
        text-shadow: 1px 1px 7px white;
    }
</style>

<script>
  const textDropDowns = document.querySelector('.textDropDowns');

textDropDowns.addEventListener('mouseout', () => {
  textDropDowns.style.transition = '1s';
});
</script>