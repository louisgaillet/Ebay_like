<?php

 namespace ProductsBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class BidManager
    {

    protected $em;
    private $tokenStorage;
    private $form;
    private $user;
    private $bidding;
    private $repository;
    private $minBid;
    private $productId;
    private $product;
    private $session;
    private $message;
    private $error;
    private $status = true;


        public function __construct(EntityManagerInterface $entityManager, TokenStorageInterface $tokenStorage)
        {
            $this->em = $entityManager;
            $this->repository = $this->em->getRepository('ProductsBundle:history_bidding');
            $this->tokenStorage = $tokenStorage;
            $this->user = $this->tokenStorage->getToken()->getUser();
            $this->session = new Session();
        }

        public function setForm($form){
            $this->form = $form;
            return $this;
        }

        public  function init($id, $bidding){
            $this->productId = $id;
            $this->bidding = $bidding;
            $this->minBid = $this->repository->getlastBid($id);
            $this->product = $this->em->getRepository('ProductsBundle:Product')->find($id);
            $this->setMinBid();
            $this->checkBid();
            $this->checkBuy();
            $this->checkDate();
            $this->create();
            return [$this->message, $this->error];


        }

         // if value form < previous value + minBid
        protected function checkBid(){
            if( $this->form->get('bid')->getData() < $this->minBid) {
                dump($this->form->get('bid')->getData() < $this->minBid);
                $this->error = "Une erreur s'est produite  Votre enchère est trop petite. L'enchère doit être au minimum de  $this->minBid  € .";
                $this->status = false;
            }
        }

        // if value form >= price product
        protected  function checkBuy(){
            if ( $this->form->get('bid')->getData() >= $this->product->getPrice()) {
                $this->error = 'Achat';
                $this->status = false;
            }
        }

    protected function checkDate(){

                $dateEnd = $this->product->getDateEnd();
                $dateNow = (new \DateTime("now"));
                $dateNow->modify('+1 hour');
                if($dateEnd > $dateNow == false){
                    $this->status = false;
                    $this->error = "Trop tard quelqu'un à déjà remporté l'enchère";
                }


    }


        protected  function create(){
            if($this->status == true ){
                $this->bidding->setUser($this->user);
                $this->bidding->setProduct($this->product);
                $this->em->persist($this->bidding);
                $this->em->flush();
                $this->message =  "Votre enchère à bien été pris en compte";
            }

        }

        public function getHistory($id){
            $this->product = $this->em->getRepository('ProductsBundle:Product')->find($id);
            $history =  $this->em
                ->getRepository('ProductsBundle:history_bidding')
                ->findBy(array('product' => $this->product->getId()));
            return array_reverse($history);

        }



        protected  function setMinBid(){
            if ($this->minBid == null)
                $this->minBid = $this->product->getStartingPrice();
            else{
                $this->minBid = $this->minBid["bid"];
            }
            $this->minBid = $this->minBid + $this->product->getMinBid();
        }

}