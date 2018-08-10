<?php
namespace App\Services;


use App\Repository\CommentRepository;
use App\Repository\FavorisRepository;
use App\Repository\LoveRepository;
use App\Repository\SpotRepository;
use App\Repository\TreeRepository;
use App\Repository\UserRepository;

class PageDecoratorsService
{

    public function __construct(SpotRepository $spotRepository, CommentRepository $commentRepository,FavorisRepository $favorisRepository, UserRepository $userRepository, TreeRepository $treeRepository, LoveRepository $loveRepository)
    {
        $this->spotRepository = $spotRepository;
        $this->commentRepository = $commentRepository;
        $this->userRepository = $userRepository;
        $this->treeRepository = $treeRepository;
        $this->loveRepository = $loveRepository;
        $this->favorisRepository = $favorisRepository;

    }

    public function countAllData()
   {
       $totalNbSpots = $this->spotRepository->countAllSpots();
       $totalNbComments = $this->commentRepository->countAllComments();
       $totalNbUsers = $this->userRepository->countAllUsers();
       $totalNbLoves = $this->loveRepository->countAllLoves();
       $totalNbTrees = $this->treeRepository->countAllTrees();
       $totalNbFavoris = $this->favorisRepository->countAllFavoris();
       $allResult = array(
           'totalNbSpots' => $totalNbSpots,
           'totalNbComments' => $totalNbComments,
           'totalNbUsers' => $totalNbUsers,
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
       $totalNbFavorisByUser = $this->favorisRepository->countFavorisByUser($userId);
       $totalNbSpotsValidatedByUser = $this->spotRepository->countSpotsValidatedByUser($userId);
       $totalNbSpotsWaitingByUser = $this->spotRepository->countSpotsWaitingByUser($userId);
       $resultByUser = array(
           'totalNbSpotsByUser' => $totalNbSpotsByUser,
           'totalNbCommentsByUser' => $totalNbCommentsByUser,
           'totalNbTreesByUser' => $totalNbTreesByUser,
           'totalNbLovesByUser' => $totalNbLovesByUser,
           'totalNbFavorisByUser' => $totalNbFavorisByUser,
           'totalNbSpotsValidatedByUser' => $totalNbSpotsValidatedByUser,
           'totalNbSpotsWaitingByUser' => $totalNbSpotsWaitingByUser
       );
       return $resultByUser;
   }

   public function countDataBySpot($spotId)
   {
       $totalNbCommentsBySpot = $this->commentRepository->countCommentsBySpot($spotId);
       $totalNbLovesBySpot = $this->loveRepository->countLovesBySpot($spotId);
       $totalNbTreesBySpot= $this->treeRepository->countTreesBySpot($spotId);
       $totalNbFavorisBySpot= $this->favorisRepository->countFavorisBySpot($spotId);
       $resultBySpot = array(
           'totalNbCommentsBySpot' => $totalNbCommentsBySpot,
           'totalNbLovesBySpot' => $totalNbLovesBySpot,
           'totalNbTreesBySpot' => $totalNbTreesBySpot,
           'totalNbFavorisBySpot' => $totalNbFavorisBySpot
       );
       return $resultBySpot;
   }
}