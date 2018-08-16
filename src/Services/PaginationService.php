<?php
namespace App\Services;

use App\Repository\SpotRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PaginationService
{
    public function __construct(SpotRepository $spotRepository)
    {
        $this->spotRepository = $spotRepository;
    }

    public function paginationHome($page)
    {
        $nbSpots = $this->spotRepository->countAllSpots();
        $nbPages = ceil($nbSpots /12);
        if ($page != 1 && $page > $nbPages) {
            throw new NotFoundHttpException("La page n'existe pas");
        }
         $pagination = [
             'page' => $page,
             'nbPages' => $nbPages,
            'nbSpots' => $nbSpots,
         ];
        return $pagination;
    }


}