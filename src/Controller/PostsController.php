<?php

declare(strict_types=1);

namespace App\Controller;

use Cake\View\JsonView;

/**
 * Posts Controller
 *
 * @property \App\Model\Table\PostsTable $Posts
 */
class PostsController extends AppController
{
    public function viewClasses(): array
    {
        return [JsonView::class];
    }

    public function view(int $id)
    {
        $post = $this->Posts->get($id);
        $this->set(compact('post'));
        $this->viewBuilder()->setOption('serialize', 'post');
    }
}
