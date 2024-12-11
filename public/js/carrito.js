document.addEventListener('DOMContentLoaded', () => {
    const carritoLista = document.getElementById('carrito-lista');
    const btnRealizarPedido = document.getElementById('btn-realizar-pedido');

    // Manejar el clic en "Añadir al carrito"
    document.querySelectorAll('.btn-añadir-carrito').forEach(button => {
        button.addEventListener('click', () => {
            const dulceId = button.dataset.id;
            const nombre = button.dataset.nombre;
            const precio = button.dataset.precio;

            // Crear un nuevo elemento en el carrito
            const item = document.createElement('li');
            item.classList.add('list-group-item');
            item.dataset.id = dulceId;

            item.innerHTML = `
                ${nombre} - ${precio}€
                <button class="btn btn-danger btn-sm float-end btn-quitar-carrito">Quitar</button>
            `;

            carritoLista.appendChild(item);

            // Actualizar mensaje si el carrito ya no está vacío
            const emptyMessage = carritoLista.querySelector('.list-group-item-empty');
            if (emptyMessage) {
                emptyMessage.remove();
            }

            // Agregar evento al botón de quitar
            item.querySelector('.btn-quitar-carrito').addEventListener('click', () => {
                item.remove();

                // Mostrar mensaje si el carrito está vacío
                if (!carritoLista.querySelector('li')) {
                    carritoLista.innerHTML = `<li class="list-group-item list-group-item-empty">El carrito está vacío.</li>`;
                }
            });
        });
    });

    // Manejar el clic en "Quitar del carrito" al inicio (si existen elementos precargados)
    carritoLista.addEventListener('click', (e) => {
        if (e.target.classList.contains('btn-quitar-carrito')) {
            e.target.closest('li').remove();

            // Mostrar mensaje si el carrito está vacío
            if (!carritoLista.querySelector('li')) {
                carritoLista.innerHTML = `<li class="list-group-item list-group-item-empty">El carrito está vacío.</li>`;
            }
        }
    });

    // Función para realizar el pedido (vaciar el carrito y mostrar un mensaje)
    function realizarPedido() {
        // Vaciar el carrito
        carritoLista.innerHTML = `<li class="list-group-item list-group-item-empty">El carrito está vacío.</li>`;

        // Mostrar el mensaje de que el pedido se está preparando
        alert("El pedido se está preparando");
    }

    // Asignar la función 'realizarPedido' al botón
    btnRealizarPedido.addEventListener('click', realizarPedido);
});
