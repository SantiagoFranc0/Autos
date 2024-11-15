"use strict"

// URL base de la API
const BASE_URL = "api/"; // Ajusta esta URL según sea necesario

// Arreglo de autos y marcas
let autos = [];
let marcas = [];

// Event listener para agregar un auto
let form = document.querySelector("#auto-form");
form.addEventListener('submit', insertAuto);

// Event listener para agregar una marca
let formMarca = document.querySelector("#marca-form");
formMarca.addEventListener('submit', insertMarca);

// Obtener todos los autos y marcas
async function getAll() {
    try {
        const responseAutos = await fetch(BASE_URL + "autos");
        if (!responseAutos.ok) {
            throw new Error('Error al obtener los autos');
        }

        autos = await responseAutos.json();

        const responseMarcas = await fetch(BASE_URL + "marcas");
        if (!responseMarcas.ok) {
            throw new Error('Error al obtener las marcas');
        }

        marcas = await responseMarcas.json();

        showAutos();
        showMarcas();
    } catch (error) {
        console.log(error);
    }
}

// Insertar un auto (agregar auto)
async function insertAuto(e) {
    e.preventDefault();

    let data = new FormData(form);
    let auto = {
        nombre_modelo: data.get('nombre_modelo'),
        anio: data.get('anio'),
        color: data.get('color'),
        id_marca: data.get('id_marca'),
    };

    try {
        let response = await fetch(BASE_URL + "autos", {
            method: "POST",
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(auto)
        });

        if (!response.ok) {
            throw new Error('Error al agregar el auto');
        }

        let nAuto = await response.json();

        // Insertar el nuevo auto en el arreglo
        autos.push(nAuto);
        showAutos();

        form.reset();
    } catch (e) {
        console.log(e);
    }
}

// Insertar una marca (agregar marca)
async function insertMarca(e) {
    e.preventDefault();

    let data = new FormData(formMarca);
    let marca = {
        nombre: data.get('nombre'),
    };

    try {
        let response = await fetch(BASE_URL + "marcas", {
            method: "POST",
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(marca)
        });

        if (!response.ok) {
            throw new Error('Error al agregar la marca');
        }

        let nMarca = await response.json();

        // Insertar la nueva marca en el arreglo
        marcas.push(nMarca);
        showMarcas();

        formMarca.reset();
    } catch (e) {
        console.log(e);
    }
}

// Eliminar un auto
async function deleteAuto(e) {
    e.preventDefault();

    try {
        let id = e.target.dataset.auto;
        let response = await fetch(BASE_URL + 'autos/' + id, { method: 'DELETE' });

        if (!response.ok) {
            throw new Error('Recurso no existe');
        }

        // Eliminar el auto del arreglo global
        autos = autos.filter(auto => auto.id != id);
        showAutos();
    } catch (e) {
        console.log(e);
    }
}

// Editar un auto (finalizar auto puede ser un ejemplo similar a editar)
async function editAuto(e) {
    e.preventDefault();

    let id = e.target.dataset.auto;
    let data = new FormData(form);
    let updatedAuto = {
        nombre_modelo: data.get('nombre_modelo'),
        anio: data.get('anio'),
        color: data.get('color'),
        id_marca: data.get('id_marca'),
    };

    try {
        let response = await fetch(BASE_URL + "autos/" + id, {
            method: "PUT",
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(updatedAuto)
        });

        if (!response.ok) {
            throw new Error('Error al editar el auto');
        }

        // Actualizar el auto en el arreglo global
        const updatedTask = await response.json();
        autos = autos.map(auto => auto.id === id ? updatedTask : auto);
        showAutos();
    } catch (e) {
        console.log(e);
    }
}

/**
 * Renderiza la lista de autos
 */
function showAutos() {
    let ul = document.querySelector("#auto-list");
    ul.innerHTML = "";
    for (const auto of autos) {
        let html = `
            <li class='list-group-item d-flex justify-content-between align-items-center'>
                <span> <b>${auto.nombre_modelo}</b> - ${auto.anio} - ${auto.color} </span>
                <div class="ml-auto">
                    <a href='#' data-auto="${auto.id}" type='button' class='btn btn-small btn-warning btn-edit'>Editar</a>
                    <a href='#' data-auto="${auto.id}" type='button' class='btn btn-small btn-danger btn-delete'>Eliminar</a>
                </div>
            </li>
        `;

        ul.innerHTML += html;
    }

    // Asignar event listeners para los botones
    const btnsDelete = document.querySelectorAll('a.btn-delete');
    for (const btnDelete of btnsDelete) {
        btnDelete.addEventListener('click', deleteAuto);
    }

    const btnsEdit = document.querySelectorAll('a.btn-edit');
    for (const btnEdit of btnsEdit) {
        btnEdit.addEventListener('click', editAuto);
    }
}

/**
 * Renderiza la lista de marcas
 */
function showMarcas() {
    let select = document.querySelector("#marca-select");
    select.innerHTML = "<option value='' disabled selected>Seleccione una marca</option>";
    for (const marca of marcas) {
        let option = `
            <option value="${marca.id}">${marca.nombre}</option>
        `;
        select.innerHTML += option;
    }
}

// Obtener todos los autos y marcas al cargar la página
getAll();
