<?php
class producto
{
    //Atributo para conexión a SGBD
    private $pdo;
    //Atributos del objeto producto
    public $idproducto;
    public $nit;
    public $nomprod;
    public $precioU;
    public $descrip;
    //Método de conexión a SGBD.
    public function __CONSTRUCT()
    {
        try {
            $this->pdo = Database::Conectar();
        } catch(Exception $e) {
            die($e->getMessage());
        }
    }
    public function Listar(){
        try{
            $result = array();
             //Sentencia SQL para selección de datos.
            $stm = $this->pdo->prepare("SELECT * FROM producto");
             //Ejecución de la sentencia SQL.
            $stm->execute();
            //fetchAll — Devuelve un array que contiene todas las filas del conjunto
            //de resultados
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
        catch(Exception $e){
             //Obtener mensaje de error.
            die($e->getMessage());
        }
    }

    //Este método obtiene los datos del producto a partir del nit
    //utilizando SQL.
    public function Obtener($nit)
        {
        try
        {
        //Sentencia SQL para selección de datos utilizando
        //la cláusula Where para especificar el nit del producto.
        $stm = $this->pdo->prepare("SELECT * FROM producto WHERE idproducto = ?");
        //Ejecución de la sentencia SQL utilizando el parámetro nit.
        $stm->execute(array($nit));
        return $stm->fetch(PDO::FETCH_OBJ);
        } catch (Exception $e)
        {
        die($e->getMessage());
        }
    }
    //Este método elimina la tupla producto dado un nit.
    public function Eliminar($nit)
        {
        try
        {
        //Sentencia SQL para eliminar una tupla utilizando
        //la cláusula Where.
        $stm = $this->pdo->prepare("DELETE FROM producto WHERE idproducto = ?");
        $stm->execute(array($nit));
        } catch (Exception $e)
        {
        die($e->getMessage());
        }
    }

    //Método que actualiza una tupla a partir de la cláusula
    //Where y el nit del producto.
    public function Actualizar($prod)
        {
        try
        {
        //Sentencia SQL para actualizar los datos.
        $sql = "UPDATE producto SET
            idproducto = ?,
            nit = ?,
            nomprod = ?,
            precioU = ?,
            descrip = ?
            WHERE idproducto = ?";
        //Ejecución de la sentencia a partir de un arreglo.
        $this->pdo->prepare($sql)
        ->execute(
        array(
        $prod->idproducto,
        $prod->nit,
        $prod->nomprod,
        $prod->precioU,
        $prod->descrip
        )
        );
        } catch (Exception $e)
        {
        die($e->getMessage());
        }
    }
    //Método que registra un nuevo producto a la tabla.
    public function Registrar(producto $prod)
        {
        try
        {
        //Sentencia SQL.
        $sql = "INSERT INTO producto (idproducto,nit,nomprod,preioU,descrip)
        VALUES (?, ?, ?, ?)";
        $this->pdo->prepare($sql)
        ->execute(
            array(
                $prod->idproducto,
                $prod->nit,
                $prod->nomprod,
                $prod->precioU,
                $prod->descrip
                )
        );
        } catch (Exception $e)
        {
        die($e->getMessage());
        }
    }


}