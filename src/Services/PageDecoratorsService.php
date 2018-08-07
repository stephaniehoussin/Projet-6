<?php
namespace App\Services;


use App\Repository\CommentRepository;
use App\Repository\FavorisRepository;
use App\Repository\LoveRepository;
use App\Repository\OpinionRepository;
use App\Repository\SpotRepository;
use App\Repository\TreeRepository;
use App\Repository\UserRepository;

class PageDecoratorsService
{

    public function __construct(SpotRepository $spotRepository, CommentRepository $commentRepository,FavorisRepository $favorisRepository, UserRepository $userRepository, OpinionRepository $opinionRepository, TreeRepository $treeRepository, LoveRepository $loveRepository)
    {
        $this->spotRepository = $spotRepository;
        $this->commentRepository = $commentRepository;
        $this->userRepository = $userRepository;
        $this->opinionRepository = $opinionRepository;
        $this->treeRepository = $treeRepository;
        $this->loveRepository = $loveRepository;
        $this->favorisRepository = $favorisRepository;

    }

    public function countAllData()
   {
       $totalNbSpots = $this->spotRepository->countAllSpots();
       $totalNbComments = $this->commentRepository->countAllComments();
       $totalNbUsers = $this->userRepository->countAllUsers();
       $totalNbOpinions = $this->opinionRepository->countAllOpinions();
       $totalNbLoves = $this->loveRepository->countAllLoves();
       $totalNbTrees = $this->treeRepository->countAllTrees();
       $totalNbFavoris = $this->favorisRepository->countAllFavoris();
       $allResult = array(
           'totalNbSpots' => $totalNbSpots,
           'totalNbComments' => $totalNbComments,
           'totalNbUsers' => $totalNbUsers,
           'totalNbOpinions'=> $totalNbOpinions,
           'totalNbLoves' => $totalNbLoves,
           'totalNbTrees' => $totalNbTrees,
           'totalNbFavoris' => $totalNbFavoris
       );
       return $allResult;
   }

   public function countDataByUser($userId)
   {
       $totalNbSpotsByUser = $this->spotRepository->countSpotsByUser($userId);
       $totalNbCommentsByUser = $this->commentRepository->countCommentsByUser($userId);
       $totalNbTreesByUser = $this->treeRepository->countTreesByUser($userId);
       $totalNbLovesByUser = $this->loveRepository->countLovesByUser($userId);
       $totalNbOpinionsByUser = $this->opinionRepository->countOpinionsByUser($userId);
       $totalNbFavorisByUser = $this->favorisRepository->countFavorisByUser($userId);
       $resultByUser = array(
           'totalNbSpotsByUser' => $totalNbSpotsByUser,
           'totalNbCommentsByUser' => $totalNbCommentsByUser,
           'totalNbTreesByUser' => $totalNbTreesByUser,
           'totalNbLovesByUser' => $totalNbLovesByUser,
           'totalNbOpinionsByUser' => $totalNbOpinionsByUser,
           'totalNbFavorisByUser' => $totalNbFavorisByUser
       );
       return $resultByUser;
   }

   public function countDataBySpot($spotId)
   {
       $totalNbCommentsBySpot = $this->commentRepository->countCommentsBySpot($spotId);
       $totalNbLovesBySpot = $this->loveRepository->countLovesBySpot($spotId);
       $totalNbTreesBySpot= $this->treeRepository->countTreesBySpot($spotId);
       $resultBySpot = array(
           'totalNbCommentsBySpot' => $totalNbCommentsBySpot,
           'totalNbLovesBySpot' => $totalNbLovesBySpot,
           'totalNbTreesBySpot' => $totalNbTreesBySpot
       );
       return $resultBySpot;
   }
}