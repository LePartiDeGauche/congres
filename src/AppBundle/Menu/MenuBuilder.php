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
    	$menu->setChildrenAttribute('class', 'nav navbar-nav');

        $categories = $this->entityManager->getRepository('AppBundle:Category')->findActiveCategory();

        foreach ($categories as $category) {
            $submenu = $menu->addChild($category->getTitle());
            $submenu->setAttribute('dropdown', true);
            foreach ($category->getPages() as $page) {
                if ($page->isIsActive()) {
                    $submenu->addChild(
                        $page->getTitle(),
                        array(
                            'label' => $page->getTitle(),
                            'route' => 'page_show',
                            'routeParameters' => array('id' => $page->getId()),
                        )
                    );
                }
            }
        }
        return $menu;
    }
}
