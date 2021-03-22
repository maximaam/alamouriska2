<?php
declare(strict_types=1);

namespace App\Service;

use App\Utils\ModelUtils;
use Knp\Menu\FactoryInterface;
use Doctrine\ORM\EntityManager;
use Knp\Menu\ItemInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use function sprintf, strpos, strstr, ucfirst;

/**
 * Class NavBuilder
 * @package App\Service
 */
class NavBuilder
{
    /**
     * @var FactoryInterface
     */
    private FactoryInterface $factory;

    /**
     * @var EntityManager
     */
    private EntityManager $entityManager;

    /**
     * @var RequestStack
     */
    private RequestStack $requestStack;


    const MAIN_NAV = [
      ['label' => 'Mots', 'route' => 'index'],
    ];

    /**
     * NavBuilder constructor.
     * @param FactoryInterface $factory
     * @param EntityManager $entityManager
     * @param RequestStack $requestStack
     */
    public function __construct(FactoryInterface $factory, EntityManager $entityManager, RequestStack $requestStack)
    {
        $this->factory = $factory;
        $this->entityManager = $entityManager;
        $this->requestStack = $requestStack;
    }

    /**
     * @param array $options
     * @return ItemInterface
     */
    public function mainMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'navbar-nav mr-auto');


        foreach (ModelUtils::ENTITY_DOMAIN as $domain => $entity) {
            $menu->addChild(ucfirst(strstr($domain, '-', true)), [
                'route' => 'post_index',
                'routeParameters' => [
                    'domain' => $domain //SEO route
                ],
                /*
                'extras'    => [
                    'routes'    =>
                        ['route' => 'post_show', 'parameters' => [
                            'domain' => $domain,
                            'id'    => $this->requestStack->getMasterRequest()->request->get('id'),
                            'slug'  => $this->requestStack->getMasterRequest()->request->get('slug'),
                        ]],
                ],
                */
                'attributes' => [
                    'class' => 'nav-item rounded',
                    'title' => sprintf('Ajouter des %s', $domain)
                ],
                'linkAttributes' => [
                    'class' => 'nav-link'
                ]
            ]);
        }

        //Set current for sub items
        $uri = $this->requestStack->getCurrentRequest()->getRequestUri();
        switch (true) {
            case strpos($uri, 'mots'):
                $menu->getChild('Mots')->setCurrent(true);
                break;
            case strpos($uri, 'expressions'):
                $menu->getChild('Expressions')->setCurrent(true);
                break;
            case strpos($uri, 'proverbes'):
                $menu->getChild('Proverbes')->setCurrent(true);
                break;
            case strpos($uri, 'blagues'):
                $menu->getChild('Blagues')->setCurrent(true);
                break;
            case strpos($uri, 'blogs'):
                $menu->getChild('Blogs')->setCurrent(true);
                break;

            default:
                $menu->setCurrent(true);
        }

        return $menu;
    }


    /**
     * @param array $options
     * @return ItemInterface
     */
    public function footerMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        $menu->setChildrenAttribute('class', 'footer-nav list-unstyled text-right');
        $pages = $this->em->getRepository(Page::class)->findBy(['embedded' => false]);

        /** @var Page $page */
        foreach ($pages as $page) {
            $menu->addChild($page->getTitle(), [
                'route' => 'index_page',
                'attributes' => ['class' => ''],
                'linkAttributes' => ['class' => 'footer'],
                'routeParameters' => [
                    'alias' => $page->getAlias(),
                ]
            ]);
        }

        return $menu;
    }
}