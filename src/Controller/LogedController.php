<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManager;
class LogedController extends AbstractController
{
    /**
     * @Route("/loged", name="loged")
     */
    public function index(UserRepository $repository)
    {
        $roles=$this->this->getUser()->getRoles();
        if (in_array('ROLE_SUPER',$roles)) {
            $result=$repository->all();
        }else if (in_array('ROLE_ADMIN',$roles)) {
            $result=$repository->searchRole($roles);
        }else {
            $result=$this->getDoctrine()->getRepository(User::class)->findBy($this->getUser()->getRoles());
            # code...
        }
        return $this->render('loged/index.html.twig', [
            'controller_name'=>'RoleControler',
            'user' => $this->getUser()->getUsername(),
            'roles'=>$this->getUser()->getRoles(),
            'others'=>$result,
        ]);
        /*
        return $this->render('loged/index.html.twig', [
            'user' => $this->getUser()->getUsername(),
            'roles'=>$this->getUser()->getRoles()
        ]);*/
    }
}
