<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//nombre                        : SQLConection
//autor                         : Msc. Juan Carlos Badillo Goy (jcbadillogoy@gmail.com)
//fecha    creación             : 10 Junio 2012
//hist?rico de modificaciones   :                                           
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//RESUMEN
/*
  Clase abstracta para manejar el acceso a los datos en la base de datos. A partir de esta clase heredar?n las clases
  espec?ficas para cada uno de los controladores de la BD.
  Esta es una buena practica del modelo vista controlador.
 */
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../'));
set_include_path(get_include_path() . PATH_SEPARATOR . realpath('../../'));
include_once("configuracion/configuracion.php");
include_once(DRIVER_BD . "_acceso_datos.class.php");

class SQLConection {

    /** Nombre de la tabla */
    public $table;

    /** definicion de campos de la tabla
     * * @code: $instance->fields =array (	array (fieldName, class, defaultValue), ...	);
      fieldName: nombre del campo en la tabla
      class: tipo de campo (public, private, system)
     */
    public $fields;

    /** Si es verdadero los métodos de esta clase devuelven un recurso MySQL; si no, una matriz asociativa */
    private $returnSQLResult = true;

    /** Instancia del objeto de la clase conexion */
    public $objConexion;
    public $arrColumnaType = array();

    /**
     * * $table Nombre de la tabla que se manejará por esta instancia
     */
    public function __construct($table) {
        $this->arrColumnaType['bool'] = 'boolean';

        $this->arrColumnaType['bytea'] = 'byte';
        $this->arrColumnaType['bit'] = 'bit';

        $this->arrColumnaType['int8'] = 'integer';
        $this->arrColumnaType['int2'] = 'integer';
        $this->arrColumnaType['int4'] = 'integer';
        $this->arrColumnaType['serial8'] = 'integer';
        $this->arrColumnaType['serial4'] = 'integer';

        $this->arrColumnaType['float4'] = 'float';
        $this->arrColumnaType['float8'] = 'float';
        $this->arrColumnaType['money'] = 'float';
        $this->arrColumnaType['numeric'] = 'float';

        $this->arrColumnaType['text'] = 'string';
        $this->arrColumnaType['char'] = 'string';
        $this->arrColumnaType['xml'] = 'string';
        $this->arrColumnaType['bpchar'] = 'string';
        $this->arrColumnaType['varchar'] = 'string';

        $this->arrColumnaType['date'] = 'date';
        $this->arrColumnaType['time'] = 'time';
        $this->arrColumnaType['timetz'] = 'time';

        $this->arrColumnaType['timestamp'] = 'datetime';
        $this->arrColumnaType['timestamptz'] = 'datetime';

        $this->arrColumnaType['cidr'] = 'ip';
        $this->arrColumnaType['inet'] = 'ip';

        $this->arrColumnaType['macaddr'] = 'macaddress';

        $this->table = $table;
        $this->fields = array();
        $clase = ucwords(DRIVER_BD . "_Acceso_Datos");
        $this->objConexion = new $clase;
        $this->objConexion->abrirConexion();
    }

    ////////Public Methods

    /** Devuelve los registros de la tabla
     * @param $where_str: Cadena=''. Condición para filtrar resultados.
     * @param $order_str: Cadena=''. Campo sobre el que se ordenarán los registros.
     * @param $count: Entero =false . Número de registros a devolver. Si es false, toda la tabla
     * @param $start: Entero =0. Indica a partir de qué registros se devuelven datos, por default 0.
     */
    public function getRecords($where_str = false, $order_str = false, $count = false, $start = 0) {
        $where = $where_str ? "WHERE $where_str" : "";
        $order = $order_str ? "ORDER BY $order_str" : "";
        //$count = $count ? "LIMIT $start, $count" : "";
        $campos = $this->getAllFields();
        $query = "SELECT $campos FROM {$this->table} $where $order ";
        //echo  $query.'<br>';
        //die();
        return $this->objConexion->realizarConsulta($query);
    }

    /** Devuelve un registro de la tabla
     * @param $id: Entero. Id del registro a devolver.
     */
    public function getRecord($id) {
        return $this->getRecords("id=$id", false, 1);
    }

