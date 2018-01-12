<?php

namespace Mikrotik\PlataformaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Mikrotik\PlataformaBundle\Form\UsuariosType;
use Mikrotik\PlataformaBundle\Entity\Usuarios;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
	/**
     * @Route("/", name="home")
     */
    public function indexAction()
    {
        return $this->render('MikrotikBundle:Default:home.html.twig');
    }

}
