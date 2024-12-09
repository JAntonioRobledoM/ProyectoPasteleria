"use strict";

// Obtener el carrito desde localStorage o inicializarlo si no existe
let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
let total = 0;

// Función para agregar productos al carrito
function agregarAlCarrito(nombre, precio) {
    // Buscar si el producto ya existe en el carrito
    let productoExistente = carrito.find(item => item.nombre === nombre);

    if (productoExistente) {
        productoExistente.cantidad++;
    } else {
        carrito.push({ nombre, precio, cantidad: 1 });
    }

    actualizarCarrito();
}

// Función para quitar productos del carrito (quitar solo una unidad)
function quitarDelCarrito(nombre) {
    let productoExistente = carrito.find(item => item.nombre === nombre);

    if (productoExistente && productoExistente.cantidad > 1) {
        productoExistente.cantidad--;
    } else {
        // Si la cantidad es 1, eliminar el producto del carrito
        carrito = carrito.filter(item => item.nombre !== nombre);
    }

    actualizarCarrito();
}

// Función para actualizar el carrito en la página y en localStorage
function actualizarCarrito() {
    // Actualizar el listado del carrito en la interfaz
    const carritoElement = document.getElementById('carrito');
    carritoElement.innerHTML = ''; // Limpiar la lista antes de actualizar

    total = 0;
    carrito.forEach(item => {
        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.innerHTML = `${item.nombre} - €${item.precio} x ${item.cantidad} 
                        <button class="btn btn-danger btn-sm" onclick="quitarDelCarrito('${item.nombre}')">Quitar</button>`;
        carritoElement.appendChild(li);

        total += item.precio * item.cantidad;
    });

    // Actualizar el total
    document.getElementById('total').textContent = total.toFixed(2);

    // Guardar el carrito actualizado en localStorage
    localStorage.setItem('carrito', JSON.stringify(carrito));
}
