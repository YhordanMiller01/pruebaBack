<?php

use App\Core\Model;

class Usuario{

    public $id;
    public $nombre;
    public $apellido;
    public $edad;
    public $foto;
    public $tipoDocumento;
    public $rolId;

    /**
     * listarTodos function permite listar todos los usuarios existentes
     *
     * @return void
     */
    public function listarTodos(){
        $sql = " SELECT * FROM usuario ORDER BY id DESC ";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $resultado = $stmt->fetchAll(PDO::FETCH_OBJ);

            return $resultado;
        } else {
            return [];
        }
    }

    /**
     * insertar function permite insertar un nuevo usuario
     *
     * @return void
     */
    public function insertar(){
        $sql = " INSERT INTO usuario (nombre, apellido, edad, foto,tipo_documento,rol) VALUES (?, ?, ?, ?, ?, ?) ";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $this->nombre);
        $stmt->bindValue(2, $this->apellido);
        $stmt->bindValue(3, $this->edad);
        $stmt->bindValue(4, $this->foto);
        $stmt->bindValue(5, $this->tipoDocumento);
        $stmt->bindValue(6, $this->rolId);

        if ($stmt->execute()) {
            $this->id = Model::getConn()->lastInsertId();
            return $this;
        } else {
            print_r($stmt->errorInfo());
            return null;
        }
    }

    /**
     * buscarPorId function permite buscar un usuario por su id
     *
     * @param [type] $id
     * @return void
     */
    public function buscarPorId($id){

        $sql = " SELECT * FROM usuario WHERE id = ? ";
        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $id);

        if ($stmt->execute()) {
            $registro = $stmt->fetch(PDO::FETCH_OBJ);

            if (!$registro) {
                return null;
            }

            $this->id = $registro->id;
            $this->nombre = $registro->nombre;
            $this->apellido = $registro->apellido;
            $this->edad = $registro->edad;
            $this->foto = $registro->foto;
            $this->tipoDocumento = $registro->tipo_documento;
            $this->rolId = $registro->rol;


            return $this;
        } else {
            return null;
        }
    }

    /**
     * actualizar function permite actualizar un usuario por su id
     *
     * @param [type] $id
     * @param [type] $data
     * @return void
     */
    public function actualizar($id,$data){

        $sql = " UPDATE usuario SET nombre = ?, apellido = ?,
        edad = ?,foto = ?,tipo_documento = ?,rol = ? WHERE id = ? ";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $data->nombre);
        $stmt->bindValue(2, $data->apellido);
        $stmt->bindValue(3, $data->edad);
        $stmt->bindValue(4, $data->foto);
        $stmt->bindValue(5, $data->tipo_documento);
        $stmt->bindValue(6, $data->rol);
        $stmt->bindValue(7, $id);

        return $stmt->execute();
    }


    /**
     * eliminar function permite eliminar un usuario por su id
     *
     * @param [type] $id
     * @return void
     */
    public function eliminar($id){
        
        $sql = " DELETE FROM usuario WHERE id = ?";

        $stmt = Model::getConn()->prepare($sql);
        $stmt->bindValue(1, $id);

        return $stmt->execute();
    }

}