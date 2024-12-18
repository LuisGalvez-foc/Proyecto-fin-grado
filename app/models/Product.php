<?php 
require_once __DIR__."/../../config/conexion.php";

class Product{
private $conn;

public function __construct(){
    global $conn;
    $this->conn=$conn;
}
public function añadir_producto($nombre,$descripcion,$precio,$cantidad,$id_categoria){
    $query="INSERT INTO productos (nombre,descripcion,precio,cantidad,id_categoria) VALUES (?,?,?,?,?)";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("ssdii",$nombre,$descripcion,$precio,$cantidad,$id_categoria);
    $stmt->execute();

}
public function eliminar_productos($nombre){
    $query="DELETE FROM productos WHERE nombre=?";
    $stmt=$this->conn->prepare($query);
    $stmt->bind_param("s",$nombre);
    $stmt->execute();
}
public function mostrar_produtos(){
    $query="SELECT * FROM productos";
    $stmt=$this->conn->prepare($query);
    $stmt->execute();
    $result=$stmt->get_result();
    return $result;
}







}