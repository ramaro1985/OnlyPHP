<style>
table td, th {
    white-space: nowrap;
}
</style>
<?php 
include_once("utiles/utils.class.php");

switch ($_GET["error"]) {
    case 1:
        echo Utils::getDivErrorLogin( $label["usuario_pass_incorrecto"] );
        break;
    case 2:
        echo Utils::getDivErrorLogin( $label["acceso_denegado"] );
        break;
    case 3:
        echo Utils::getDivErrorLogin( $label["acceso_usuario_deshabilitado"] );
        break;
}

echo Utils::getDivTituloLogin( $label["iniciar_sesion"], $_GET["error"]);

    // include the Zebra_Form class
    require 'Zebra_Form.php';

    // instantiate a Zebra_Form object
    $form = new Zebra_Form('form', 'POST', '../negocio/crud_login.php', array('onsubmit' => 'return encriptarClave(\'password\');'));

    // the label for the "login" field
    $form->add('label', 'label_name', 'login', $label["usuario"].":");

    // add the "login" field
    $obj = $form->add('text', 'login', '', array('autocomplete' => 'off', 'onclick' => 'ocultardiv(\'div_error\');'));

    // set rules
    $obj->set_rule(array(
        // error messages will be sent to a variable called "error", usable in custom templates
        'required'      =>  array('error', $label["usuario_obligatorio"]),
    ));

    // "password"
    $form->add('label', 'label_password', 'password', $label["clave"].":");

    $obj = & $form->add('password', 'password', '', array('autocomplete' => 'off', 'onclick' => 'ocultardiv(\'div_error\');'));

    $obj->set_rule(array(

        'required'  => array('error', $label["contrasena_obligatoria"]),
        'minlength' => array(6, 'error', $label["contrasena_minimo"]),

    ));

    // "submit"
    $form->add('submit', 'btnsubmit', $label["ingresar"]);
    
    // validate the form
    if ($form->validate()) { 

            // do stuff here
    }

    // auto generate output, labels to the left of form elements
    $form->render('*horizontal');
?>