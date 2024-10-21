<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>

<body>
    <div class="container w-100 border border-3 border-primary rounded p-4 mt-5">

        <div class="col-md-12">
            <h1 class="text-center">CRUD AJAX</h1>
            <hr>
            <button type="button" class="btn btn-success" data-bs-toggle="modal"
                data-bs-target="#createProductModal">Agregar
                producto</button>

            <!-- Modal para crear un nuevo producto -->
            <div class="modal fade" id="createProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="createProductForm">
                                @csrf
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="nombre">Nombre del Producto</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre"
                                            required>
                                    </div>
                                    <div class="form-group">
                                        <label for="descripcion">Descripcion</label>
                                        <input type="text" class="form-control" id="descripcion" name="descripcion"
                                            required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Agregar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal para editar producto -->
            <div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editProductForm">
                                @csrf
                                @method('PUT')
                                <input type="hidden" id="editProductId" name="id">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="editNombre">Nombre del Producto</label>
                                        <input type="text" class="form-control" id="editNombre" name="nombre">
                                    </div>
                                    <div class="form-group">
                                        <label for="editDescripcion">Descripcion</label>
                                        <input type="text" class="form-control" id="editDescripcion"
                                            name="descripcion">
                                    </div>
                                    <!-- Puedes agregar más campos aquí -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


            <table class="table table-striped table-hover" id="productTable">
                <thead class="bg-primary text-center">
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @php
                        $cont = 0;
                    @endphp
                    @foreach ($productos as $producto)
                        <tr id="product-{{ $producto->id }}">
                            <td>{{ ++$cont }}</td>
                            <td>{{ $producto->nombre }}</td>
                            <td>{{ $producto->descripcion }}</td>
                            <td>
                                <button
                                    class="btn btn-primary"onclick="editProduct({{ $producto->id }}, '{{ $producto->nombre }}', '{{ $producto->descripcion }}')">Editar</button>
                                <button class="btn btn-danger"
                                    onclick="deleteProduct({{ $producto->id }})">Eliminar</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Script para crear el producto con AJAX -->
    <script>
        // Al enviar el formulario, prevenir el comportamiento por defecto y usar Ajax
        $('#createProductForm').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                url: '{{ route('crud.create') }}', // Ruta para crear producto
                type: 'POST',
                data: formData,
                success: function(response) {
                    // Mostrar mensaje de éxito con SweetAlert2
                    Swal.fire({
                        icon: 'success',
                        title: 'Producto creado',
                        text: 'El producto fue creado exitosamente'
                    });

                    // Cerrar el modal
                    $('#createProductModal').modal('hide');

                    // Limpiar el formulario
                    $('#createProductForm')[0].reset();

                    // Agregar el nuevo producto a la tabla
                    $('#productTable tbody').append(`
                        <tr id="product-${response.id}">
                            <td>${response.cont}</td>  <!-- Usar el contador de JavaScript -->
                            <td>${response.nombre}</td>
                            <td>${response.descripcion}</td>
                            <td>
                                <button class="btn btn-primary" onclick="editProduct(${response.id}, '${response.nombre}', '${response.descripcion}')">Editar</button>
                                <button class="btn btn-danger" onclick="deleteProduct(${response.id})">Eliminar</button>
                            </td>
                        </tr>
                    `);
                },
                error: function(xhr) {
                    console.log(xhr.responseText);
                    alert(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al crear el producto'
                    });
                }
            });
        });
    </script>

    <script>
        // Almacena el ID del producto actual para editar
        let currentProductId = null;

        // Editar Producto: Abre el modal con los datos del producto cargados
        function editProduct(id, nombre, descripcion) {
            currentProductId = id; // Almacena el ID del producto que se va a editar
            $('#editProductId').val(id);
            $('#editNombre').val(nombre);
            $('#editDescripcion').val(descripcion);
            $('#editProductModal').modal('show');
        }

        // Al enviar el formulario de editar, realizar una solicitud Ajax
        $('#editProductForm').submit(function(e) {
            e.preventDefault();
            let formData = $(this).serialize();

            $.ajax({
                /* /crud/update/${currentProductId} */
                //url: `{{ route('crud.update', ':id') }}`.replace(':id', currentProductId), // Ruta para actualizar el producto
                url: `/crud/update/${currentProductId}`,
                type: 'PUT',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Producto actualizado',
                        text: 'El producto fue actualizado exitosamente'
                    });

                    // Cerrar el modal
                    $('#editProductModal').modal('hide');

                    // Actualizar la fila en la tabla
                    $(`#product-${currentProductId} td:nth-child(2)`).text(response.nombre);
                    $(`#product-${currentProductId} td:nth-child(3)`).text(response.descripcion);
                },
                error: function(xhr) {
                    console.log(xhr);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Hubo un problema al actualizar el producto'
                    });
                }
            });
        });

        // Eliminar Producto
        function deleteProduct(id) {
            console.log(id);
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esta acción",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/crud/destroy/${id}`, // Ruta para eliminar el producto
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}' // Necesario para la protección CSRF
                        },
                        success: function(response) {
                            Swal.fire(
                                'Eliminado',
                                'El producto ha sido eliminado',
                                'success'
                            );

                            // Eliminar la fila de la tabla
                            $(`#product-${id}`).remove();
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Hubo un problema al eliminar el producto'
                            });
                        }
                    });
                }
            });
        }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
