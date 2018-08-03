<?php
namespace App\Services;


use App\Repository\CommentRepository;
use App\Repository\OpinionRepository;
use App\Repository\SpotRepository;
use App\Repository\UserRepository;

class PageDecoratorsService
{

    public function __construct(SpotRepository $spotRepository,CommentRepository $commentRepository,UserRepository $userRepository,OpinionRepository $opinionRepository)
    {
        $this->spotRepository = $spotRepository;
        $this->commentRepository = $commentRepository;
        $this->userRepository = $userRepository;
        $this->opinionRepository = $opinionRepository;

    }

    public function recupData()
   {
       $totalNbSpots = $this->spotRepository->countAllSpots();
       $totalNbComments = $this->commentRepository->countAllComments();
       $totalNbUsers = $this->userRepository->countAllUsers();
       $totalNbOpinions = $this->opinionRepository->countAllOpinions();

      return array(
          $totalNbSpots,
          $totalNbComments,
          $totalNbUsers,
          $totalNbOpinions
      );
   }

   public function recupDataByUser()
   {

   }
}