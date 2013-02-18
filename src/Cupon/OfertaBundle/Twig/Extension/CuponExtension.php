<?php

namespace Cupon\OfertaBundle\Twig\Extension;

use Symfony\Component\Translation\TranslatorInterface;

/**
 * Extensión propia de Twig con filtros y funciones útiles para
 * la application
 */
class CuponExtension extends \Twig_Extension
{
    private $translator;

    public function __construct(TranslatorInterface $translator = null)
    {
        $this->translator = $translator;
    }

    public function getTranslator()
    {
        return $this->translator;
    }

    public function getFilters()
    {
        return array(
            'mostrar_como_lista' => new \Twig_Filter_Method($this, 'mostrarComoLista', array('is_safe' => array('html'))),
            'cuenta_atras' => new \Twig_Filter_Method($this, 'cuentaAtras', array('is_safe' => array('html'))),
            'date' => new \Twig_Filter_Method($this, 'date'),
        );
    }

    public function getFunctions()
    {
        return array(
            'discount' => new \Twig_Function_Method($this, 'discount')
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
    public function mostrarComoLista($value, $type='ul')
    {
        $html = "<".$type.">".PHP_EOL;
        $html .= "  <li>".str_replace(PHP_EOL, "</li>".PHP_EOL."  <li>", $value)."</li>".PHP_EOL;
        $html .= "</".$type.">".PHP_EOL;

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
            'mes' => $date->format('m')-1,
            'dia' => $date->format('d'),
            'hora'    => $date->format('H'),
            'minuto'  => $date->format('i'),
            'segundo' => $date->format('s')
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
     * Formatea la date indicada según las características del locale seleccionado.
     * Se utiliza para mostrar correctamente las fechas en el idioma de cada user.
     *
     * @param string $date        Objeto que representa la date original
     * @param string $formatoFecha Formato con el que se muestra la date
     * @param string $formatoHora  Formato con el que se muestra la hora
     * @param string $locale       El locale al que se traduce la date
     */
    public function date($date, $formatoFecha = 'medium', $formatoHora = 'none', $locale = null)
    {
        // code copiado de
        //   https://github.com/thaberkern/symfony/blob
        //   /b679a23c331471961d9b00eb4d44f196351067c8
        //   /src/Symfony/Bridge/Twig/Extension/TranslationExtension.php

        // Formatos: http://www.php.net/manual/en/class.intldateformatter.php#intl.intldateformatter-constants
        $formatos = array(
            // date/Hora: (no se muestra nada)
            'none'   => \IntlDateFormatter::NONE,
            // date: 12/13/52  Hora: 3:30pm
            'short'  => \IntlDateFormatter::SHORT,
            // date: Jan 12, 1952  Hora:
            'medium' => \IntlDateFormatter::MEDIUM,
            // date: January 12, 1952  Hora: 3:30:32pm
            'long'   => \IntlDateFormatter::LONG,
            // date: Tuesday, April 12, 1952 AD  Hora: 3:30:42pm PST
            'full'   => \IntlDateFormatter::FULL,
        );

        $formateador = \IntlDateFormatter::create(
            $locale != null ? $locale : $this->getTranslator()->getLocale(),
            $formatos[$formatoFecha],
            $formatos[$formatoHora]
        );

        if ($date instanceof \DateTime) {
            return $formateador->format($date);
        } else {
            return $formateador->format(new \DateTime($date));
        }
    }

    /**
     * Calcula el porcentaje que supone el discount indicado en euros.
     * El price no es el price original sino el price de sale (también en euros)
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
