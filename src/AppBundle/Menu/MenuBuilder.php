<?php
namespace AppBundle\Menu;

use Doctrine\ORM\EntityManager;
use Knp\Menu\FactoryInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class MenuBuilder
 * @package AppBundle\Menu
 *
 * @author Clément Talleu <clement@les-tilleuls.coop>
 */
class MenuBuilder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory, EntityManager $entityManager)
    {
        $this->factory = $factory;
        $this->entityManager = $entityManager;
    }

    public function createMainMenu(Request $request)
    {
        $menu = $this->factory->createItem('root');

        $menu->addChild('menu', array('label' => 'Catégories : '));

        $categoryList = $this->entityManager->getRepository('AppBundle:Category')->findActiveCategory();

        foreach ($categoryList as $category) {

            $menu['menu']->addChild(
                'menu_'.$category->getId(),
                array(
                    'label' => $category->getTitle(),
                    'route' => 'list_page',
                    'routeParameters' =>array('categoryId' => $category->getId()),
                )
            );
        }

        return $menu;
    }
}