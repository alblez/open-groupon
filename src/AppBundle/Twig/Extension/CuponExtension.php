<?php

namespace AppBundle\Twig\Extension;

/**
 * Extensión propia de Twig con filtros y funciones útiles para
 * la application.
 */
class CuponExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('mostrar_como_lista', array($this, 'mostrarComoLista'), array('is_safe' => array('html'))),
            new \Twig_SimpleFilter('cuenta_atras', array($this, 'cuentaAtras'), array('is_safe' => array('html'))),
        );
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('discount', array($this, 'discount')),
        );
    }

    /**
     * Muestra como una lista HTML el contenido de texto al que se
     * aplica el filtro. Cada "\n" genera un nuevo elemento de
     * la lista.
     *
     * @param string $value El texto que se transforma
     * @param string $type  type de lista a generar ('ul', 'ol')
     */
    public function mostrarComoLista($value, $type = 'ul')
    {
        $html = '<'.$type.'>'.PHP_EOL;
        $html .= '  <li>'.str_replace(PHP_EOL, '</li>'.PHP_EOL.'  <li>', $value).'</li>'.PHP_EOL;
        $html .= '</'.$type.'>'.PHP_EOL;

        return $html;
    }

    /**
     * Transforma una date en una cuenta atrás actualizada en tiempo
     * real mediante JavaScript.
     *
     * La cuenta atrás se muestra en un elemento HTML con un atributo
     * `id` generado automáticamente, para que se puedan añadir varias
     * cuentas atrás en la misma page.
     *
     * @param string $date Objeto que representa la date original
     */
    public function cuentaAtras($date)
    {
        // En JavaScript los meses empiezan a contar en 0 y acaban en 12
        // En PHP los meses van de 1 a 12, por lo que hay que convertir la date
        $date = json_encode(array(
            'ano' => $date->format('Y'),
            'mes' => $date->format('m') - 1,
            'dia' => $date->format('d'),
            'hora' => $date->format('H'),
            'minuto' => $date->format('i'),
            'segundo' => $date->format('s'),
        ));

        $idAleatorio = 'cuenta-atras-'.rand(1, 100000);
        $html = <<<EOJ
        <span id="$idAleatorio"></span>

        <script type="text/javascript">
        funcion_expira = function(){
            var expira = $date;
            muestraCuentaAtras('$idAleatorio', expira);
        }
        if (!window.addEventListener) {
            window.attachEvent("onload", funcion_expira);
        } else {
            window.addEventListener('load', funcion_expira);
        }
        </script>
EOJ;

        return $html;
    }

    /**
     * Calcula el porcentaje que supone el discount indicado en euros.
     * El price no es el price original sino el price de sale (también en euros).
     *
     * @param string $price    price de sale del producto (en euros)
     * @param string $discount discount sobre el price original (en euros)
     * @param string $decimales number de decimales que muestra el discount
     */
    public function discount($price, $discount, $decimales = 0)
    {
        if (!is_numeric($price) || !is_numeric($discount)) {
            return '-';
        }

        if ($discount == 0 || $discount == null) {
            return '0%';
        }

        $precio_original = $price + $discount;
        $porcentaje = ($discount / $precio_original) * 100;

        return '-'.number_format($porcentaje, $decimales).'%';
    }

    public function getName()
    {
        return 'cupon';
    }
}
