<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Posts Controller
 *
 * @property \App\Model\Table\PostsTable $Posts
 */
class PostsController extends AppController
{
  public function initialize(): void
  {
    parent::initialize();
    $this->loadComponent('RequestHandler');
  }

  public function view(int $id) {
    $post = $this->Posts->get($id);
    $this->set(compact('post'));
    $this->viewBuilder()->setOption('serialize', 'post');
  }
}
