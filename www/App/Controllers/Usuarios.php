<?php

use App\Core\Controller;

class Usuarios extends Controller{

    /**
     * index function
     *
     * @return void
     */
    public function index(){

        $usuarioModel = $this->model("Usuario");

        $usuarios = $usuarioModel->listarTodos();

        echo json_encode($usuarios, JSON_UNESCAPED_UNICODE);
    }

    /**
     * store function
     *
     * @return void
     */
    public function store(){

        $nuevoUsuario = $this->getRequestBody();

        $usuarioModel = $this->model("Usuario");
        $usuarioModel->nombre = $nuevoUsuario->nombre;
        $usuarioModel->apellido = $nuevoUsuario->apellido;
        $usuarioModel->edad = $nuevoUsuario->edad;
        $usuarioModel->foto = $nuevoUsuario->foto;
        $usuarioModel->tipoDocumento = $nuevoUsuario->tipo_documento;
        $usuarioModel->rolId = $nuevoUsuario->rol;       

        $usuarioModel = $usuarioModel->insertar();

        if ($usuarioModel) {
            http_response_code(201);
            echo json_encode($usuarioModel);
        } else {
            http_response_code(500);
            echo json_encode(["erro" => "Problema al insertar usuario"]);
        }

    }

    /**
     * delete function
     *
     * @param [type] $id
     * @return
     */
    public function delete($id) {

        $usuarioModel = $this->model("Usuario");

        $usuarioModel = $usuarioModel->buscarPorId($id);

        if (!$usuarioModel) {
            http_response_code(404);
            echo json_encode(["erro" => "usuario no encontrado"]);
            exit;
        }        
        $usuarioModel->eliminar($id);

        echo json_encode($usuarioModel, JSON_UNESCAPED_UNICODE);
    }

     /**
     * update function
     *
     * @param [type] $id
     * @return
     */
    public function update($id) {
        $dataUpdateUsuario = $this->getRequestBody();

        $usuarioModel = $this->model("Usuario");
        

        $usuarioModel = $usuarioModel->buscarPorId($id);

        if (!$usuarioModel) {
            http_response_code(404);
            echo json_encode(["erro" => "usuario no encontrado"]);
            exit;
        }        
        $usuarioModel->actualizar($id,$dataUpdateUsuario);

        echo json_encode($usuarioModel, JSON_UNESCAPED_UNICODE);
    }


}