<?php

/*
 * (c) Javier Eguiluz <javier.eguiluz@gmail.com>
 *
<<<<<<< HEAD
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Comando que envía cada día un email a todos los usuarios que lo
 * permiten con la información de la offer del día en su city.
 */
class EmailOfertaDelDiaCommand extends ContainerAwareCommand
{
    private $host;
    private $accion;
    /** @var ContainerInterface */
    private $contenedor;
    /** @var ObjectManager */
    private $em;
    /** @var SymfonyStyle */
    private $io;

    protected function configure()
    {
        $this
            ->setName('app:email:offer-del-dia')
            ->setDefinition(array(
                new InputOption('accion', false, InputOption::VALUE_OPTIONAL, 'Indica si los emails realmente se envían a sus destinatarios o sólo se generan'),
            ))
            ->setDescription('Genera y envía a cada user el email con la offer diaria')
            ->setHelp(<<<EOT
El comando <info>email:offer-del-dia</info> genera y envía un email con la
offer del día de la city en la que se ha apuntado el user. También tiene
en cuenta si el user permite el envío o no de publicidad.
EOT
        );
    }

    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        $this->host = 'dev' === $input->getOption('env') ? 'http://cupon.local' : 'http://cupon.com';
        $this->accion = $input->getOption('accion');
        $this->contenedor = $this->getContainer();
        $this->em = $this->contenedor->get('doctrine')->getManager();
        $this->io = new SymfonyStyle($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->io->title('Mailing - offer del día');

        $destinatarios = $this->em->getRepository('AppBundle:user')->findBy(array('permiteEmail' => true));
        $this->io->text(sprintf('Se van a enviar <info>%d</info> emails', count($destinatarios)));

        $ofertasDelDia = $this->findOfertasDelDia();
        foreach ($destinatarios as $destinatario) {
            $city = $destinatario->getCiudad();
            $offer = $ofertasDelDia[$city->getId()];

            $contenido = $this->contenedor->get('twig')->render('email/oferta_del_dia.html.twig', array(
                'host' => $this->host,
                'city' => $city,
                'offer' => $offer,
                'user' => $destinatario,
            ));

            $asunto = sprintf('[offer del día] %s en %s', $offer->getNombre(), $offer->getTienda()->getNombre());
            $this->enviarEmail($destinatario, $asunto, $contenido);
        }

        if ('enviar' !== $this->accion) {
            $this->io->comment(array(
                'NOTA: No se ha enviado ningún email.',
                'Para enviar los emails a sus destinatarios, ejecuta el comando con la opción <info>accion</info>.',
                'Ejemplo: <info>./app/console email:offer-del-dia --accion=enviar</info>',
            ));
        }

        $this->io->success(sprintf('%d emails enviados con la offer del día', count($destinatarios)));
    }

    /**
     * Busca la 'offer del día' en todas las ciudades de la application.
     *
     * @return array
     */
    private function findOfertasDelDia()
    {
        $ofertas = array();
        $ciudades = $this->em->getRepository('AppBundle:city')->findAll();
        foreach ($ciudades as $city) {
            $id = $city->getId();
            $slug = $city->getSlug();

            $ofertas[$id] = $this->em->getRepository('AppBundle:offer')->findOfertaDelDiaSiguiente($slug);
        }

        return $ofertas;
    }

    /**
     * @param string $destinatario
     * @param string $asunto
     * @param string $contenido
     */
    private function enviarEmail($destinatario, $asunto, $contenido)
    {
        if ('enviar' === $this->accion) {
            $email = \Swift_Message::newInstance()
                ->setSubject($asunto)
                ->setFrom(array('offer-del-dia@cupon.com' => 'Cupon - offer del día'))
                ->setTo($destinatario->getEmail())
                ->setBody($contenido, 'text/html')
            ;

            $this->contenedor->get('mailer')->send($email);
||||||| parent of ab1dc88 (Eliminados todos los bundles para usar solo AppBundle)
=======
 * Este file pertenece a la application de prueba Cupon.
 * El code fuente de la application incluye un file llamado LICENSE
 * con toda la información sobre el copyright y la licencia.
 */

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Comando que envía cada día un email a todos los usuarios que lo
 * permiten con la información de la offer del día en su city.
 */
class EmailOfertaDelDiaCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('email:offer-del-dia')
            ->setDefinition(array(
                new InputOption('accion', false, InputOption::VALUE_OPTIONAL, 'Indica si los emails realmente se envían a sus destinatarios o sólo se generan'),
            ))
            ->setDescription('Genera y envía a cada user el email con la offer diaria')
            ->setHelp(<<<EOT
El comando <info>email:offer-del-dia</info> genera y envía un email con la
offer del día de la city en la que se ha apuntado el user. También tiene
en cuenta si el user permite el envío o no de publicidad.
EOT
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $host = 'dev' == $input->getOption('env') ? 'http://cupon.local' : 'http://cupon.com';
        $accion = $input->getOption('accion');

        $contenedor = $this->getContainer();
        $em = $contenedor->get('doctrine')->getManager();

        // Obtener el listado de usuarios que permiten el envío de email
        $usuarios = $em->getRepository('UsuarioBundle:user')->findBy(array('permite_email' => true));

        $output->writeln(sprintf(' Se van a enviar <info>%s</info> emails', count($usuarios)));

        // Buscar la 'offer del día' en todas las ciudades de la application
        $ofertas = array();
        $ciudades = $em->getRepository('AppBundle:city')->findAll();
        foreach ($ciudades as $city) {
            $id = $city->getId();
            $slug = $city->getSlug();

            $ofertas[$id] = $em->getRepository('AppBundle:offer')->findOfertaDelDiaSiguiente($slug);
        }

        // Generar el email personalizado de cada user
        foreach ($usuarios as $user) {
            $city = $user->getCiudad();
            $offer = $ofertas[$city->getId()];

            $contenido = $contenedor->get('twig')->render(
                'BackendBundle:offer:email.html.twig',
                array('host' => $host, 'city' => $city, 'offer' => $offer, 'user' => $user)
            );

            // Enviar el email
            if ('enviar' == $accion) {
                $email = \Swift_Message::newInstance()
                    ->setSubject($offer->getNombre().' en '.$offer->getTienda()->getNombre())
                    ->setFrom(array('offer-del-dia@cupon.com' => 'Cupon - offer del día'))
                    ->setTo($user->getEmail())
                    ->setBody($contenido, 'text/html')
                ;
                $this->getContainer()->get('mailer')->send($email);
            }
        }

        if ('enviar' != $accion) {
            $output->writeln("\n No se ha enviado ningún email. Para enviar los emails a sus destinatarios,\n ejecuta el comando con la opción <info>accion</info>. Ejemplo:\n <info>./app/console email:offer-del-dia --accion=enviar</info>\n");
>>>>>>> ab1dc88 (Eliminados todos los bundles para usar solo AppBundle)
        }
    }
}
