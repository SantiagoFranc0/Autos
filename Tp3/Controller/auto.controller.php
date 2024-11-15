<?php
require_once 'Model/auto.model.php';
require_once 'View/json.view.php';

class AutoApiController
{
    private $model;
    private $view;

    public function __construct()
    {
        $this->model = new Auto_Model();
        $this->view = new JSONView();
    }

    public function listarModelos($req, $res)
    {
        $id_marca = $req->params->id;
        if ($id_marca) {
            $modelos = $this->model->getAutosPorMarca($id_marca);
            if ($modelos) {
                $this->view->response($modelos, 200);
            } else {
                $this->view->response("Modelos no encontrados para la marca especificada", 404);
            }
        } else {
            $this->view->response("ID de marca no especificado", 400);
        }
    }

    // GET /api/autos/:id
    public function mostrar_detalle_modelo($req, $res)
    {
        $id = $req->params->id;
        $detalle = $this->model->getAuto($id);
    
        if ($detalle) {

            $this->view->response($detalle, 200);
        } else {
            $this->view->response("Auto con ID=$id no encontrado", 404);
        }
    }
    
    // GET /api/marcas
    public function listarMarcas()
    {
       
        $marcas = $this->model->getMarcas();
  
        $this->view->response($marcas, 200);
    }
    // GET /api/autos
    public function listarTodosLosAutos($req, $res)
{
    $orderBy = isset($req->query->orderBy) ? $req->query->orderBy : null;
    $ordenar = isset($req->query->ordenar) ? $req->query->ordenar : 'ASC'; // Default to ASC if not set
    $anio = isset($req->query->anio) ? $req->query->anio : null;

    // Pasamos los valores al modelo
    $autos = $this->model->getTodosLosAutos($orderBy, $ordenar, $anio);

    if (empty($autos)) {
        return $this->view->response("No se encontraron autos", 404);
    }

    $this->view->response($autos, 200);
}

    
    // api/autos (POST)
    public function agregarAuto($req, $res)
    {

        if (empty($req->body->nombre_modelo) || empty($req->body->anio) || empty($req->body->color) || empty($req->body->id_marca)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        $nombre_modelo = $req->body->nombre_modelo;
        $anio = $req->body->anio;
        $color = $req->body->color;
        $id_marca = $req->body->id_marca;

        $auto = $this->model->agregarAuto($nombre_modelo, $anio, $color, $id_marca);

        if (!$auto) {
            return $this->view->response("Error al insertar auto", 500);
        }

        $nuevo = $this->model->getAuto($auto);
        return $this->view->response($nuevo, 201);
    }


    public function agregarMarca($req, $res)
    {


        if (empty($req->body->nombre) || empty($req->body->lugar_fabricacion)) {
            return $this->view->response('Faltan completar datos', 400);
        }

        $nombre = $req->body->nombre;
        $lugar_fabricacion = $req->body->lugar_fabricacion;

        $marca = $this->model->agregarMarca($nombre, $lugar_fabricacion);

        if (!$marca) {
            return $this->view->response("Error al insertar una marca", 500);
        }

        $nuevo = $this->model->getMarcaById($marca);
        return $this->view->response($nuevo, 201);
    }


    public function editarAuto($req, $res) {
        $id_modelo = $req->params->id;
    
        if (!$id_modelo || empty($id_modelo)) {
            return $this->view->response("El id seleccionado no existe, por favor ingrese un id válido", 404); 
        }
    
        if (empty($req->body->nombre_modelo) || empty($req->body->anio) || empty($req->body->color) || empty($req->body->id_marca)) {
            return $this->view->response('Faltan completar datos', 400);
        }
    
        $nombre_modelo = $req->body->nombre_modelo; 
        $anio = $req->body->anio;
        $color = $req->body->color; 
        $id_marca = $req->body->id_marca;
    
        $this->model->editarAuto($id_modelo, $nombre_modelo, $anio, $color, $id_marca);
        return $this->view->response("Auto editado con éxito", 202);
    }
    
}
