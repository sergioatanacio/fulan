<?php
require __DIR__.'/PhpFunctionalLanguage.php';

/**
 * Permite debuguear una variable en php.
 */
if(! function_exists('pre'))
{
    function pre($pre)
    {
        echo '<pre>';
        var_dump($pre);
        echo '</pre>';
    }
}

/**
 * Inicia la sesión de una persona.
 */
function sessionStarted()
{
    return iffn(
        fn()=>!isset($_SESSION), 
        function()
            {
                session_start();
                $_SESSION['session'] = true;
                return $_SESSION['session']; 
            },
        fn()=>false
    );
    /*
    if(!isset($_SESSION)){ session_start();}
    $_SESSION['session'] = true;*/
}

/**
 * Hace que las personas que accedan al recurso en cuestión deban tener la sesión iniciada.
 */
function activeSession(string $direction = '')
{
    def($sessionStarted, run(
        function()
            {
                if(!isset($_SESSION)){ session_start();}
                return (!isset($_SESSION['session'])) 
                    ? false : $_SESSION['session'];
            }
        )
    );

    return iffn(
        fn()=>$sessionStarted === false,
        function() use ($direction)
        {
            header("Location:" . domain($direction));
            die();
        }
    );

    /*
    if(!isset($_SESSION)){ session_start();}
    $sessionStarted = (!isset($_SESSION['session'])) ? false : $_SESSION['session'] ;

    if ($sessionStarted == false) {
        header("Location:" . domain($direction));
        die();
    }
    */
}

function active_session_get_boolean()
{
    return run(
        function()
            {
                if(!isset($_SESSION)){ session_start();}
                return 
                (!isset($_SESSION['session']))  ? false : 
                (($_SESSION['session'] !== true) ? false : true);
            }
    );
}


/**
 * La ejecución de esta función cierra la sesión de una persona.
 */
function sessionEnded()
{
    return iffn(
        fn()=>!isset($_SESSION), 
        function()
            {
                session_start();
                $_SESSION['session'] = false;
                return $_SESSION['session']; 
            },
        fn()=>true
    );
    
    /*if(!isset($_SESSION)){ session_start();}
    $_SESSION['session'] = false;*/
}

/**
 * Permite imprimir el string de una función y elimina el 1 que sale si es que eso sale al final.
 */
function printFunction($printFunction)
{
    echo(rtrim($printFunction, '1'));
}

