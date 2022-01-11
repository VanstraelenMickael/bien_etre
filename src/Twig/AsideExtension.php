<?php
namespace App\Twig;

use App\Repository\CategorieDeServicesRepository;
use App\Repository\CodePostalRepository;
use App\Repository\CommuneRepository;
use App\Repository\LocaliteRepository;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class AsideExtension extends AbstractExtension{

    private $categorie;
    private $codePostal;
    private $localite;
    private $commune;
    private $twig;

    public function __construct(CategorieDeServicesRepository $categorie, CodePostalRepository $codePostal, LocaliteRepository $localite, CommuneRepository $commune, Environment $twig){
        $this->categorie = $categorie;
        $this->codePostal = $codePostal;
        $this->localite = $localite;
        $this->commune = $commune;
        $this->twig = $twig;
    }

    public function getFunctions(): array{
        return [
            new TwigFunction('aside',[$this, 'getAside'],['is_safe' => ['html']])
        ];
    }

    public function getAside(): string{
        $categories = $this->categorie->findBy(
            array(),
            array('nom' => 'ASC')
        );

        $localites = $this->localite->findBy(
            array(),
            array('localite' => 'ASC')
        );
        
        $codePostaux = $this->codePostal->findBy(
            array(),
            array('codePostal' => 'ASC')
        );
        
        $communes = $this->commune->findBy(
            array(),
            array('commune' => 'ASC')
        );

        return $this->twig->render('components/aside.html.twig', [
            'categories' => $categories,
            'localites' => $localites,
            'codePostaux' => $codePostaux,
            'communes' => $communes
        ]);
    }

}