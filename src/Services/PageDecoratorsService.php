<?php
namespace App\Services;


use App\Repository\CommentRepository;
use App\Repository\LikeRepository;
use App\Repository\OpinionRepository;
use App\Repository\SpotRepository;
use App\Repository\TreeRepository;
use App\Repository\UserRepository;

class PageDecoratorsService
{

    public function __construct(SpotRepository $spotRepository,CommentRepository $commentRepository,UserRepository $userRepository,OpinionRepository $opinionRepository, TreeRepository $treeRepository, LikeRepository $likeRepository)
    {
        $this->spotRepository = $spotRepository;
        $this->commentRepository = $commentRepository;
        $this->userRepository = $userRepository;
        $this->opinionRepository = $opinionRepository;
        $this->treeRepository = $treeRepository;
        $this->likeRepository = $likeRepository;

    }

    public function recupAllData()
   {
       $totalNbSpots = $this->spotRepository->countAllSpots();
       $totalNbComments = $this->commentRepository->countAllComments();
       $totalNbUsers = $this->userRepository->countAllUsers();
       $totalNbOpinions = $this->opinionRepository->countAllOpinions();
       $totalNbLikes = $this->likeRepository->countAllLikes();
       $totalNbTrees = $this->treeRepository->countAllTrees();
       $result = array(
           'totalNbSpots' => $totalNbSpots,
           'totalNbComments' => $totalNbComments,
           'totalNbUsers' => $totalNbUsers,
           'totalNbOpinions'=> $totalNbOpinions,
           'totalNbLikes' => $totalNbLikes,
           'totalNbTrees' => $totalNbTrees
       );
       return $result;
   }

   public function recupDataByUser($userId)
   {
       $totalNbSpotsByUser = $this->spotRepository->countSpotsByUser($userId);
       $totalNbCommentsByUser = $this->commentRepository->countCommentsByUser($userId);
       $result = array(
           'totalNbSpotsByUser' => $totalNbSpotsByUser,
           'totalNbCommentsByUser' => $totalNbCommentsByUser
       );
       return $result;
   }
}