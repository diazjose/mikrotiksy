<?php

namespace Mikrotik\PlataformaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Mikrotik\PlataformaBundle\Form\UsuariosType;
use Mikrotik\PlataformaBundle\Entity\Usuarios;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;



class UsuarioController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request) {


         $authenticationUtils = $this->get('security.authentication_utils');

                // obtener el error de login si hay
                $error = $authenticationUtils->getLastAuthenticationError();

                // último nombre de usuario introducido por el usuario
                $lastUsername = $authenticationUtils->getLastUsername();

         return $this->render('MikrotikBundle:usuarios:login.html.twig', array('last_username' => $lastUsername, 'error' => $error));
    }

    /**
     * @Route("/login_check", name="check_login")
     */
    public function loginCheckAction()
    {

    }

    /**
     * @Route("/admin/register", name="user_registration")
     */
    public function registerAction(Request $request)
    {
        // 1) Construye el formulario
        $user = new Usuarios();
        $form = $this->createForm(UsuariosType::class, $user);

        // 2) Manejamos el envío (sólo pasará con POST)
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            // 3) Codificamos el password (también se puede hacer a través de un Doctrine listener)
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRole('ROLE_USER');
            $user->setisActive(1);

            
            // 4) Guardar el usuario
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();


            $this->addFlash('mensaje', 'Se ha Creado un Usuario Nuevo');

            // ... hacer cualquier otra cosa, como enviar un email, etc
            // establecer un mensaje "flash" de éxito para el usuario

            return $this->redirectToRoute('home');
        }

        return $this->render(
            'MikrotikBundle:usuarios:register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/admin/listado_usuarios", name="user_list" )
     */
    public function listuserAction(Request $request)
    {
        /* 
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('PlataformaBundle:Usuarios')->findAll();

        return $this->render('PlataformaBundle:Plataforma:user_list.html.twig', array('users' => $users ));
        */
        $query = $request->get('query');

        if (!empty($query)) {
            /*
            $finder = $this->container->get('fos_elastica.finder.app.user');
            $user = $finder->createPaginatorAdapter($query);
            */
            $em = $this->getDoctrine()->getEntityManager();
            $user = $em->getRepository('MikrotikBundle:Usuarios')->findByUsername($query);
        }
        else{
            $em = $this->getDoctrine()->getEntityManager();
            $dql = "SELECT e FROM MikrotikBundle:Usuarios e";
            $user = $em->createQuery($dql);    
        }
        
 
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($user, $request->query->getInt('page', 1), 3);
 
        return $this->render('MikrotikBundle:Default:list_user.html.twig',
                array('pagination' => $pagination));
        
    }

    /**
     * @Route("/direccion/update", name="update_user")
     */
    public function updateAction(Request $request)
    {        
        $id = $request->get('id');

        if (!empty($id)) {
            
            
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository("MikrotikBundle:Usuarios")->find($id);
            
            if ($user) {
                
                $user->setUsername($request->get('nombre'));
                $user->setEmail($request->get('email'));
                $em->persist($user);
                $em->flush();

                $this->addFlash('notice', '¡¡ Tus cambios se han guardado !!');             
                
            }

        }
        return $this->render('MikrotikBundle:usuarios:user_update.html.twig');       

    }


}
