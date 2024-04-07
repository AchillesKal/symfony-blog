<?php

namespace App\Controller;

use App\Entity\BlogPost;
use App\Form\BlogPostType;
use App\Repository\BlogPostRepository;
use App\Service\UploaderHelper;
use Doctrine\ORM\EntityManagerInterface;
use Pagerfanta\Doctrine\ORM\QueryAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/')]
class BlogPostController extends AbstractController
{
    #[Route('', name: 'app_blog_post_index', methods: ['GET'])]
    public function index(BlogPostRepository $blogPostRepository, Request $request): Response
    {
        $queryBuilder = $blogPostRepository->createOrderByPublishedAtQueryBuilder();

        $adapter = new QueryAdapter($queryBuilder);
        $pagerfanta = Pagerfanta::createForCurrentPageWithMaxPerPage(
            $adapter,
            $request->query->get('page', 1),
            11
        );

        return $this->render('blog_post/index.html.twig', [
            'pager' => $pagerfanta,
        ]);
    }

    #[Route('blog/new', name: 'app_blog_post_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        UploaderHelper $uploaderHelper,
    ): Response {
        $form = $this->createForm(BlogPostType::class, $blogPost = new BlogPost());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($bannerFile = $form->get('banner')->getData()) {
                $blogPost->setBanner($uploaderHelper->uploadFile($bannerFile, $this->getParameter('banner_directory')));
            }

            $entityManager->persist($blogPost);
            $entityManager->flush();

            return $this->redirectToRoute('app_blog_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blog_post/new.html.twig', [
            'blog_post' => $blogPost,
            'form' => $form,
        ]);
    }

    #[Route('blog/{slug}', name: 'app_blog_post_show', methods: ['GET'])]
    public function show(BlogPost $blogPost): Response
    {
        return $this->render('blog_post/show.html.twig', [
            'blog_post' => $blogPost,
        ]);
    }

    #[Route('blog/{id}/edit', name: 'app_blog_post_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, BlogPost $blogPost, EntityManagerInterface $entityManager, UploaderHelper $uploaderHelper): Response
    {
        $form = $this->createForm(BlogPostType::class, $blogPost);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->has('delete_banner') && $form->get('delete_banner')->getData()) {
                if ($blogPost->getBanner()) {
                    unlink($this->getParameter('banner_directory').'/'.$blogPost->getBanner());
                    $blogPost->setBanner(null);
                }
            }

            if ($bannerFile = $form->get('banner')->getData()) {
                if ($blogPost->getBanner()) {
                    unlink($this->getParameter('banner_directory').'/'.$blogPost->getBanner());
                }

                $blogPost->setBanner($uploaderHelper->uploadFile($bannerFile, $this->getParameter('banner_directory')));
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_blog_post_show', ['slug' => $blogPost->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('blog_post/edit.html.twig', [
            'blog_post' => $blogPost,
            'form' => $form,
        ]);
    }

    #[Route('blog/{id}', name: 'app_blog_post_delete', methods: ['POST'])]
    public function delete(Request $request, BlogPost $blogPost, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$blogPost->getId(), $request->request->get('_token'))) {
            if ($blogPost->getBanner()) {
                unlink($this->getParameter('banner_directory').'/'.$blogPost->getBanner());
            }

            $entityManager->remove($blogPost);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_blog_post_index', [], Response::HTTP_SEE_OTHER);
    }
}