    public function insertRecord($data) {
        $arrCampos = $this->getNameFields('public');
        $arrTiposCampos = $this->objConexion->tipoColumnadeTabla($this->table);

        $current_data = '';
        foreach ($arrCampos as $index => $campo) {
            $current_data .= $this->getSQLValueString($data[$index], $this->arrColumnaType[$arrTiposCampos[$campo]]) . ',';
        }
        $current_data = substr($current_data, 0, strlen($current_data) - 1);

        $campos = implode(',', $arrCampos);
        $query = "INSERT INTO {$this->table} ($campos) VALUES ($current_data) ";
        return $this->objConexion->realizarInsertar($query);
    }

    public function updateRecord($id, $data) {
        $arrCampos = $this->getEditableFields(true);
        $arrTiposCampos = $this->objConexion->tipoColumnadeTabla($this->table);

        $datos = array();
        foreach ($arrCampos as $index => $campo) {
            $current_data = $this->getSQLValueString($data[$index], $this->arrColumnaType[$arrTiposCampos[$campo]]);
            array_push($datos, "$campo=$current_data");
        }
        $datos = implode(", ", $datos);
        $query = "UPDATE {$this->table} SET $datos WHERE id=$id ";
        return $this->objConexion->realizarInsertar($query);
    }

    public function updateRecord_by_condition($id,$condition,$data) {
        $arrCampos = $this->getEditableFields(true);
        $arrTiposCampos = $this->objConexion->tipoColumnadeTabla($this->table);

        $datos = array();
        foreach ($arrCampos as $index => $campo) {
            $current_data = $this->getSQLValueString($data[$index], $this->arrColumnaType[$arrTiposCampos[$campo]]);
            array_push($datos, "$campo=$current_data");
        }
        $datos = implode(", ", $datos);
        $query = "UPDATE {$this->table} SET $datos WHERE id=$id AND $condition";
        return $this->objConexion->realizarInsertar($query);
    }

    public function deleteRecord($id) {
        $query = "DELETE FROM {$this->table} WHERE id=$id";
        return $this->objConexion->realizarConsulta($query);
    }

////////		Private Methods

    private function getFieldsByType($type = '') {
        $return = array();
        $types = explode('|', $type);
        foreach ($this->fields as $field) {
            $includeField = false;
            foreach ($types as $t) {
                if ($field[0] == $t) {
                    array_push($return, $field);
                }
            }
        }
        return $return;
    }

    public function getNameFields($type) {
        $return = array();
        $fields = $this->getFieldsByType($type);
        foreach ($fields as $field) {
            array_push($return, $field[1]);
        }
        return $return;
    }

    public function getEditableFields($asArray = false) {
        $return = $this->getNameFields('public');
        return $asArray ? $return : implode(',', $return);
    }

    public function getTableFields($asArray = false) {
        $return = array_merge($this->getNameFields('private'), $this->getNameFields('public'));
        return $asArray ? $return : implode(',', $return);
    }

    public function getTableFieldsAll() {
        $return = array();
        foreach ($this->fields as $field) {
            array_push($return, $field[1]);
        }
        return implode(',', $return);
    }

    private function getAllFields($asArray = false) {
        $return = $this->getNameFields('public|private|system');
        return $asArray ? $return : implode(',', $return);
    }

    private function getDefaultValues($asArray = false) {
        $return = array();
        $fields = $this->getFieldsByType('private');
        foreach ($fields as $field) {
            array_push($return, $field[2]);
        }
        return $asArray ? $return : implode(',', $return);
    }

    private function validateOperation() {
        return mysql_error() == '' ? true : false;
    }

    private function getSQLValueString($theValue, $theType) {
        $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

        switch ($theType) {
            case "string":
                $theValue = ($theValue != "") ? "'" . pg_escape_string($theValue) . "'" : "NULL";
                break;
            case "integer":
                $theValue = ($theValue != "") ? intval($theValue) : "NULL";
                break;
            case "float":
                $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
                break;
            case "date":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "time":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "datetime":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "boolean":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "byte":
                $theValue = ($theValue != "") ? "'" . pg_escape_bytea($theValue) . "'" : "NULL";
                break;
            case "bit":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "ip":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
            case "macaddress":
                $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
                break;
        }
        return $theValue;
    }

}

?>